export type SearchResultType = "DRUG" | "TRIAL" | "PUBLICATION" | "EDITORIAL";

export interface SearchResultItem {
  id: number;
  type: SearchResultType;
  title: string;
  excerpt: string;
  slug?: string;
}

export interface UnifiedSearchResult {
  query: string;
  items: SearchResultItem[];
}
