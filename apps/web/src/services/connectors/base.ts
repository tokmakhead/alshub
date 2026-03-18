export interface SyncResult {
  sourceName: string;
  processedCount: number;
  successCount: number;
  failedCount: number;
  errors: string[];
}

export interface IConnector<TRaw = any, TNormalized = any> {
  sourceName: string;
  
  /**
   * Fetches raw data from the external source
   */
  fetchRaw(params?: any): Promise<TRaw[]>;

  /**
   * Normalizes raw data into our internal data model
   */
  normalize(raw: TRaw): TNormalized;

  /**
   * Validates the normalized data against business rules
   */
  validate(normalized: TNormalized): boolean;

  /**
   * Upserts the data into the database (SourceRecord + Normalized Table)
   */
  upsert(normalized: TNormalized, raw: TRaw): Promise<void>;

  /**
   * Full synchronization flow: fetch -> normalize -> validate -> upsert
   */
  sync(): Promise<SyncResult>;
}

export abstract class BaseConnector<TRaw, TNormalized> implements IConnector<TRaw, TNormalized> {
  abstract sourceName: string;

  abstract fetchRaw(params?: any): Promise<TRaw[]>;
  abstract normalize(raw: TRaw): TNormalized;
  abstract validate(normalized: TNormalized): boolean;
  abstract upsert(normalized: TNormalized, raw: TRaw): Promise<void>;

  async sync(): Promise<SyncResult> {
    const result: SyncResult = {
      sourceName: this.sourceName,
      processedCount: 0,
      successCount: 0,
      failedCount: 0,
      errors: [],
    };

    try {
      const rawData = await this.fetchRaw();
      result.processedCount = rawData.length;

      for (const raw of rawData) {
        try {
          const normalized = this.normalize(raw);
          if (this.validate(normalized)) {
            await this.upsert(normalized, raw);
            result.successCount++;
          } else {
            result.failedCount++;
            result.errors.push(`Validation failed for record`);
          }
        } catch (error) {
          result.failedCount++;
          result.errors.push(error instanceof Error ? error.message : String(error));
        }
      }
    } catch (error) {
      result.errors.push(`Critical Sync Error: ${error instanceof Error ? error.message : String(error)}`);
    }

    return result;
  }
}
