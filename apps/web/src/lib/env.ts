import { z } from "zod";

const envSchema = z.object({
  // Core
  DATABASE_URL: z.string().min(1),
  APP_ENV: z.enum(["development", "staging", "production"]).default("development"),
  LOG_LEVEL: z.enum(["debug", "info", "warn", "error"]).default("info"),

  // URLs
  NEXT_PUBLIC_SITE_URL: z.string().url(),
  NEXT_PUBLIC_APP_NAME: z.string().default("ALS Hub"),

  // Security
  CRON_SECRET: z.string().min(16),
  SESSION_SECRET: z.string().min(32),

  // AI
  GEMINI_API_KEY: z.string().min(1),
  AI_DEFAULT_PROVIDER: z.string().default("gemini"),

  // Sources
  CLINICALTRIALS_BASE_URL: z.string().url().default("https://clinicaltrials.gov/api/v2"),
  PUBMED_BASE_URL: z.string().url().default("https://eutils.ncbi.nlm.nih.gov/entrez/eutils"),
  OPENFDA_BASE_URL: z.string().url().default("https://api.fda.gov"),
  DAILYMED_BASE_URL: z.string().url().default("https://dailymed.nlm.nih.gov/dailymed/services/v2"),
  DRUGSFDA_BASE_URL: z.string().optional(),
  ORANGEBOOK_SOURCE_PATH: z.string().optional(),
});

export const env = envSchema.parse({
  DATABASE_URL: process.env.DATABASE_URL,
  APP_ENV: process.env.APP_ENV,
  LOG_LEVEL: process.env.LOG_LEVEL,
  NEXT_PUBLIC_SITE_URL: process.env.NEXT_PUBLIC_SITE_URL || "http://localhost:3000",
  NEXT_PUBLIC_APP_NAME: process.env.NEXT_PUBLIC_APP_NAME,
  CRON_SECRET: process.env.CRON_SECRET,
  SESSION_SECRET: process.env.SESSION_SECRET,
  GEMINI_API_KEY: process.env.GEMINI_API_KEY,
  AI_DEFAULT_PROVIDER: process.env.AI_DEFAULT_PROVIDER,
  CLINICALTRIALS_BASE_URL: process.env.CLINICALTRIALS_BASE_URL,
  PUBMED_BASE_URL: process.env.PUBMED_BASE_URL,
  OPENFDA_BASE_URL: process.env.OPENFDA_BASE_URL,
  DAILYMED_BASE_URL: process.env.DAILYMED_BASE_URL,
  DRUGSFDA_BASE_URL: process.env.DRUGSFDA_BASE_URL,
  ORANGEBOOK_SOURCE_PATH: process.env.ORANGEBOOK_SOURCE_PATH,
});
