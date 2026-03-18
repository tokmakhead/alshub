import { db } from "@/lib/db";
import DataTable from "@/components/admin/data-table";

export default async function AIJobsPage() {
  const aiJobs = await db.aIJob.findMany({
    orderBy: { createdAt: 'desc' },
    take: 20
  });

  return (
    <div className="container">
      <DataTable 
        title="AI İşlemleri"
        headers={["Model", "Durum", "Tarih", "Giriş (Prompt)"]}
        data={aiJobs}
        renderRow={(job) => (
          <>
            <td style={{ padding: '1rem' }}>{job.model}</td>
            <td style={{ padding: '1rem' }}>
              <span style={{ 
                fontSize: '0.8rem', 
                padding: '0.2rem 0.6rem', 
                borderRadius: '1rem', 
                background: job.status === 'COMPLETED' ? 'rgba(0,255,0,0.1)' : 'rgba(255,165,0,0.1)',
                color: job.status === 'COMPLETED' ? '#4ade80' : '#fbbf24'
              }}>
                {job.status}
              </span>
            </td>
            <td style={{ padding: '1rem', fontSize: '0.85rem' }}>{job.createdAt.toLocaleString('tr-TR')}</td>
            <td style={{ padding: '1rem', fontSize: '0.85rem', color: 'var(--text-muted)', maxWidth: '300px', overflow: 'hidden', textOverflow: 'ellipsis' }}>
              {job.prompt.substring(0, 100)}...
            </td>
            <td style={{ padding: '1rem' }}>
              <button className="btn-secondary" style={{ padding: '0.3rem 0.6rem', fontSize: '0.8rem' }}>Detay</button>
            </td>
          </>
        )}
      />
    </div>
  );
}
