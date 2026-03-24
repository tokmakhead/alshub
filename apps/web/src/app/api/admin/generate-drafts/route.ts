import { NextRequest, NextResponse } from "next/server";
export const dynamic = 'force-dynamic';
import { db } from "@/lib/db";

export async function GET() {
  try {
    const userCount = await db.user.count();
    return NextResponse.json({
      status: "OK",
      version: "2026-03-24 11:45 (NUCLEAR FIX)",
      database: "Connected",
      userCount
    });
  } catch (err: any) {
    return NextResponse.json({
      status: "ERROR",
      message: err.message,
      stack: err.stack
    }, { status: 500 });
  }
}

export async function POST(req: NextRequest) {
  return GET();
}
