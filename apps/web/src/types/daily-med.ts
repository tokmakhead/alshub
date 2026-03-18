export interface DailyMedSplRaw {
  setid: string;
  spl_version: string;
  published_date: string;
  title: string;
}

export interface NormalizedSpl {
  setId: string;
  version: string;
  title: string;
  publishedDate: Date | null;
}
