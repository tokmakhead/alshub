import { handlers } from "@/lib/auth";
import { NextRequest } from "next/server";

export const GET = (req: NextRequest, props: { params: Promise<{ nextauth: string[] }> }) => {
  return handlers.GET(req);
};

export const POST = (req: NextRequest, props: { params: Promise<{ nextauth: string[] }> }) => {
  return handlers.POST(req);
};
