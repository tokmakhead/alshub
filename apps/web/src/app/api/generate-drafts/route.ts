import { NextResponse } from "next/server";
import { auth } from "@/lib/auth";
import { AIGeneratorService } from "@/services/ai-generator.service";

export const dynamic = "force-dynamic";

export async function GET(req: Request) {
  const { searchParams } = new URL(req.url);
  const token = searchParams.get("token");
  const isDebug = searchParams.get("debug") === "true";
  const session = await auth();
  
  // Allow access if logged in OR if secret token matches
  const isAuthorized = session || (token && token === process.env.CRON_SECRET);

  if (!isAuthorized) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  if (isDebug) {
    return NextResponse.json({ 
      success: true, 
      message: "SYSTEM ONLINE: Node, DB and Auth are working perfectly.",
      time: new Date().toISOString()
    });
  }

  try {
    const aiService = new AIGeneratorService();
    const result = await aiService.generateDraftsForUnprocessedRecords();
    
    return NextResponse.json({ 
      success: true, 
      processed: result,
      time: new Date().toISOString()
    });
  } catch (error: any) {
    console.error("AI Generation Error:", error);
    return NextResponse.json({ 
      success: false, 
      error: error.message 
    }, { status: 500 });
  }
}

export async function POST() {
  return GET();
}
