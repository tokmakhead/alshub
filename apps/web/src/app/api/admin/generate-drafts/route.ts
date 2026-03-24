import { NextRequest, NextResponse } from "next/server";
import { auth } from "@/lib/auth";
import { db } from "@/lib/db";
import { AIGeneratorService } from "@/services/ai-generator.service";

export async function POST(req: NextRequest) {
  const session = await auth();

  // 1. Security Check
  if (session?.user?.role !== "ADMIN") {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  try {
    const aiService = new AIGeneratorService();
    let totalGenerated = 0;

    // 2. Identify missing Drug drafts
    const existingDrugIds = await db.editorialContent.findMany({
      where: { refType: "DRUG" },
      select: { refId: true },
    }).then(items => items.map(i => i.refId));

    const drugsToProcess = await db.drug.findMany({
      where: { id: { notIn: existingDrugIds } },
      take: 5, // Limit per call to avoid timeouts
    });

    for (const drug of drugsToProcess) {
      await aiService.generateDraft("DRUG", drug.id, drug);
      totalGenerated++;
    }

    // 3. Identify missing Trial drafts
    const existingTrialIds = await db.editorialContent.findMany({
      where: { refType: "TRIAL" },
      select: { refId: true },
    }).then(items => items.map(i => i.refId));

    const trialsToProcess = await db.trial.findMany({
      where: { id: { notIn: existingTrialIds } },
      take: 5,
    });

    for (const trial of trialsToProcess) {
      await aiService.generateDraft("TRIAL", trial.id, trial);
      totalGenerated++;
    }

    // 4. Identify missing Publication drafts
    const existingPubIds = await db.editorialContent.findMany({
      where: { refType: "PUBLICATION" },
      select: { refId: true },
    }).then(items => items.map(i => i.refId));

    const pubsToProcess = await db.publication.findMany({
      where: { id: { notIn: existingPubIds } },
      take: 5,
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

  } catch (error) {
    console.error("Generate Drafts Error:", error);
    return NextResponse.json(
      { error: "İçerik üretilirken bir hata oluştu." },
      { status: 500 }
    );
  }
}
