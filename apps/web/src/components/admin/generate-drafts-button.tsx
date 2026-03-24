"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";

export default function GenerateDraftsButton() {
  const [loading, setLoading] = useState(false);
  const router = useRouter();

  const handleGenerate = async () => {
    if (!confirm("Senkronize edilmiş ham verilerden yeni AI taslakları üretilsin mi? (Bu işlem birkaç dakika sürebilir)")) {
      return;
    }

    setLoading(true);
    try {
      const res = await fetch("/api/generate-drafts", {
        method: "POST",
      });
      const data = await res.json();

      if (data.success) {
        alert(data.message);
        router.refresh();
      } else {
        alert("Hata (Dönüş): " + (data.error || "Bilinmeyen bir hata oluştu."));
      }
    } catch (error: any) {
      alert("Hata (Sistem): " + (error?.message || "Sunucuya ulaşılamadı. Lütfen build aldığınızdan ve sunucuyu restart ettiğinizden emin olun."));
    } finally {
      setLoading(false);
    }
  };

  return (
    <button 
      onClick={handleGenerate}
      disabled={loading}
      className="btn-primary"
      style={{ 
        marginBottom: '1rem',
        background: loading ? '#94a3b8' : 'var(--primary)',
        display: 'flex',
        alignItems: 'center',
        gap: '0.5rem'
      }}
    >
      {loading ? "Üretiliyor..." : "✨ AI Taslakları Üret"}
    </button>
  );
}
