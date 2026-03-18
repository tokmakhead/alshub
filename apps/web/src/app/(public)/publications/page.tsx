import { db } from "@/lib/db";
import Link from "next/link";

export default async function PublicPublicationsPage() {
  const pubs = await db.editorialContent.findMany({
    where: { refType: 'PUBLICATION', status: 'PUBLISHED' },
    orderBy: { updatedAt: 'desc' }
  });

  return (
    <div className="container" style={{ padding: '4rem 2rem' }}>
      <header style={{ marginBottom: '3rem' }}>
        <h1 style={{ fontSize: '2.5rem', marginBottom: '1rem' }}>Bilimsel Yayınlar</h1>
        <p style={{ color: 'var(--text-muted)' }}>PubMed üzerinden takip edilen en güncel ALS makalelerinin sadeleştirilmiş özetleri.</p>
      </header>

      <div style={{ display: 'grid', gap: '1.5rem' }}>
        {pubs.map((pub) => (
          <Link key={pub.id} href={`/content/${pub.slug}`} style={{ textDecoration: 'none' }}>
            <div className="glass-card table-row" style={{ padding: '1.5rem', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <div>
                <h3 style={{ margin: '0 0 0.5rem 0' }}>{pub.title}</h3>
                <p style={{ color: 'var(--text-muted)', fontSize: '0.9rem', margin: 0 }}>{pub.summary}</p>
              </div>
              <div style={{ textAlign: 'right' }}>
                <span style={{ fontSize: '0.8rem', color: 'var(--primary-glow)', border: '1px solid var(--primary-glow)', padding: '0.2rem 0.6rem', borderRadius: '1rem' }}>
                  Yazıyı Oku →
                </span>
              </div>
            </div>
          </Link>
        ))}
      </div>
    </div>
  );
}
