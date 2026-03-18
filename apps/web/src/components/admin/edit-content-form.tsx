"use client";

import { useRouter } from "next/navigation";
import { useState } from "react";
import { updateEditorialContent } from "@/lib/actions/editorial";

export default function EditContentForm({ content }: { content: any }) {
  const router = useRouter();
  const [formData, setFormData] = useState({
    title: content.title,
    summary: content.summary || "",
    body: content.content || "",
    status: content.status,
  });

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    try {
      await updateEditorialContent(content.id, formData);
      alert("İçerik başarıyla güncellendi.");
      router.push("/admin/content/drafts");
      router.refresh();
    } catch (error) {
      alert("Bir hata oluştu: " + (error instanceof Error ? error.message : "Bilinmeyen hata"));
    }
  }

  return (
    <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
      <div className="glass-card" style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
        <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
          <label>Başlık</label>
          <input 
            value={formData.title}
            onChange={(e) => setFormData({ ...formData, title: e.target.value })}
            style={{ padding: '0.75rem', background: 'rgba(0,0,0,0.2)', border: '1px solid var(--glass-border)', borderRadius: '0.5rem', color: 'white' }}
          />
        </div>

        <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
          <label>Özet (Summary)</label>
          <textarea 
            rows={3}
            value={formData.summary}
            onChange={(e) => setFormData({ ...formData, summary: e.target.value })}
            style={{ padding: '0.75rem', background: 'rgba(0,0,0,0.2)', border: '1px solid var(--glass-border)', borderRadius: '0.5rem', color: 'white' }}
          />
        </div>

        <div style={{ display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
          <label>İçerik (Body)</label>
          <textarea 
            rows={10}
            value={formData.body}
            onChange={(e) => setFormData({ ...formData, body: e.target.value })}
            style={{ padding: '0.75rem', background: 'rgba(0,0,0,0.2)', border: '1px solid var(--glass-border)', borderRadius: '0.5rem', color: 'white' }}
          />
        </div>
      </div>

      <div className="glass-card" style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
          <label>Durum:</label>
          <select 
            value={formData.status}
            onChange={(e) => setFormData({ ...formData, status: e.target.value })}
            style={{ padding: '0.5rem', background: 'var(--bg-dark)', color: 'white', border: '1px solid var(--glass-border)' }}
          >
            <option value="DRAFT">Taslak</option>
            <option value="REVIEW">İncelemede</option>
            <option value="PUBLISHED">Yayınlandı</option>
          </select>
        </div>

        <div style={{ display: 'flex', gap: '1rem' }}>
          <button type="button" onClick={() => router.back()} className="btn-secondary">İptal</button>
          <button type="submit" className="btn-primary">Kaydet</button>
        </div>
      </div>
    </form>
  );
}
