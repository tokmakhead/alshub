import { PrismaClient } from "@prisma/client";

const prisma = new PrismaClient();

async function main() {
  console.log("Seeding started...");

  // 1. Roles
  const roles = ["ADMIN", "EDITOR"];
  for (const roleName of roles) {
    await prisma.role.upsert({
      where: { name: roleName as any },
      update: {},
      create: { name: roleName as any },
    });
  }
  console.log("Roles seeded.");

  // 2. Sources
  const sources = [
    { name: "PubMed", base_url: "https://eutils.ncbi.nlm.nih.gov/entrez/eutils" },
    { name: "ClinicalTrials.gov", base_url: "https://clinicaltrials.gov/api/v2" },
    { name: "openFDA", base_url: "https://api.fda.gov" },
    { name: "DailyMed", base_url: "https://dailymed.nlm.nih.gov/dailymed/services/v2" },
  ];

  for (const source of sources) {
    await prisma.source.upsert({
      where: { name: source.name },
      update: { base_url: source.base_url },
      create: { name: source.name, base_url: source.base_url },
    });
  }
  console.log("Sources seeded.");

  console.log("Seeding finished.");
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
