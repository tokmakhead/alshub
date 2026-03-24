import { GeminiProvider } from "@/lib/ai/gemini";
import { PROMPTS } from "@/lib/ai/prompts";
import { config } from "@/lib/config";
import { db } from "@/lib/db";
import { RefType } from "@alshub/shared";

export class AIGeneratorService {
  private provider: GeminiProvider;

  constructor() {
    this.provider = new GeminiProvider(config.ai.geminiKey);
  }

  async generateDraft(refType: RefType, refId: number, data: any) {
    let prompt = "";
    let title = "Yeni İçerik";

    switch (refType) {
      case "DRUG":
        const drug = await db.drug.findUnique({ where: { id: refId } });
        title = drug?.name || title;
        prompt = PROMPTS.DRUG_SUMMARY(title, data);
        break;
      case "TRIAL":
        const trial = await db.trial.findUnique({ where: { id: refId } });
        title = trial?.title || title;
        prompt = PROMPTS.TRIAL_SUMMARY(title, data);
        break;
      case "PUBLICATION":
        const pub = await db.publication.findUnique({ where: { id: refId } });
        title = pub?.title || title;
        prompt = PROMPTS.PUB_SUMMARY(title, pub?.abstract || "");
        break;
    }

    const aiJob = await db.aIJob.create({
      data: {
        provider: this.provider.providerName,
        model: this.provider.modelName,
        prompt,
        status: "PROCESSING",
      },
    });

    try {
      const result = await this.provider.generate(prompt);
      
      await db.aIJob.update({
        where: { id: aiJob.id },
        data: { response: result.text, status: "COMPLETED" },
      });

      // Create or Update Editorial Content as Draft
      const slug = title.toLowerCase().replace(/ /g, "-").slice(0, 50);
      
      const editorial = await db.editorialContent.upsert({
        where: { slug },
        update: {
          content: result.text,
          aiJobId: aiJob.id,
        },
        create: {
          slug,
          title,
          content: result.text,
          status: "DRAFT",
          refType,
          refId,
          aiJobId: aiJob.id,
        },
      });

      // Create a version for traceability
      await db.editorialVersion.create({
        data: {
          editorialContentId: editorial.id,
          title,
          content: result.text,
        },
      });

      return editorial;
    } catch (error) {
      await db.aIJob.update({
        where: { id: aiJob.id },
        data: { status: "FAILED" },
      });
      throw error;
    }
  }

  async generateDraftsForUnprocessedRecords() {
    const results = { drugs: 0, trials: 0, publications: 0 };

    // 1. Process Drugs
    const processedDrugIds = (await db.editorialContent.findMany({
      where: { refType: "DRUG" },
      select: { refId: true }
    })).map(c => c.refId);

    const unprocessedDrugs = await db.drug.findMany({
      where: {
        id: { notIn: processedDrugIds.length > 0 ? processedDrugIds : [-1] }
      },
      take: 2
    });

    for (const drug of unprocessedDrugs) {
      await this.generateDraft("DRUG", drug.id, drug);
      results.drugs++;
    }

    // 2. Process Trials
    const processedTrialIds = (await db.editorialContent.findMany({
      where: { refType: "TRIAL" },
      select: { refId: true }
    })).map(c => c.refId);

    const unprocessedTrials = await db.trial.findMany({
      where: {
        id: { notIn: processedTrialIds.length > 0 ? processedTrialIds : [-1] }
      },
      take: 2
    });

    for (const trial of unprocessedTrials) {
      await this.generateDraft("TRIAL", trial.id, trial);
      results.trials++;
    }

    return results;
  }
}
