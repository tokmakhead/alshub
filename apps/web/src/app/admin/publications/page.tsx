import { db } from "@/lib/db";
import DataTable from "@/components/admin/data-table";

export default async function PublicationsPage() {
  const pubs = await db.publication.findMany({ orderBy: { id: 'desc' } });

  return (
    <div className="container">
      <DataTable 
        title="Akademik Yayınlar"
        headers={["PMID", "Başlık", "Yazarlar"]}
        data={pubs}
        renderRow={(pub) => (
          <>
            <td style={{ padding: '1rem', fontSize: '0.85rem' }}><code>{pub.pmid}</code></td>
            <td style={{ padding: '1rem' }}>{pub.title}</td>
            <td style={{ padding: '1rem', fontSize: '0.85rem', color: 'var(--text-muted)' }}>{pub.authors}</td>
            <td style={{ padding: '1rem' }}>
              <button className="btn-secondary" style={{ padding: '0.3rem 0.6rem', fontSize: '0.8rem' }}>Detay</button>
            </td>
          </>
        )}
      />
    </div>
  );
}
