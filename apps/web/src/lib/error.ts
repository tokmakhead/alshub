export class AppError extends Error {
  constructor(
    public message: string,
    public status: number = 500,
    public code?: string
  ) {
    super(message);
    this.name = "AppError";
  }
}

export function handleError(error: unknown) {
  if (error instanceof AppError) {
    return {
      message: error.message,
      status: error.status,
      code: error.code,
    };
  }

  console.error("[Unexpected Error]:", error);
  return {
    message: "Bir sistem hatası oluştu. Lütfen daha sonra tekrar deneyin.",
    status: 500,
  };
}
