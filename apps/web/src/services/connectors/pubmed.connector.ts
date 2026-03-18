import { BaseConnector } from "./base";
import { PubMedRaw, NormalizedPublication } from "@/types/pubmed";
import { db } from "@/lib/db";
import { config } from "@/lib/config";

export class PubMedConnector extends BaseConnector<any, NormalizedPublication> {
  sourceName = "PubMed";

  async fetchRaw(params?: any): Promise<any[]> {
    const baseUrl = config.sources.pubMed.baseUrl;
    const term = params?.term || "Amyotrophic Lateral Sclerosis";
    
    // 1. esearch to get PMIDs
    const searchUrl = `${baseUrl}/esearch.fcgi?db=pubmed&term=${encodeURIComponent(term)}&retmode=json&retmax=10`;
    const searchRes = await fetch(searchUrl);
    if (!searchRes.ok) throw new Error("PubMed search failed");
    const searchData = await searchRes.json();
    const pmids = searchData.esearchresult.idlist || [];

    if (pmids.length === 0) return [];

    // 2. efetch to get details (Note: efetch returns XML, for simplicity we'll handle the logic here)
    // In a real scenario, we'd use an XML parser like fast-xml-parser
    const fetchUrl = `${baseUrl}/efetch.fcgi?db=pubmed&id=${pmids.join(",")}&retmode=xml`;
    const fetchRes = await fetch(fetchUrl);
    if (!fetchRes.ok) throw new Error("PubMed fetch failed");
    
    const xmlText = await fetchRes.text();
    // We'll return mock-parsed objects for the "skeleton/implementation" flow 
    // to demonstrate the connector pattern. 
    // Real XML parsing would happen here or in a helper.
    return pmids.map((id: string) => ({ pmid: id, xml: xmlText })); // Simplified
  }

  normalize(raw: any): NormalizedPublication {
    // This is where we'd parse the specific XML for this PMID
    // Using placeholders for demonstrating the model flow
    return {
      pmid: raw.pmid,
      title: "Sample Publication Title",
      authors: "Doe J, Smith A",
      journal: "ALS Journal",
      pubDate: new Date(),
      abstract: "This is a sample abstract about ALS research.",
    };
  }

  validate(normalized: NormalizedPublication): boolean {
    return !!normalized.pmid && !!normalized.title;
  }

  async upsert(normalized: NormalizedPublication, raw: any): Promise<void> {
    const source = await db.source.findUnique({ where: { name: this.sourceName } });
    if (!source) throw new Error(`Source ${this.sourceName} not found in DB`);

    // 1. Traceability
    await db.sourceRecord.upsert({
      where: {
        sourceId_externalId: {
          sourceId: source.id,
          externalId: normalized.pmid,
        },
      },
      update: { rawData: raw as any, fetchDate: new Date() },
      create: {
        sourceId: source.id,
        externalId: normalized.pmid,
        rawData: raw as any,
      },
    });

    // 2. Save Normalized Publication
    await db.publication.upsert({
      where: { pmid: normalized.pmid },
      update: {
        title: normalized.title,
        authors: normalized.authors,
        journal: normalized.journal,
        pubDate: normalized.pubDate,
        abstract: normalized.abstract,
      },
      create: {
        pmid: normalized.pmid,
        title: normalized.title,
        authors: normalized.authors,
        journal: normalized.journal,
        pubDate: normalized.pubDate,
        abstract: normalized.abstract,
      },
    });
  }
}
