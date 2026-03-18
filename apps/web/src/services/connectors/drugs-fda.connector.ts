import { BaseConnector } from "./base";
import { DrugsFdaRaw, NormalizedFdaOfficial } from "@/types/fda-official";
import { db } from "@/lib/db";
import { config } from "@/lib/config";

export class DrugsFdaConnector extends BaseConnector<DrugsFdaRaw, NormalizedFdaOfficial> {
  sourceName = "Drugs@FDA";

  async fetchRaw(params?: any): Promise<DrugsFdaRaw[]> {
    const baseUrl = config.sources.openFda.baseUrl;
    // Search for ALS drugs in Drugs@FDA
    // Often we search by name from previous steps or known list
    const drugName = params?.drugName || "Riluzole";

    const response = await fetch(`${baseUrl}/drug/drugsfda.json?search=products.brand_name:${drugName}&limit=5`, {
      method: "GET",
      headers: { "Accept": "application/json" },
    });

    if (!response.ok) return [];
    const data = await response.json();
    return data.results || [];
  }

  normalize(raw: DrugsFdaRaw): NormalizedFdaOfficial {
    const originalSubmission = raw.submissions?.find(s => s.submission_type === "ORIG");
    
    return {
      applicationNumber: raw.application_number,
      sponsor: raw.sponsor_name,
      brandName: raw.products?.[0]?.brand_name || "Unknown",
      marketingStatus: raw.products?.[0]?.marketing_status || "Unknown",
      approvalDate: originalSubmission?.submission_public_status_date || null,
    };
  }

  validate(normalized: NormalizedFdaOfficial): boolean {
    return !!normalized.applicationNumber;
  }

  async upsert(normalized: NormalizedFdaOfficial, raw: DrugsFdaRaw): Promise<void> {
    const source = await db.source.findUnique({ where: { name: this.sourceName } });
    if (!source) throw new Error(`Source ${this.sourceName} not found in DB`);

    // 1. Traceability
    await db.sourceRecord.upsert({
      where: {
        sourceId_externalId: {
          sourceId: source.id,
          externalId: normalized.applicationNumber,
        },
      },
      update: { rawData: raw as any, fetchDate: new Date() },
      create: {
        sourceId: source.id,
        externalId: normalized.applicationNumber,
        rawData: raw as any,
      },
    });

    // 2. Official Verification Logic
    // Update existing drug with FDA Approved status if marketing_status is "Prescription" or "Over-the-counter"
    const isApproved = normalized.marketingStatus.toLowerCase().includes("prescription");
    
    await db.drug.updateMany({
      where: { name: { contains: normalized.brandName } },
      data: {
        status: isApproved ? "FDA Approved" : normalized.marketingStatus,
        company: normalized.sponsor,
      },
    });
  }
}
