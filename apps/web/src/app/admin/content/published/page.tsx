import { db } from "@/lib/db";
import DataTable from "@/components/admin/data-table";

export default async function PublishedPage() {
  const published = await db.editorialContent.findMany({
    where: { status: 'PUBLISHED' },
    orderBy: { approvedAt: 'desc' }
  });

  return (
    <div className="container">
      <DataTable 
        title="Yayınlanan İçerikler"
        headers={["Başlık", "Tür", "Yayın Tarihi"]}
        data={published}
        renderRow={(item) => (
          <>
            <td style={{ padding: '1rem' }}>{item.title}</td>
            <td style={{ padding: '1rem' }}>{item.refType}</td>
            <td style={{ padding: '1rem', fontSize: '0.85rem', color: 'var(--text-muted)' }}>
              {item.approvedAt?.toLocaleDateString('tr-TR')}
            </td>
            <td style={{ padding: '1rem' }}>
              <button className="btn-secondary" style={{ padding: '0.3rem 0.6rem', fontSize: '0.8rem' }}>Yayından Kaldır</button>
            </td>
          </>
        )}
      />
    </div>
  );
}
