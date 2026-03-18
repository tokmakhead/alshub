import { db } from "@/lib/db";
import EditContentForm from "@/components/admin/edit-content-form";
import { notFound } from "next/navigation";

export default async function EditContentPage({ params }: { params: { id: string } }) {
  const contentId = parseInt(params.id);
  if (isNaN(contentId)) notFound();

  const content = await db.editorialContent.findUnique({
    where: { id: contentId },
    include: { versions: { orderBy: { createdAt: 'desc' }, take: 5 } }
  });

  if (!content) notFound();

  return (
    <div className="container">
      <header style={{ marginBottom: '2rem' }}>
        <h1>İçerik Düzenle</h1>
        <p style={{ color: 'var(--text-muted)' }}>{content.refType} ID: {content.refId}</p>
      </header>

      <EditContentForm content={content} />

      <div className="glass-card" style={{ marginTop: '2rem' }}>
        <h3>Geçmiş Versiyonlar</h3>
        <ul style={{ listStyle: 'none', padding: 0, margin: '1rem 0' }}>
          {content.versions.map((v: any, i: number) => (
            <li key={i} style={{ padding: '0.5rem 0', borderBottom: '1px solid var(--glass-border-light)', fontSize: '0.9rem' }}>
              {v.createdAt.toLocaleString('tr-TR')} - {v.title}
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
}
