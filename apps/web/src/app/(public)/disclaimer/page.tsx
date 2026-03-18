export default function DisclaimerPage() {
  return (
    <div className="container" style={{ padding: '6rem 2rem', maxWidth: '800px', textAlign: 'center' }}>
      <h1 style={{ color: '#f87171' }}>⚠️ Tıbbi Sorumluluk Reddi</h1>
      <div style={{ marginTop: '2rem', lineHeight: '1.8', background: 'rgba(255,0,0,0.05)', padding: '2rem', borderRadius: '1rem' }}>
        <p><strong>ALS Hub bir tıbbi tavsiye platformu değildir.</strong></p>
        <p>Bu sitede sunulan bilgiler sadece bilgilendirme amaçlıdır ve profesyonel tıbbi tavsiye, teşhis veya tedavinin yerini alması amaçlanmamıştır.</p>
        <p>Herhangi bir tedaviye başlamadan veya mevcut tedavinizde değişiklik yapmadan önce mutlaka doktorunuza danışınız.</p>
      </div>
    </div>
  );
}
