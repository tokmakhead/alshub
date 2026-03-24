import { handlers } from "@/lib/auth";
import { NextRequest } from "next/server";

export const GET = (req: NextRequest, props: { params: Promise<{ nextauth: string[] }> }) => {
  return (handlers.GET as any)(req);
};

export const POST = (req: NextRequest, props: { params: Promise<{ nextauth: string[] }> }) => {
  return (handlers.POST as any)(req);
};
