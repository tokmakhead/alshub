"use server";

import { db } from "@/lib/db";
import { auth } from "@/lib/auth";
import { revalidatePath } from "next/cache";
import { ContentStatus } from "@alshub/shared";

export async function updateEditorialContent(id: number, data: any) {
  const session = await auth();
  if (!session?.user) throw new Error("Unauthorized");

  const userId = parseInt(session.user.id!);

  // 1. Create a log
  await db.auditLog.create({
    data: {
      userId,
      action: "UPDATE_CONTENT",
      details: { contentId: id, status: data.status },
    },
  });

  // 2. Create new version if title or content changed
  const current = await db.editorialContent.findUnique({ where: { id } });
  if (current && (current.title !== data.title || current.content !== data.body)) {
    await db.editorialVersion.create({
      data: {
        editorialContentId: id,
        title: data.title,
        summary: data.summary,
        content: data.body,
      },
    });
  }

  // 3. Update Content
  const updateData: any = {
    title: data.title,
    summary: data.summary,
    content: data.body,
    status: data.status as ContentStatus,
  };

  if (data.status === "PUBLISHED" && current?.status !== "PUBLISHED") {
    updateData.approvedAt = new Date();
    updateData.approvedById = userId;
  }

  const updated = await db.editorialContent.update({
    where: { id },
    data: updateData,
  });

  revalidatePath("/admin/content");
  return updated;
}

export async function restoreVersion(contentId: number, versionId: number) {
  const session = await auth();
  if (!session?.user) throw new Error("Unauthorized");

  const version = await db.editorialVersion.findUnique({ where: { id: versionId } });
  if (!version) throw new Error("Version not found");

  const updated = await db.editorialContent.update({
    where: { id: contentId },
    data: {
      title: version.title,
      summary: version.summary,
      content: version.content,
    },
  });

  await db.auditLog.create({
    data: {
      userId: parseInt(session.user.id!),
      action: "RESTORE_VERSION",
      details: { contentId, versionId },
    },
  });

  revalidatePath(`/admin/content/edit/${contentId}`);
  return updated;
}
