import { db } from "@/lib/db";
import DataTable from "@/components/admin/data-table";

export default async function TrialsPage() {
  const trials = await db.trial.findMany({ orderBy: { id: 'desc' } });

  return (
    <div className="container">
      <DataTable 
        title="Klinik Araştırmalar"
        headers={["NCT ID", "Başlık", "Faz", "Durum"]}
        data={trials}
        renderRow={(trial) => (
          <>
            <td style={{ padding: '1rem', fontSize: '0.85rem' }}><code>{trial.nctId}</code></td>
            <td style={{ padding: '1rem' }}>{trial.title}</td>
            <td style={{ padding: '1rem' }}>{trial.phase}</td>
            <td style={{ padding: '1rem' }}>{trial.status}</td>
            <td style={{ padding: '1rem' }}>
              <button className="btn-secondary" style={{ padding: '0.3rem 0.6rem', fontSize: '0.8rem' }}>İncele</button>
            </td>
          </>
        )}
      />
    </div>
  );
}
