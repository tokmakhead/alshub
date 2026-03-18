import Link from "next/link";

export default function PublicLayout({ children }: { children: React.ReactNode }) {
  return (
    <div style={{ minHeight: '100vh', display: 'flex', flexDirection: 'column' }}>
      <header style={{ 
        padding: '1.5rem 2rem', 
        borderBottom: '1px solid var(--glass-border)',
        backdropFilter: 'blur(10px)',
        position: 'sticky',
        top: 0,
        zIndex: 100,
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'center',
        background: 'rgba(10, 10, 12, 0.8)'
      }}>
        <Link href="/" style={{ fontSize: '1.5rem', fontWeight: 'bold', textDecoration: 'none', color: 'var(--primary-glow)' }}>
          ALS Hub
        </Link>
        
        <nav style={{ display: 'flex', gap: '2rem' }}>
          <Link href="/drugs" className="nav-link">İlaçlar</Link>
          <Link href="/trials" className="nav-link">Araştırmalar</Link>
          <Link href="/publications" className="nav-link">Yayınlar</Link>
          <Link href="/about" className="nav-link">ALS Nedir?</Link>
        </nav>

        <div style={{ display: 'flex', gap: '1rem', alignItems: 'center' }}>
          <Link href="/search" style={{ fontSize: '1.2rem', textDecoration: 'none' }}>🔍</Link>
          <Link href="/login" style={{ fontSize: '0.9rem', color: 'var(--text-muted)', textDecoration: 'none' }}>Admin</Link>
        </div>
      </header>

      <main style={{ flex: 1 }}>
        {children}
      </main>

      <footer style={{ 
        padding: '4rem 2rem', 
        background: 'rgba(255,255,255,0.02)', 
        borderTop: '1px solid var(--glass-border)',
        marginTop: '4rem'
      }}>
        <div className="container" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '2rem' }}>
          <div>
            <h4>ALS Hub</h4>
            <p style={{ color: 'var(--text-muted)', fontSize: '0.9rem' }}>
              ALS hastaları için güncel ve bilimsel doğruluk odaklı bilgi kaynağı.
            </p>
          </div>
          <div>
            <h5>Linkler</h5>
            <ul style={{ listStyle: 'none', padding: 0, fontSize: '0.9rem', color: 'var(--text-muted)' }}>
              <li>Kaynak Politikası</li>
              <li>Sorumluluk Reddi</li>
              <li>İletişim</li>
            </ul>
          </div>
          <div style={{ textAlign: 'right' }}>
            <p style={{ fontSize: '0.8rem', color: 'var(--text-muted)' }}>
              © 2024 ALS Hub. Tüm hakları saklıdır.
            </p>
          </div>
        </div>
      </footer>
    </div>
  );
}
