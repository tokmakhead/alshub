import { BaseConnector } from "./base";
import { DailyMedSplRaw, NormalizedSpl } from "@/types/daily-med";
import { db } from "@/lib/db";
import { config } from "@/lib/config";

export class DailyMedConnector extends BaseConnector<DailyMedSplRaw, NormalizedSpl> {
  sourceName = "DailyMed";

  async fetchRaw(params?: any): Promise<DailyMedSplRaw[]> {
    const baseUrl = config.sources.dailyMed.baseUrl;
    // We fetch SPLs by drug name or just general ALS drug names if we have a list
    // For this implementation, we'll assume we can pass a drug name
    const drugName = params?.drugName || "Riluzole"; // Default for trial
    
    const response = await fetch(`${baseUrl}/spls.json?drug_name=${encodeURIComponent(drugName)}`, {
      method: "GET",
      headers: { "Accept": "application/json" },
    });

    if (!response.ok) {
      if (response.status === 404) return [];
      throw new Error(`DailyMed API error: ${response.statusText}`);
    }

    const data = await response.json();
    return data.data || [];
  }

  normalize(raw: DailyMedSplRaw): NormalizedSpl {
    return {
      setId: raw.setid,
      version: raw.spl_version,
      title: raw.title,
      publishedDate: raw.published_date ? new Date(raw.published_date) : null,
    };
  }

  validate(normalized: NormalizedSpl): boolean {
    return !!normalized.setId && !!normalized.title;
  }

  async upsert(normalized: NormalizedSpl, raw: DailyMedSplRaw): Promise<void> {
    const source = await db.source.findUnique({ where: { name: this.sourceName } });
    if (!source) throw new Error(`Source ${this.sourceName} not found in DB`);

    // 1. Save Raw Record for Traceability
    await db.sourceRecord.upsert({
      where: {
        sourceId_externalId: {
          sourceId: source.id,
          externalId: normalized.setId,
        },
      },
      update: { rawData: raw as any, fetchDate: new Date() },
      create: {
        sourceId: source.id,
        externalId: normalized.setId,
        rawData: raw as any,
      },
    });

    // 2. Merge Strategy: Update existing Drug records with DailyMed title/version if applicable
    // This is a simple merge by name match or setId if we had it
    // For now, we log the enrichment
    console.log(`Enriching data for ${normalized.title} from DailyMed`);
  }
}
