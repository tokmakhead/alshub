export interface PubMedRaw {
  pmid: string;
  title: string;
  authors: string[];
  journal: string;
  pubDate: string;
  abstract: string;
}

export interface NormalizedPublication {
  pmid: string;
  title: string;
  authors: string;
  journal: string;
  pubDate: Date | null;
  abstract: string;
}
