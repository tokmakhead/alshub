import { NextRequest, NextResponse } from "next/server";
export const dynamic = 'force-dynamic';
import { db } from "@/lib/db";
import { AIGeneratorService } from "@/services/ai-generator.service";

export async function GET(req: NextRequest) {
  return POST(req);
}

export async function POST(req: NextRequest) {
  try {
    console.log("AI Generation: Route entered.");
    
    // DB Test
    const userCount = await db.user.count();
    console.log(`AI Generation: DB Connection OK (User Count: ${userCount})`);

    const aiService = new AIGeneratorService();
    let totalGenerated = 0;

    // 1. Identify missing Drug drafts
    const existingDrugIds = await db.editorialContent.findMany({
      where: { refType: "DRUG" },
      select: { refId: true },
    }).then(items => items.map(i => i.refId));

    const drugsToProcess = await db.drug.findMany({
      where: { id: { notIn: existingDrugIds } },
      take: 1, 
    });

    for (const drug of drugsToProcess) {
      await aiService.generateDraft("DRUG", drug.id, drug);
      totalGenerated++;
    }

    // 2. Identify missing Trial drafts
    const existingTrialIds = await db.editorialContent.findMany({
      where: { refType: "TRIAL" },
      select: { refId: true },
    }).then(items => items.map(i => i.refId));

    const trialsToProcess = await db.trial.findMany({
      where: { id: { notIn: existingTrialIds } },
      take: 1,
    });

    for (const trial of trialsToProcess) {
      await aiService.generateDraft("TRIAL", trial.id, trial);
      totalGenerated++;
    }

    // 3. Identify missing Publication drafts
    const existingPubIds = await db.editorialContent.findMany({
      where: { refType: "PUBLICATION" },
      select: { refId: true },
    }).then(items => items.map(i => i.refId));

    const pubsToProcess = await db.publication.findMany({
      where: { id: { notIn: existingPubIds } },
      take: 1,
    });

    for (const pub of pubsToProcess) {
      await aiService.generateDraft("PUBLICATION", pub.id, pub);
      totalGenerated++;
    }

    return NextResponse.json({
      success: true,
      message: `${totalGenerated} yeni taslak başarıyla üretildi.`,
      count: totalGenerated,
    });

  } catch (error: any) {
    console.error("CRITICAL API ERROR:", error);
    return NextResponse.json(
      { 
        error: error.message, 
        stack: error.stack,
        hint: "Check environment variables (DATABASE_URL, GEMINI_API_KEY) and DB connection."
      },
      { status: 500 }
    );
  }
}
