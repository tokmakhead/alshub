import { db } from "@/lib/db";

export default async function AdminDashboard() {
  const stats = {
    drugs: await db.drug.count(),
    trials: await db.trial.count(),
    publications: await db.publication.count(),
    drafts: await db.editorialContent.count({ where: { status: 'DRAFT' } }),
    published: await db.editorialContent.count({ where: { status: 'PUBLISHED' } }),
  };

  return (
    <div className="container">
      <header style={{ marginBottom: '2rem' }}>
        <h1 style={{ marginBottom: '0.5rem' }}>Genel Bakış</h1>
        <p style={{ color: 'var(--text-muted)' }}>Sistemdeki verilerin anlık durumu</p>
      </header>

      <div style={{ 
        display: 'grid', 
        gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', 
        gap: '1.5rem',
        marginBottom: '3rem'
      }}>
        <StatCard label="İlaçlar" value={stats.drugs} icon="💊" />
        <StatCard label="Yeni Araştırmalar" value={stats.trials} icon="🔬" />
        <StatCard label="Makaleler" value={stats.publications} icon="📖" />
        <StatCard label="İşlem Bekleyen" value={stats.drafts} icon="📝" color="var(--primary-glow)" />
        <StatCard label="Yayında" value={stats.published} icon="✅" />
      </div>

      <div className="glass-card">
        <h3>Son Senkronizasyon İşlemleri</h3>
        <p style={{ color: 'var(--text-muted)' }}>Bu alan yakında detaylandırılacak...</p>
      </div>
    </div>
  );
}

function StatCard({ label, value, icon, color }: any) {
  return (
    <div className="glass-card" style={{ padding: '1.5rem', borderTop: color ? `3px solid ${color}` : undefined }}>
      <div style={{ fontSize: '1.5rem', marginBottom: '0.5rem' }}>{icon}</div>
      <div style={{ fontSize: '2rem', fontWeight: 'bold' }}>{value}</div>
      <div style={{ color: 'var(--text-muted)', fontSize: '0.9rem' }}>{label}</div>
    </div>
  );
}
