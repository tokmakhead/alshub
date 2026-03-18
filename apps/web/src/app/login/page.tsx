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
    </div>
  );
}
