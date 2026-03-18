export interface AIResult {
  text: string;
  usage?: {
    promptTokens: number;
    completionTokens: number;
    totalTokens: number;
  };
}

export interface IAIProvider {
  providerName: string;
  modelName: string;
  generate(prompt: string, options?: any): Promise<AIResult>;
}
