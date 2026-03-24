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
      const res = await fetch("/api/admin/generate-drafts", {
        method: "POST",
      });
      const data = await res.json();

      if (data.success) {
        alert(data.message);
        router.refresh();
      } else {
        alert("Hata: " + (data.error || "Bilinmeyen bir hata oluştu."));
      }
    } catch (error) {
      alert("Hata: Sunucuya ulaşılamadı.");
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
