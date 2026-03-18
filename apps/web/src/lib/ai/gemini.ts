import { GoogleGenerativeAI } from "@google/generative-ai";
import { IAIProvider, AIResult } from "./provider";
import { config } from "@/lib/config";

export class GeminiProvider implements IAIProvider {
  providerName = "Gemini";
  modelName = "gemini-1.5-flash"; // Default fast model
  private genAI: GoogleGenerativeAI;

  constructor(apiKey: string) {
    this.genAI = new GoogleGenerativeAI(apiKey);
  }

  async generate(prompt: string, options?: any): Promise<AIResult> {
    const model = this.genAI.getGenerativeModel({ 
      model: options?.model || this.modelName 
    });

    const result = await model.generateContent(prompt);
    const response = await result.response;
    const text = response.text();

    return {
      text,
      // Gemini SDK v1 doesn't return token usage easily in the basic call, 
      // but we could use result.usageMetadata if available in newer versions.
    };
  }
}
