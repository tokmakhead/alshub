export interface OpenFdaDrugRaw {
  id: string;
  openfda: {
    brand_name?: string[];
    generic_name?: string[];
    manufacturer_name?: string[];
    product_type?: string[];
  };
  indications_and_usage?: string[];
}

export interface NormalizedDrug {
  externalId: string;
  name: string;
  company: string;
  status: string;
}
