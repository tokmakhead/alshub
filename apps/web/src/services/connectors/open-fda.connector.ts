import { BaseConnector } from "./base";
import { OpenFdaDrugRaw, NormalizedDrug } from "@/types/open-fda";
import { db } from "@/lib/db";
import { config } from "@/lib/config";

export class OpenFdaConnector extends BaseConnector<OpenFdaDrugRaw, NormalizedDrug> {
  sourceName = "openFDA";

  async fetchRaw(params?: any): Promise<OpenFdaDrugRaw[]> {
    const baseUrl = config.sources.openFda.baseUrl;
    const query = new URLSearchParams({
      "search": 'indications_and_usage:"amyotrophic lateral sclerosis"',
      "limit": "10",
      ...params,
    });

    const response = await fetch(`${baseUrl}/drug/label.json?${query.toString()}`, {
      method: "GET",
      headers: { "Accept": "application/json" },
    });

    if (!response.ok) {
      if (response.status === 404) return []; // No results found
      throw new Error(`openFDA API error: ${response.statusText}`);
    }

    const data = await response.json();
    return data.results || [];
  }

  normalize(raw: OpenFdaDrugRaw): NormalizedDrug {
    const ofda = raw.openfda;
    return {
      externalId: raw.id,
      name: ofda?.brand_name?.[0] || ofda?.generic_name?.[0] || "Unknown Drug",
      company: ofda?.manufacturer_name?.[0] || "Unknown Company",
      status: ofda?.product_type?.[0] || "N/A",
    };
  }

  validate(normalized: NormalizedDrug): boolean {
    return !!normalized.externalId && !!normalized.name;
  }

  async upsert(normalized: NormalizedDrug, raw: OpenFdaDrugRaw): Promise<void> {
    const source = await db.source.findUnique({ where: { name: this.sourceName } });
    if (!source) throw new Error(`Source ${this.sourceName} not found in DB`);

    // 1. Save Raw Record for Traceability
    await db.sourceRecord.upsert({
      where: {
        sourceId_externalId: {
          sourceId: source.id,
          externalId: normalized.externalId,
        },
      },
      update: { rawData: raw as any, fetchDate: new Date() },
      create: {
        sourceId: source.id,
        externalId: normalized.externalId,
        rawData: raw as any,
      },
    });

    // 2. Save Normalized Drug
    await db.drug.upsert({
      where: { name: normalized.name }, // Use name as unique or combine with externalId
      update: {
        company: normalized.company,
        status: normalized.status,
      },
      create: {
        name: normalized.name,
        company: normalized.company,
        status: normalized.status,
      },
    });
  }
}
