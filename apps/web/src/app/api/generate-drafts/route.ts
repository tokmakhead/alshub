import { NextResponse } from "next/server";
import { auth } from "@/lib/auth";
import { AIGeneratorService } from "@/services/ai-generator.service";

export const dynamic = "force-dynamic";

export async function GET() {
  const session = await auth();
  
  // Basic security: require session or a secret header for cron
  if (!session) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
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
