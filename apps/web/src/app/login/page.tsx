import { signIn } from "@/lib/auth";
import { redirect } from "next/navigation";

export default function LoginPage() {
  async function handleLogin(formData: FormData) {
    "use server";
    const email = formData.get("email");
    const password = formData.get("password");

    try {
      await signIn("credentials", {
        email,
        password,
        redirectTo: "/admin",
      });
    } catch (error) {
      if (error instanceof Error) {
        // Handle specific auth errors if needed
      }
      throw error;
    }
  }

  return (
    <div className="container" style={{ minHeight: '100vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
      <div className="glass-card" style={{ width: '100%', maxWidth: '400px' }}>
        <h2 style={{ marginBottom: '2rem', textAlign: 'center' }}>Admin Girişi</h2>
        
        <form action={handleLogin} style={{ display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
          <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
            <label style={{ fontSize: '0.9rem', color: 'var(--text-muted)' }}>E-posta</label>
            <input 
              name="email"
              type="email" 
              required
              style={{ 
                padding: '0.75rem', 
                background: 'rgba(255,255,255,0.05)', 
                border: '1px solid var(--glass-border)', 
                borderRadius: '0.5rem',
                color: 'white',
                outline: 'none'
              }}
            />
          </div>

          <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
            <label style={{ fontSize: '0.9rem', color: 'var(--text-muted)' }}>Şifre</label>
            <input 
              name="password"
              type="password" 
              required
              style={{ 
                padding: '0.75rem', 
                background: 'rgba(255,255,255,0.05)', 
                border: '1px solid var(--glass-border)', 
                borderRadius: '0.5rem',
                color: 'white',
                outline: 'none'
              }}
            />
          </div>

          <button type="submit" className="btn-primary" style={{ marginTop: '1rem' }}>
            Giriş Yap
          </button>
        </form>
      </div>
    </div>
  );
}
