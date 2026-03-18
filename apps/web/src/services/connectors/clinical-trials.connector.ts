import { BaseConnector, SyncResult } from "./base";
import { ClinicalTrialRaw, NormalizedTrial } from "@/types/clinical-trials";
import { db } from "@/lib/db";
import { config } from "@/lib/config";

export class ClinicalTrialsConnector extends BaseConnector<ClinicalTrialRaw, NormalizedTrial> {
  sourceName = "ClinicalTrials.gov";

  async fetchRaw(params?: any): Promise<ClinicalTrialRaw[]> {
    const baseUrl = config.sources.clinicalTrials.baseUrl;
    const query = new URLSearchParams({
      "query.cond": "Amyotrophic Lateral Sclerosis",
      "pageSize": "10", // Limit for testing, can be increased
      ...params,
    });

    const response = await fetch(`${baseUrl}/studies?${query.toString()}`, {
      method: "GET",
      headers: { "Accept": "application/json" },
    });

    if (!response.ok) {
      throw new Error(`ClinicalTrials API error: ${response.statusText}`);
    }

    const data = await response.json();
    return data.studies || [];
  }

  normalize(raw: ClinicalTrialRaw): NormalizedTrial {
    const ps = raw.protocolSection;
    return {
      nctId: ps.identificationModule.nctId,
      title: ps.identificationModule.officialTitle || "Untitled Study",
      phase: ps.designModule?.phases?.join(", ") || "N/A",
      status: ps.statusModule.overallStatus,
      startDate: ps.statusModule.startDateStruct?.date 
        ? new Date(ps.statusModule.startDateStruct.date) 
        : null,
    };
  }

  validate(normalized: NormalizedTrial): boolean {
    return !!normalized.nctId && !!normalized.title;
  }

  async upsert(normalized: NormalizedTrial, raw: ClinicalTrialRaw): Promise<void> {
    const source = await db.source.findUnique({ where: { name: this.sourceName } });
    if (!source) throw new Error(`Source ${this.sourceName} not found in DB`);

    // 1. Save Raw Record
    const sourceRecord = await db.sourceRecord.upsert({
      where: {
        sourceId_externalId: {
          sourceId: source.id,
          externalId: normalized.nctId,
        },
      },
      update: { rawData: raw as any, fetchDate: new Date() },
      create: {
        sourceId: source.id,
        externalId: normalized.nctId,
        rawData: raw as any,
      },
    });

    // 2. Save Normalized Trial
    await db.trial.upsert({
      where: { nctId: normalized.nctId },
      update: {
        title: normalized.title,
        phase: normalized.phase,
        status: normalized.status,
        startDate: normalized.startDate,
      },
      create: {
        nctId: normalized.nctId,
        title: normalized.title,
        phase: normalized.phase,
        status: normalized.status,
        startDate: normalized.startDate,
      },
    });
  }
}
