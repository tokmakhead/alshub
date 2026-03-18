import { NextResponse } from "next/server";
import { SyncOrchestrator } from "@/services/sync-orchestrator.service";
import { config } from "@/lib/config";

export async function GET(request: Request) {
  const { searchParams } = new URL(request.url);
  const secret = searchParams.get("secret");

  if (secret !== config.security.cronSecret) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  const orchestrator = new SyncOrchestrator();
  const result = await orchestrator.syncAll();

  return NextResponse.json(result);
}
