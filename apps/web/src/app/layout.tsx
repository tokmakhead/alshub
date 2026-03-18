import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  title: "ALS Hub | Güncel ALS Araştırmaları ve Bilgi Kaynağı",
  description: "ALS hastalığı ile ilgili en güncel klinik çalışmalar, makaleler ve ilaç bilgilerinin Türkçe özet merkezi.",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="tr">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
      </head>
      <body>
        <main>{children}</main>
      </body>
    </html>
  );
}
