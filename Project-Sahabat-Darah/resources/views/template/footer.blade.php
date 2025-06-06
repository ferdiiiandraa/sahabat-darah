<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Footer Sahabat Darah</title>
  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    .footer {
      width: 100vw;
      background: linear-gradient(to top, #f5dede, #e3e3e3);
      padding: 16px 20px;
      text-align: center;
      box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
    }

    .footer-text {
      margin: 0;
      font-size: 14px;
      color: #444;
      font-weight: 500;
    }

    .footer-contact-outer-card {
      max-width: 420px;
      padding: 32px 16px 18px 16px;
      border-radius: 18px;
      box-shadow: 0 4px 18px rgba(0,0,0,0.08);
      margin: 32px auto 20px auto;
    }
    .footer-wa-form {
      width: 100%;
      max-width: 100%;
      gap: 10px;
      padding: 0;
    }
    .footer-input-card {
      padding: 0;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 1px 6px rgba(0,0,0,0.04);
      margin-bottom: 0;
    }
    .footer-wa-input {
      width: 100%;
      background: #fff;
      border: 1.2px solid #e3e3e3;
      border-radius: 7px;
      font-size: 1.01rem;
      padding: 8px 12px;
      margin: 2px 0;
      box-sizing: border-box;
    }
    .footer-wa-input:focus {
      border: 1.2px solid #25D366;
      box-shadow: 0 1px 8px rgba(37,211,102,0.07);
      outline: none;
    }
  </style>
</head>
<body>
  
</body>
</html>
<footer class="footer">
  <div class="footer-contact-outer-card">
    <div class="footer-contact-title">Hubungi Kami</div>
    <div class="footer-contact-desc">Isi identitas dan pesan Anda, tim kami akan menghubungi Anda melalui WhatsApp. Untuk info update, cek juga Instagram resmi PMI di bawah.</div>
    <form id="footerWaForm" class="footer-wa-form">
      <div class="footer-input-card">
        <label for="footerNama" class="footer-label">Nama</label>
        <input type="text" id="footerNama" name="nama" class="footer-wa-input" placeholder="Nama Anda" required>
      </div>
      <div class="footer-input-card">
        <label for="footerEmail" class="footer-label">Email Rumah Sakit</label>
        <input type="email" id="footerEmail" name="email" class="footer-wa-input" placeholder="Email Rumah Sakit" required>
      </div>
      <div class="footer-input-card" style="position:relative;">
        <label for="footerInstagram" class="footer-label">Instagram <span style='color:#aaa;'>(opsional)</span></label>
        <svg class="footer-ig-icon" width="20" height="20" viewBox="0 0 24 24" fill="#E4405F" style="position:absolute;left:12px;top:38px;z-index:2;"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.974-.974 2.241-1.246 3.608-1.308C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.771.131 4.659.363 3.678 1.344 2.697 2.325 2.465 3.437 2.406 4.718 2.347 5.998 2.334 6.407 2.334 12c0 5.593.013 6.002.072 7.282.059 1.281.291 2.393 1.272 3.374.981.981 2.093 1.213 3.374 1.272C8.332 23.987 8.741 24 12 24s3.668-.013 4.948-.072c1.281-.059 2.393-.291 3.374-1.272.981-.981 1.213-2.093 1.272-3.374.059-1.28.072-1.689.072-7.282 0-5.593-.013-6.002-.072-7.282-.059-1.281-.291-2.393-1.272-3.374C19.341.363 18.229.131 16.948.072 15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
        <input type="text" id="footerInstagram" name="instagram" class="footer-wa-input" placeholder="@username" style="padding-left:36px;">
      </div>
      <div class="footer-input-card">
        <label for="footerPesan" class="footer-label">Pesan</label>
        <textarea id="footerPesan" name="pesan" class="footer-wa-input" placeholder="Pesan Anda" required></textarea>
      </div>
      <button type="submit" class="footer-wa-btn">
        <svg width="20" height="20" fill="#fff" viewBox="0 0 32 32" style="vertical-align:middle;"><path d="M16 3C9.373 3 4 8.373 4 15c0 2.637.86 5.08 2.36 7.09L4 29l7.18-2.31C13.09 27.14 14.52 27.5 16 27.5c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22c-1.32 0-2.61-.26-3.81-.77l-.27-.12-4.27 1.37 1.4-4.13-.18-.28C7.26 18.61 7 17.32 7 16c0-5.06 4.13-9.19 9.19-9.19S25.38 10.94 25.38 16c0 5.06-4.13 9.19-9.19 9.19zm5.09-6.41c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.41-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.01-.22-.54-.44-.47-.61-.48-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.97.95-.97 2.32 0 1.37.99 2.7 1.13 2.89.14.18 1.95 2.98 4.74 4.06.66.23 1.18.37 1.58.47.66.17 1.26.15 1.73.09.53-.08 1.65-.67 1.89-1.32.23-.65.23-1.21.16-1.32-.07-.11-.25-.18-.53-.32z"/></svg>
        Kirim via WhatsApp
      </button>
    </form>
    <div class="footer-pmi-ig-row">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="#E4405F" style="vertical-align:middle;margin-right:6px;"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.974-.974 2.241-1.246 3.608-1.308C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.771.131 4.659.363 3.678 1.344 2.697 2.325 2.465 3.437 2.406 4.718 2.347 5.998 2.334 6.407 2.334 12c0 5.593.013 6.002.072 7.282.059 1.281.291 2.393 1.272 3.374.981.981 2.093 1.213 3.374 1.272C8.332 23.987 8.741 24 12 24s3.668-.013 4.948-.072c1.281-.059 2.393-.291 3.374-1.272.981-.981 1.213-2.093 1.272-3.374.059-1.28.072-1.689.072-7.282 0-5.593-.013-6.002-.072-7.282-.059-1.281-.291-2.393-1.272-3.374C19.341.363 18.229.131 16.948.072 15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
      <a href="https://instagram.com/donordarahjakarta" target="_blank" class="footer-pmi-ig-link">@donordarahjakarta (Instagram Resmi PMI)</a>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('footerWaForm');
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const nama = document.getElementById('footerNama').value.trim();
        const email = document.getElementById('footerEmail').value.trim();
        const ig = document.getElementById('footerInstagram').value.trim();
        const pesan = document.getElementById('footerPesan').value.trim();
        if (!nama || !email || !pesan) {
          alert('Semua kolom wajib diisi kecuali Instagram!');
          return;
        }
        const nomorWa = '6289521006019';
        let pesanWa = `Nama: ${nama}%0AEmail: ${email}`;
        if(ig) pesanWa += `%0AInstagram: ${ig}`;
        pesanWa += `%0APesan: ${pesan}`;
        const url = `https://wa.me/${nomorWa}?text=${pesanWa}`;
        window.open(url, '_blank');
      });
    });
  </script>
</footer>

  <!-- Konten halaman lainnya di atas -->

  <footer class="footer">
    <p class="footer-text">
      Copyright © 2024 – Sahabat Darah. All rights reserved.
    </p>
  </footer>