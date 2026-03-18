export const PROMPTS = {
  DRUG_SUMMARY: (name: string, data: any) => `
    Aşağıdaki ilaç verilerini kullanarak ALS hastaları için bilgilendirici bir Türkçe özet hazırla.
    İlaç Adı: ${name}
    Veri: ${JSON.stringify(data)}
    
    Lütfen şu formatta cevap ver:
    ### Özet
    [Kısa teknik özet]
    ### Hasta İçin Ne Anlama Geliyor?
    [Sade, anlaşılır açıklama]
    ### Durum
    [Onay durumu veya geliştirme fazı]
  `,
  TRIAL_SUMMARY: (title: string, data: any) => `
    Aşağıdaki klinik araştırma verilerini Türkçe'ye çevir ve özetle.
    Başlık: ${title}
    Veri: ${JSON.stringify(data)}
  `,
  PUB_SUMMARY: (title: string, abstract: string) => `
    Aşağıdaki akademik makaleyi Türkçe özetle.
    Başlık: ${title}
    Abstract: ${abstract}
  `,
};
