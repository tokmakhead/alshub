import { db } from "@/lib/db";
import DataTable from "@/components/admin/data-table";

export default async function DrugsPage() {
  const drugs = await db.drug.findMany({ orderBy: { id: 'desc' } });

  return (
    <div className="container">
      <DataTable 
        title="İlaç Listesi"
        headers={["İsim", "Üretici", "Durum"]}
        data={drugs}
        renderRow={(drug) => (
          <>
            <td style={{ padding: '1rem' }}>{drug.name}</td>
            <td style={{ padding: '1rem' }}>{drug.company}</td>
            <td style={{ padding: '1rem' }}>
              <span style={{ fontSize: '0.8rem', padding: '0.2rem 0.6rem', borderRadius: '1rem', background: 'rgba(255,255,255,0.05)' }}>
                {drug.status}
              </span>
            </td>
            <td style={{ padding: '1rem' }}>
              <button className="btn-secondary" style={{ padding: '0.3rem 0.6rem', fontSize: '0.8rem' }}>AI Taslak Üret</button>
            </td>
          </>
        )}
      />
    </div>
  );
}
