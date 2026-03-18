export interface ClinicalTrialRaw {
  protocolSection: {
    identificationModule: {
      nctId: string;
      officialTitle: string;
    };
    statusModule: {
      overallStatus: string;
      startDateStruct?: {
        date: string;
      };
    };
    designModule?: {
      phases?: string[];
    };
  };
}

export interface NormalizedTrial {
  nctId: string;
  title: string;
  phase: string;
  status: string;
  startDate: Date | null;
}
