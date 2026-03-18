export default function Home() {
  return (
    <div className="container" style={{ minHeight: '100vh', display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center', textAlign: 'center' }}>
      <div style={{ position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', background: 'radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%)', zIndex: -1 }}></div>
      
      <h1 style={{ fontSize: '4rem', marginBottom: '1.5rem', background: 'linear-gradient(to right, #fff, #3b82f6)', WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent' }}>
        ALS Hub
      </h1>
      
      <p style={{ fontSize: '1.25rem', color: 'var(--text-muted)', maxWidth: '600px', marginBottom: '3rem', lineHeight: '1.6' }}>
        ALS hastalığı ile ilgili dünyadaki en güncel bilimsel gelişmeleri, klinik çalışmaları ve resmi onay süreçlerini Türkçe ve sade bir dille takip edin.
      </p>

      <div className="glass-card" style={{ maxWidth: '400px' }}>
        <h3 style={{ marginBottom: '1rem' }}>Hazırlık Aşamasındayız</h3>
        <p style={{ color: 'var(--text-muted)', fontSize: '0.9rem', marginBottom: '1.5rem' }}>
          Resmi veri kaynaklarından otomatik senkronizasyon ve AI destekli özetleme sistemi kuruluyor.
        </p>
        <button className="btn-primary">Yakında</button>
      </div>

      <footer style={{ marginTop: '5rem', color: 'var(--text-muted)', fontSize: '0.8rem' }}>
        © 2026 ALS Hub. Tüm hakları saklıdır. Tıbbi tavsiye niteliği taşımaz.
      </footer>
    </div>
  );
}
