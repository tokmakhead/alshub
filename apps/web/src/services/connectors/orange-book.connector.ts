import { BaseConnector } from "./base";
import { OrangeBookRaw } from "@/types/fda-official";
import { db } from "@/lib/db";
import { config } from "@/lib/config";

export class OrangeBookConnector extends BaseConnector<OrangeBookRaw, any> {
  sourceName = "Orange Book";

  async fetchRaw(params?: any): Promise<OrangeBookRaw[]> {
    const baseUrl = config.sources.openFda.baseUrl;
    const applNo = params?.applNo || "020427"; // Rilutek example

    const response = await fetch(`${baseUrl}/drug/orangebook.json?search=appl_no:${applNo}`, {
      method: "GET",
      headers: { "Accept": "application/json" },
    });

    if (!response.ok) return [];
    const data = await response.json();
    return data.results || [];
  }

  normalize(raw: OrangeBookRaw): any {
    return {
      applicationNumber: raw.appl_no,
      type: raw.type,
      patentExpiration: raw.patent_expiration_date,
    };
  }

  validate(normalized: any): boolean {
    return !!normalized.applicationNumber;
  }

  async upsert(normalized: any, raw: OrangeBookRaw): Promise<void> {
    const source = await db.source.findUnique({ where: { name: this.sourceName } });
    if (!source) throw new Error(`Source ${this.sourceName} not found in DB`);

    // Traceability only for Orange Book as it's secondary data
    await db.sourceRecord.upsert({
      where: {
        sourceId_externalId: {
          sourceId: source.id,
          externalId: `${normalized.applicationNumber}-${raw.product_no}`,
        },
      },
      update: { rawData: raw as any, fetchDate: new Date() },
      create: {
        sourceId: source.id,
        externalId: `${normalized.applicationNumber}-${raw.product_no}`,
        rawData: raw as any,
      },
    });
  }
}
