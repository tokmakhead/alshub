import { PubMedConnector } from "@/services/connectors/pubmed.connector";
import { db } from "@/lib/db";

async function main() {
  const connector = new PubMedConnector();
  console.log(`Starting sync for ${connector.sourceName}...`);
  
  const result = await connector.sync();
  
  // Log to SyncJob table
  const source = await db.source.findUnique({ where: { name: connector.sourceName } });
  if (source) {
    await db.syncJob.create({
      data: {
        sourceId: source.id,
        status: result.failedCount > 0 ? "FAILED" : "COMPLETED",
        message: `Processed: ${result.processedCount}, Success: ${result.successCount}, Failed: ${result.failedCount}. Errors: ${result.errors.join("; ")}`,
      },
    });
  }

  console.log("Sync Result:", result);
}

main()
  .catch(console.error)
  .finally(() => db.$disconnect());
