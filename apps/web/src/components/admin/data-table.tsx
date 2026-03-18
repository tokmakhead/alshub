import React from "react";

interface DataTableProps {
  title: string;
  headers: string[];
  data: any[];
  renderRow: (item: any) => React.ReactNode;
}

export default function DataTable({ title, headers, data, renderRow }: DataTableProps) {
  return (
    <div className="glass-card" style={{ padding: '0' }}>
      <div style={{ padding: '1.5rem', borderBottom: '1px solid var(--glass-border)' }}>
        <h3 style={{ margin: 0 }}>{title}</h3>
      </div>
      <div style={{ overflowX: 'auto' }}>
        <table style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left' }}>
          <thead>
            <tr style={{ borderBottom: '1px solid var(--glass-border)', background: 'rgba(255,255,255,0.02)' }}>
              {headers.map((h, i) => (
                <th key={i} style={{ padding: '1rem', fontSize: '0.85rem', color: 'var(--text-muted)', fontWeight: 'normal' }}>
                  {h.toUpperCase()}
                </th>
              ))}
              <th style={{ padding: '1rem' }}>İŞLEMLER</th>
            </tr>
          </thead>
          <tbody>
            {data.map((item, index) => (
              <tr key={index} style={{ borderBottom: '1px solid var(--glass-border-light)' }} className="table-row">
                {renderRow(item)}
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
