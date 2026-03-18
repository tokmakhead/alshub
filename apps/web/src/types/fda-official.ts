export interface DrugsFdaRaw {
  application_number: string;
  sponsor_name: string;
  products: {
    brand_name: string;
    marketing_status: string;
  }[];
  submissions: {
    submission_type: string;
    submission_status: string;
    submission_public_status_date: string;
  }[];
}

export interface OrangeBookRaw {
  appl_no: string;
  product_no: string;
  type: string;
  patent_expiration_date?: string;
}

export interface NormalizedFdaOfficial {
  applicationNumber: string;
  sponsor: string;
  brandName: string;
  approvalDate: string | null;
  marketingStatus: string;
}
