import { db } from "@/lib/db";
import Link from "next/link";

export default async function PublicDrugsPage() {
  const drugs = await db.editorialContent.findMany({
    where: { refType: 'DRUG', status: 'PUBLISHED' },
    orderBy: { updatedAt: 'desc' }
  });

  return (
    <div className="container" style={{ padding: '4rem 2rem' }}>
      <header style={{ marginBottom: '3rem' }}>
        <h1 style={{ fontSize: '2.5rem', marginBottom: '1rem' }}>Onaylı ve Geliştirilmekte Olan İlaçlar</h1>
        <p style={{ color: 'var(--text-muted)' }}>ALS tedavisinde kullanılan veya klinik aşamadaki tüm ilaçların güncel durumu.</p>
      </header>

      <div style={{ display: 'grid', gap: '1.5rem' }}>
        {drugs.map((drug) => (
          <Link key={drug.id} href={`/content/${drug.slug}`} style={{ textDecoration: 'none' }}>
            <div className="glass-card table-row" style={{ padding: '1.5rem', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <div>
                <h3 style={{ margin: '0 0 0.5rem 0' }}>{drug.title}</h3>
                <p style={{ color: 'var(--text-muted)', fontSize: '0.9rem', margin: 0 }}>{drug.summary}</p>
              </div>
              <div style={{ textAlign: 'right' }}>
                <span style={{ fontSize: '0.8rem', color: 'var(--primary-glow)', border: '1px solid var(--primary-glow)', padding: '0.2rem 0.6rem', borderRadius: '1rem' }}>
                  Detaylı Bilgi →
                </span>
              </div>
            </div>
          </Link>
        ))}
      </div>
    </div>
  );
}
