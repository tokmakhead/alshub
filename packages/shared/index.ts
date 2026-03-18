export type ContentStatus = 'DRAFT' | 'REVIEW' | 'PUBLISHED' | 'ARCHIVED';
export type RefType = 'DRUG' | 'TRIAL' | 'PUBLICATION';

export interface BaseEntity {
  id: number;
  createdAt: Date;
  updatedAt: Date;
}
