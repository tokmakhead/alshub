import { db } from "@/lib/db";
import DataTable from "@/components/admin/data-table";

export default async function DraftsPage() {
  const drafts = await db.editorialContent.findMany({
    where: { status: 'DRAFT' },
    orderBy: { updatedAt: 'desc' }
  });

  return (
    <div className="container">
      <DataTable 
        title="İçerik Taslakları"
        headers={["Başlık", "Tür", "Son Güncelleme"]}
        data={drafts}
        renderRow={(draft) => (
          <>
            <td style={{ padding: '1rem' }}>{draft.title}</td>
            <td style={{ padding: '1rem' }}>{draft.refType}</td>
            <td style={{ padding: '1rem', fontSize: '0.85rem', color: 'var(--text-muted)' }}>
              {draft.updatedAt.toLocaleDateString('tr-TR')}
            </td>
            <td style={{ padding: '1rem' }}>
              <button className="btn-primary" style={{ padding: '0.3rem 0.6rem', fontSize: '0.8rem' }}>Düzenle & Onayla</button>
            </td>
          </>
        )}
      />
    </div>
  );
}
