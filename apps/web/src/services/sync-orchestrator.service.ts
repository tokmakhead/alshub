import { db } from "@/lib/db";
import { ClinicalTrialsConnector } from "./connectors/clinical-trials.connector";
import { OpenFdaConnector } from "./connectors/open-fda.connector";
import { DailyMedConnector } from "./connectors/daily-med.connector";
import { PubMedConnector } from "./connectors/pubmed.connector";

export class SyncOrchestrator {
  private static isRunning = false;

  async syncAll() {
    if (SyncOrchestrator.isRunning) {
      console.log("Sync already in progress. Skipping...");
      return { success: false, message: "Already running" };
    }

    SyncOrchestrator.isRunning = true;
    const results: any[] = [];

    try {
      const connectors = [
        new ClinicalTrialsConnector(),
        new OpenFdaConnector(),
        new PubMedConnector(),
        // DailyMed is usually an enrichment step, but can be part of sync
      ];

      for (const connector of connectors) {
        console.log(`Starting sync for ${connector.sourceName}...`);
        const result = await connector.sync();
        results.push({ name: connector.sourceName, result });
        
        // Log to SyncJob table
        const source = await db.source.findUnique({ where: { name: connector.sourceName } });
        if (source) {
          await db.syncJob.create({
            data: {
              sourceId: source.id,
              status: result.failedCount > 0 ? "FAILED" : "COMPLETED",
              message: `Processed: ${result.processedCount}, Success: ${result.successCount}, Failed: ${result.failedCount}`,
            },
          });
        }
      }

      return { success: true, results };
    } catch (error) {
      console.error("Sync Orchestrator Error:", error);
      return { success: false, error: (error as Error).message };
    } finally {
      SyncOrchestrator.isRunning = false;
    }
  }

  async syncSource(sourceName: string) {
    // Similar logic but for a single source
  }
}
