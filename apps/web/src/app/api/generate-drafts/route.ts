import { NextRequest, NextResponse } from "next/server";
import { auth } from "@/lib/auth";
import { AIGeneratorService } from "@/services/ai-generator.service";
import { db } from "@/lib/db";

export const dynamic = "force-dynamic";

export async function GET(req: NextRequest) {
  try {
    // Check for root-level session bypass (only for initial testing if needed, but let's try with auth)
    const session = await auth();
    if (!session || session.user?.role !== "ADMIN") {
      return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
    }

    // Test DB Connection
    await db.$queryRaw`SELECT 1`;

    const results = await AIGeneratorService.generateDraftsForUnprocessedRecords();
    
    return NextResponse.json({ 
      success: true, 
      message: "AI Draft generation completed successfully.",
      results 
    });
  } catch (error: any) {
    console.error("AI Draft Generation Error:", error);
    return NextResponse.json({ 
      success: false, 
      error: error.message,
      stack: process.env.NODE_ENV === 'development' ? error.stack : undefined
    }, { status: 500 });
  }
}

// POST support
export async function POST(req: NextRequest) {
  return GET(req);
}
