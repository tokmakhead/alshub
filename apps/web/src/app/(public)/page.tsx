import Link from "next/link";

export default function HomePage() {
  return (
    <div>
      <section style={{ 
        padding: '8rem 2rem', 
        textAlign: 'center', 
        background: 'radial-gradient(circle at center, rgba(37, 99, 235, 0.1) 0%, transparent 70%)' 
      }}>
        <h1 style={{ fontSize: '3.5rem', marginBottom: '1.5rem', fontWeight: '800' }}>
          Güvenilir ALS Bilgi Kaynağı
        </h1>
        <p style={{ fontSize: '1.25rem', color: 'var(--text-muted)', maxWidth: '800px', margin: '0 auto 3rem' }}>
          Dünya çapındaki klinik araştırmaları, onaylı ilaçları ve bilimsel makaleleri 
          yapay zeka desteğiyle analiz ediyor, anlaşılır Türkçe özetlerle sunuyoruz.
        </p>
        
        <div style={{ display: 'flex', gap: '1.5rem', justifyContent: 'center' }}>
          <Link href="/drugs" className="btn-primary" style={{ padding: '1rem 2rem' }}>Onaylı İlaçlar</Link>
          <Link href="/trials" className="btn-secondary" style={{ padding: '1rem 2rem' }}>Klinik Araştırmalar</Link>
        </div>
      </section>

      <section className="container" style={{ padding: '4rem 0' }}>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '2rem' }}>
          <FeatureCard 
            title="Güncel Veri" 
            desc="PubMed ve ClinicalTrials.gov üzerinden anlık veri çekimi ve normalizasyon." 
            icon="🌐" 
          />
          <FeatureCard 
            title="Bilimsel Doğruluk" 
            desc="Sadece resmi kaynaklardan gelen, doğrulanmış tıbbi veriler sunulur." 
            icon="🔬" 
          />
          <FeatureCard 
            title="Sade Anlatım" 
            desc="Karmaşık tıbbi terimler AI desteğiyle hastalar için anlaşılır hale getirilir." 
            icon="✍️" 
          />
        </div>
      </section>
    </div>
  );
}

function FeatureCard({ title, desc, icon }: any) {
  return (
    <div className="glass-card" style={{ padding: '2rem' }}>
      <div style={{ fontSize: '2rem', marginBottom: '1rem' }}>{icon}</div>
      <h4>{title}</h4>
      <p style={{ color: 'var(--text-muted)', fontSize: '0.95rem' }}>{desc}</p>
    </div>
  );
}
