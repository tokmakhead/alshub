import Link from "next/link";

export default function Sidebar() {
  const menuItems = [
    { label: "Dashboard", href: "/admin", icon: "📊" },
    { label: "İlaçlar", href: "/admin/drugs", icon: "💊" },
    { label: "Araştırmalar", href: "/admin/trials", icon: "🔬" },
    { label: "Makaleler", href: "/admin/publications", icon: "📖" },
    { label: "Taslaklar", href: "/admin/content/drafts", icon: "📝" },
    { label: "Yayınlananlar", href: "/admin/content/published", icon: "✅" },
    { label: "Senkronizasyon", href: "/admin/sync", icon: "🔄" },
    { label: "AI İşleri", href: "/admin/ai", icon: "🤖" },
    { label: "Ayarlar", href: "/admin/settings", icon: "⚙️" },
  ];

  return (
    <aside style={{ 
      width: '260px', 
      background: 'rgba(255,255,255,0.02)', 
      borderRight: '1px solid var(--glass-border)',
      display: 'flex',
      flexDirection: 'column',
      height: '100vh',
      position: 'fixed'
    }}>
      <div style={{ padding: '2rem', borderBottom: '1px solid var(--glass-border)' }}>
        <h3 style={{ margin: 0 }}>ALS Hub Admin</h3>
        <span style={{ fontSize: '0.8rem', color: 'var(--text-muted)' }}>Yönetim Paneli</span>
      </div>

      <nav style={{ flex: 1, padding: '1rem', overflowY: 'auto' }}>
        <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: '0.25rem' }}>
          {menuItems.map((item) => (
            <li key={item.href}>
              <Link href={item.href} style={{
                display: 'flex',
                alignItems: 'center',
                gap: '0.75rem',
                padding: '0.75rem 1rem',
                borderRadius: '0.5rem',
                color: 'var(--text-color)',
                textDecoration: 'none',
                transition: 'background 0.2s',
                fontSize: '0.95rem'
              }} className="sidebar-link">
                <span>{item.icon}</span>
                <span>{item.label}</span>
              </Link>
            </li>
          ))}
        </ul>
      </nav>

      <div style={{ padding: '1rem', borderTop: '1px solid var(--glass-border)' }}>
        <Link href="/api/auth/signout" style={{ color: 'var(--text-muted)', fontSize: '0.9rem', textDecoration: 'none' }}>
          🚪 Çıkış Yap
        </Link>
      </div>
    </aside>
  );
}
