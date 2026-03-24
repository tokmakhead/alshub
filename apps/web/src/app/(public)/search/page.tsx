import { SearchService } from "@/services/search.service";
import Link from "next/link";

export default async function PublicSearchPage({ searchParams }: { searchParams: Promise<{ q?: string }> }) {
  const { q } = await searchParams;
  const query = q || "";
  const searchService = new SearchService();
  const results = await searchService.unifiedSearch(query);

  return (
    <div className="container" style={{ padding: '4rem 2rem' }}>
      <form action="/search" method="GET" style={{ marginBottom: '3rem' }}>
        <input 
          name="q"
          defaultValue={query}
          placeholder="İlaç, makale veya araştırma arayın..."
          style={{ 
            width: '100%', 
            padding: '1.5rem', 
            background: 'var(--glass-bg)', 
            border: '1px solid var(--glass-border)',
            borderRadius: '1rem',
            fontSize: '1.2rem',
            color: 'white',
            outline: 'none'
          }}
        />
      </form>

      {query && (
        <div>
          <h2 style={{ marginBottom: '2rem' }}>"{query}" için sonuçlar ({results.items.length})</h2>
          <div style={{ display: 'grid', gap: '1.5rem' }}>
            {results.items.map((item, i) => (
              <Link key={i} href={item.slug ? `/content/${item.slug}` : '#'} style={{ textDecoration: 'none' }}>
                <div className="glass-card table-row" style={{ padding: '1.5rem' }}>
                  <div style={{ display: 'flex', gap: '1rem', alignItems: 'center', marginBottom: '0.5rem' }}>
                    <span style={{ fontSize: '0.7rem', background: 'rgba(255,255,255,0.05)', padding: '0.2rem 0.5rem', borderRadius: '0.25rem' }}>{item.type}</span>
                    <h4 style={{ margin: 0 }}>{item.title}</h4>
                  </div>
                  <p style={{ color: 'var(--text-muted)', fontSize: '0.9rem', margin: 0 }}>{item.excerpt}</p>
                </div>
              </Link>
            ))}
            {results.items.length === 0 && (
              <p style={{ color: 'var(--text-muted)' }}>Herhangi bir sonuç bulunamadı.</p>
            )}
          </div>
        </div>
      )}
    </div>
  );
}
