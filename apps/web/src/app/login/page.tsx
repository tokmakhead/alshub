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
    <div className="login-container">
      <div className="login-card glass-card">
        <div className="login-header">
          <div className="logo-placeholder">ALS HUB</div>
          <h1>Yönetici Girişi</h1>
          <p>Devam etmek için bilgilerinizi girin</p>
        </div>
        
        <form action={handleLogin} className="login-form">
          <div className="form-group">
            <label htmlFor="email">E-posta Adresi</label>
            <input 
              id="email"
              name="email"
              type="email" 
              placeholder="admin@alshub.org"
              required
            />
          </div>

          <div className="form-group">
            <label htmlFor="password">Şifre</label>
            <input 
              id="password"
              name="password"
              type="password" 
              placeholder="••••••••"
              required
            />
          </div>

          <button type="submit" className="btn-primary login-btn">
            Giriş Yap
          </button>
        </form>
        
        <div className="login-footer">
          &copy; {new Date().getFullYear()} ALS Hub Yönetim Paneli
        </div>
      </div>

      <style jsx>{`
        .login-container {
          min-height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
          background: radial-gradient(circle at top left, #eff6ff 0%, #f8fafc 100%);
          padding: 1.5rem;
        }
        .login-card {
          width: 100%;
          max-width: 440px;
          box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }
        .login-header {
          text-align: center;
          margin-bottom: 2.5rem;
        }
        .logo-placeholder {
          font-size: 1.5rem;
          font-weight: 900;
          color: var(--primary);
          margin-bottom: 1rem;
          letter-spacing: -0.05em;
        }
        .login-header h1 {
          font-size: 1.75rem;
          color: var(--foreground);
          margin-bottom: 0.5rem;
        }
        .login-header p {
          color: var(--text-muted);
          font-size: 0.95rem;
        }
        .login-form {
          display: flex;
          flex-direction: column;
          gap: 1.5rem;
        }
        .form-group {
          display: flex;
          flex-direction: column;
          gap: 0.5rem;
        }
        .form-group label {
          font-size: 0.875rem;
          font-weight: 600;
          color: var(--foreground);
        }
        .form-group input {
          padding: 0.875rem;
          background: white;
          border: 1px solid var(--border);
          border-radius: 0.5rem;
          font-size: 1rem;
          color: var(--foreground);
          transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-group input:focus {
          outline: none;
          border-color: var(--primary);
          box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .login-btn {
          width: 100%;
          padding: 1rem;
          font-size: 1rem;
          margin-top: 1rem;
        }
        .login-footer {
          margin-top: 2rem;
          text-align: center;
          font-size: 0.8rem;
          color: var(--text-muted);
        }
      `}</style>
    </div>
  );
}
