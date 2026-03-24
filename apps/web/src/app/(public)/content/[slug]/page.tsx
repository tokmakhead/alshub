import { db } from "@/lib/db";
import { notFound } from "next/navigation";

export default async function ContentDetailPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const content = await db.editorialContent.findUnique({
    where: { slug: slug, status: 'PUBLISHED' },
    include: { aiJob: true }
  });

  if (!content) notFound();

  return (
    <article className="container" style={{ padding: '6rem 2rem', maxWidth: '900px' }}>
      <header style={{ marginBottom: '4rem', textAlign: 'center' }}>
        <div style={{ 
          display: 'inline-block', 
          padding: '0.25rem 1rem', 
          background: 'rgba(37, 99, 235, 0.1)', 
          color: 'var(--primary-glow)', 
          borderRadius: '2rem',
          fontSize: '0.85rem',
          marginBottom: '1.5rem'
        }}>
          {content.refType} • Doğrulanmış İçerik
        </div>
        <h1 style={{ fontSize: '3rem', marginBottom: '1.5rem' }}>{content.title}</h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--text-muted)', lineHeight: '1.6' }}>{content.summary}</p>
      </header>

      <div style={{ 
        padding: '3rem', 
        background: 'var(--glass-bg)', 
        border: '1px solid var(--glass-border)', 
        borderRadius: '1.5rem',
        lineHeight: '1.8',
        fontSize: '1.1rem',
        marginBottom: '4rem'
      }}>
        {content.content?.split('\n').map((line, i) => (
          <p key={i} style={{ marginBottom: '1rem' }}>{line}</p>
        ))}
      </div>

      <footer style={{ 
        padding: '2rem', 
        borderTop: '1px solid var(--glass-border)', 
        color: 'var(--text-muted)',
        fontSize: '0.9rem',
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'center'
      }}>
        <div>
          <strong>Kaynak:</strong> Orijinal Veri Tabanı Kaydı #{content.refId} <br />
          <strong>Son Güncelleme:</strong> {content.updatedAt.toLocaleDateString('tr-TR')}
        </div>
        <div style={{ textAlign: 'right' }}>
          <span title="Bu içerik yapay zeka tarafından özetlenmiş ve uzman editörler tarafından onaylanmıştır."> 
            ✅ Editoryal Onaylı
          </span>
        </div>
      </footer>
    </article>
  );
}
