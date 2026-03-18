import { db } from "@/lib/db";
import { UnifiedSearchResult, SearchResultItem } from "@/types/search";

export class SearchService {
  async unifiedSearch(query: string): Promise<UnifiedSearchResult> {
    if (!query || query.length < 3) return { query, items: [] };

    const items: SearchResultItem[] = [];

    // 1. Search Editorial Content (Primary)
    const editorials = await db.$queryRaw<any[]>`
      SELECT id, title, summary as excerpt, slug 
      FROM EditorialContent 
      WHERE MATCH(title, summary, content) AGAINST(${query} IN NATURAL LANGUAGE MODE)
      AND status = 'PUBLISHED'
      LIMIT 10
    `;
    items.push(...editorials.map(e => ({ ...e, type: 'EDITORIAL' as const })));

    // 2. Search Drugs
    const drugs = await db.$queryRaw<any[]>`
      SELECT id, name as title, company as excerpt 
      FROM Drug 
      WHERE MATCH(name) AGAINST(${query} IN NATURAL LANGUAGE MODE)
      LIMIT 5
    `;
    items.push(...drugs.map(d => ({ ...d, type: 'DRUG' as const })));

    // 3. Search Trials
    const trials = await db.$queryRaw<any[]>`
      SELECT id, title, nctId as excerpt 
      FROM Trial 
      WHERE MATCH(title) AGAINST(${query} IN NATURAL LANGUAGE MODE)
      LIMIT 5
    `;
    items.push(...trials.map(t => ({ ...t, type: 'TRIAL' as const })));

    // 4. Search Publications
    const pubs = await db.$queryRaw<any[]>`
      SELECT id, title, authors as excerpt 
      FROM Publication 
      WHERE MATCH(title, abstract) AGAINST(${query} IN NATURAL LANGUAGE MODE)
      LIMIT 5
    `;
    items.push(...pubs.map(p => ({ ...p, type: 'PUBLICATION' as const })));

    return { query, items };
  }
}
