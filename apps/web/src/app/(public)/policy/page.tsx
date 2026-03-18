export default function PolicyPage() {
  return (
    <div className="container" style={{ padding: '6rem 2rem', maxWidth: '800px' }}>
      <h1>Kaynak Politikası</h1>
      <div style={{ marginTop: '2rem', lineHeight: '1.8' }}>
        <p>ALS Hub, sunduğu tüm tıbbi verileri aşağıdaki resmi kaynaklardan anlık olarak çekmektedir:</p>
        <ul>
          <li><strong>ClinicalTrials.gov:</strong> Klinik araştırmalar ve ilaç faz bilgileri.</li>
          <li><strong>PubMed (NCBI):</strong> Akademik makaleler ve bilimsel yayınlar.</li>
          <li><strong>FDA (U.S. Food and Drug Administration):</strong> Onaylı ilaç listeleri ve resmi dokümanlar.</li>
        </ul>
        <p>Veriler yapay zeka tarafından özetlenmekte ve uzman editörlerimiz tarafından kontrol edilmektedir.</p>
      </div>
    </div>
  );
}
