import { db } from "@/lib/db";
import DataTable from "@/components/admin/data-table";

export default async function SyncJobsPage() {
  const syncJobs = await db.syncJob.findMany({
    include: { source: true },
    orderBy: { runDate: 'desc' },
    take: 20
  });

  return (
    <div className="container">
      <DataTable 
        title="Senkronizasyon Geçmişi"
        headers={["Kaynak", "Durum", "Tarih", "Mesaj"]}
        data={syncJobs}
        renderRow={(job) => (
          <>
            <td style={{ padding: '1rem' }}>{job.source.name}</td>
            <td style={{ padding: '1rem' }}>
              <span style={{ 
                fontSize: '0.8rem', 
                padding: '0.2rem 0.6rem', 
                borderRadius: '1rem', 
                background: job.status === 'COMPLETED' ? 'rgba(0,255,0,0.1)' : 'rgba(255,0,0,0.1)',
                color: job.status === 'COMPLETED' ? '#4ade80' : '#f87171'
              }}>
                {job.status}
              </span>
            </td>
            <td style={{ padding: '1rem', fontSize: '0.85rem' }}>{job.runDate.toLocaleString('tr-TR')}</td>
            <td style={{ padding: '1rem', fontSize: '0.85rem', color: 'var(--text-muted)', maxWidth: '300px', overflow: 'hidden', textOverflow: 'ellipsis' }}>
              {job.message}
            </td>
            <td style={{ padding: '1rem' }}>
              <button className="btn-secondary" style={{ padding: '0.3rem 0.6rem', fontSize: '0.8rem' }}>Yenile</button>
            </td>
          </>
        )}
      />
    </div>
  );
}
