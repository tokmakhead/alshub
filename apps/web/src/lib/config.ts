import { env } from "./env";

export const config = {
  app: {
    name: env.NEXT_PUBLIC_APP_NAME,
    env: env.APP_ENV,
    url: env.NEXT_PUBLIC_SITE_URL,
    isDev: env.APP_ENV === "development",
  },
  ai: {
    provider: env.AI_DEFAULT_PROVIDER,
    geminiKey: env.GEMINI_API_KEY,
  },
  sources: {
    clinicalTrials: { baseUrl: env.CLINICALTRIALS_BASE_URL },
    pubMed: { baseUrl: env.PUBMED_BASE_URL },
    openFda: { baseUrl: env.OPENFDA_BASE_URL },
    dailyMed: { baseUrl: env.DAILYMED_BASE_URL },
  },
  security: {
    cronSecret: env.CRON_SECRET,
    sessionSecret: env.SESSION_SECRET,
  },
  logging: {
    level: env.LOG_LEVEL,
  },
};
