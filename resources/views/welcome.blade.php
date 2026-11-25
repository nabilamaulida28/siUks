<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SIUKS membantu sekolah mencatat kunjungan UKS dan memantau kesehatan siswa dengan lebih mudah.">
    <title>SIUKS — Ruang Sehat untuk Tumbuh</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #19372c;
            --muted: #64746b;
            --green: #237b58;
            --green-dark: #15583f;
            --mint: #e6f1e9;
            --paper: #fbfaf6;
            --line: #e7e9e1;
            font-family: "Plus Jakarta Sans", "Segoe UI", sans-serif;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; color: var(--ink); background: var(--paper); }
        a { color: inherit; text-decoration: none; }
        a:focus-visible { outline: 3px solid #d38c48; outline-offset: 4px; }
        .wrap { width: min(1120px, calc(100% - 48px)); margin: 0 auto; }
        .topbar { height: 82px; display: flex; align-items: center; justify-content: space-between; }
        .brand { display: inline-flex; align-items: center; gap: 11px; font-size: 19px; font-weight: 800; letter-spacing: -.7px; }
        .brand-mark { width: 38px; height: 38px; display: grid; place-items: center; color: white; background: var(--green); border-radius: 12px; }
        .brand-mark svg { width: 23px; height: 23px; }
        .brand span:last-child { color: var(--green); }
        .nav { display: flex; align-items: center; gap: 34px; color: #53665b; font-size: 13px; font-weight: 600; }
        .nav a:hover { color: var(--green); }
        .nav .nav-login { padding: 11px 18px; color: white; background: var(--green); border-radius: 7px; }
        .nav .nav-login:hover { color: white; background: var(--green-dark); }
        .hero { display: grid; grid-template-columns: 1.02fr .98fr; align-items: center; gap: 74px; padding: 70px 0 94px; }
        .eyebrow { display: inline-flex; align-items: center; gap: 9px; color: var(--green); font-size: 11px; font-weight: 800; letter-spacing: 1.4px; text-transform: uppercase; }
        .eyebrow::before { width: 22px; height: 1px; content: ""; background: #8eae98; }
        h1 { max-width: 550px; margin: 22px 0 20px; font-size: clamp(42px, 5vw, 64px); line-height: 1.08; letter-spacing: -3.2px; }
        h1 em { color: var(--green); font-style: normal; }
        .intro { max-width: 470px; margin: 0; color: var(--muted); font-size: 15px; line-height: 1.85; }
        .actions { display: flex; flex-wrap: wrap; align-items: center; gap: 24px; margin-top: 32px; }
        .button { display: inline-flex; align-items: center; gap: 11px; padding: 14px 20px; color: white; background: var(--green); border-radius: 7px; font-size: 13px; font-weight: 700; transition: background .2s, transform .2s; }
        .button:hover { background: var(--green-dark); transform: translateY(-2px); }
        .button svg { width: 16px; height: 16px; }
        .text-link { color: #50665a; font-size: 13px; font-weight: 700; }
        .text-link:hover { color: var(--green); }
        .hero-art { position: relative; min-height: 405px; display: grid; place-items: center; }
        .art-wash { position: absolute; inset: 20px 14px 8px 36px; background: #eaf1e8; border-radius: 48% 52% 43% 57% / 49% 42% 58% 51%; transform: rotate(-7deg); }
        .visit-card { position: relative; width: min(100%, 360px); padding: 24px; background: white; border: 1px solid #edf0e9; border-radius: 14px; box-shadow: 0 18px 55px #234d3912; transform: rotate(1.5deg); }
        .card-top { display: flex; align-items: center; justify-content: space-between; padding-bottom: 18px; border-bottom: 1px solid var(--line); }
        .card-kicker { color: #89968c; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .status { padding: 6px 9px; color: #24744d; background: #eaf5ec; border-radius: 30px; font-size: 10px; font-weight: 700; }
        .student { display: flex; align-items: center; gap: 13px; padding: 20px 0; }
        .avatar { width: 43px; height: 43px; display: grid; place-items: center; color: #276343; background: #edf4df; border-radius: 50%; font-size: 13px; font-weight: 800; }
        .student strong, .student small { display: block; }
        .student strong { font-size: 13px; }
        .student small { margin-top: 4px; color: #8a968e; font-size: 10px; }
        .symptom { padding: 13px 14px; background: #f7f8f3; border-radius: 8px; }
        .symptom small { color: #89968c; font-size: 10px; }
        .symptom p { margin: 5px 0 0; color: #314d3d; font-size: 12px; font-weight: 700; }
        .card-foot { display: flex; align-items: center; justify-content: space-between; margin-top: 18px; color: #89968c; font-size: 10px; }
        .card-foot strong { color: var(--green); font-size: 11px; }
        .note { position: absolute; right: -17px; bottom: 42px; display: flex; align-items: center; gap: 11px; padding: 13px 15px; background: white; border: 1px solid #edf0e9; border-radius: 10px; box-shadow: 0 12px 30px #234d3910; }
        .note-icon { width: 34px; height: 34px; display: grid; place-items: center; color: var(--green); background: var(--mint); border-radius: 9px; }
        .note-icon svg { width: 18px; height: 18px; }
        .note strong, .note small { display: block; }
        .note strong { font-size: 11px; }
        .note small { margin-top: 3px; color: #89968c; font-size: 9px; }
        .features { padding: 66px 0 76px; background: #f1f3eb; }
        .section-head { display: flex; justify-content: space-between; align-items: end; gap: 24px; margin-bottom: 31px; }
        .section-head h2 { max-width: 420px; margin: 12px 0 0; font-size: clamp(25px, 3vw, 34px); line-height: 1.25; letter-spacing: -1.2px; }
        .section-head p { max-width: 350px; margin: 0 0 3px; color: var(--muted); font-size: 12px; line-height: 1.8; }
        .feature-list { display: grid; grid-template-columns: repeat(3, 1fr); border-top: 1px solid #dfe4da; }
        .feature { padding: 27px 28px 0 0; }
        .feature + .feature { padding-left: 28px; border-left: 1px solid #dfe4da; }
        .feature-number { color: #86a18e; font-size: 11px; font-weight: 800; letter-spacing: 1px; }
        .feature h3 { margin: 17px 0 8px; font-size: 15px; letter-spacing: -.2px; }
        .feature p { max-width: 280px; margin: 0; color: var(--muted); font-size: 12px; line-height: 1.8; }
        .footer { display: flex; justify-content: space-between; align-items: center; gap: 20px; padding: 26px 0; color: #7a887f; font-size: 11px; }
        .footer strong { color: var(--ink); }

        @media (max-width: 760px) {
            .wrap { width: min(100% - 36px, 560px); }
            .topbar { height: 72px; }
            .nav { gap: 14px; }
            .nav > a:not(.nav-login) { display: none; }
            .nav .nav-login { padding: 10px 13px; font-size: 11px; }
            .hero { grid-template-columns: 1fr; gap: 14px; padding: 51px 0 60px; }
            h1 { max-width: 500px; font-size: clamp(42px, 11vw, 58px); letter-spacing: -2.6px; }
            .intro { font-size: 14px; }
            .hero-art { min-height: 360px; margin: 0 -7px; }
            .visit-card { max-width: 330px; }
            .note { right: 0; bottom: 27px; }
            .features { padding: 52px 0 58px; }
            .section-head { display: block; }
            .section-head p { margin-top: 12px; }
            .feature-list { grid-template-columns: 1fr; }
            .feature, .feature + .feature { padding: 21px 0; border-left: 0; border-bottom: 1px solid #dfe4da; }
            .feature h3 { margin-top: 9px; }
            .footer { align-items: flex-start; flex-direction: column; gap: 8px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
    <header class="wrap topbar">
        <a class="brand" href="/" aria-label="SIUKS, halaman utama">
            <span class="brand-mark" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 21s-8-4.4-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.6-8 11-8 11Z"/><path d="M8.5 12h7M12 8.5v7"/>
                </svg>
            </span>
            SI<span>UKS</span>
        </a>
        <nav class="nav" aria-label="Navigasi utama">
            <a href="#tentang">Tentang SIUKS</a>
            <a href="#layanan">Layanan</a>
            <a class="nav-login" href="{{ route('login', [], false) }}">Masuk</a>
        </nav>
    </header>

    <main>
        <section class="wrap hero" aria-labelledby="hero-title">
            <div>
                <p class="eyebrow">Sehat, nyaman, siap belajar</p>
                <h1 id="hero-title">Kenali lebih cepat,<br><em>rawat lebih baik.</em></h1>
                <p class="intro">SIUKS membantu sekolah mencatat kunjungan UKS dan memantau kondisi siswa dengan lebih mudah, rapi, dan terarah.</p>
                <div class="actions">
                    <a class="button" href="{{ route('login', [], false) }}">
                        Masuk ke portal
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a class="text-link" href="#layanan">Kenali layanannya <span aria-hidden="true">↓</span></a>
                </div>
            </div>

            <div class="hero-art" aria-label="Ilustrasi catatan kunjungan siswa di UKS" role="img">
                <div class="art-wash" aria-hidden="true"></div>
                <div class="visit-card" aria-hidden="true">
                    <div class="card-top">
                        <span class="card-kicker">Catatan kunjungan</span>
                        <span class="status">● Selesai</span>
                    </div>
                    <div class="student">
                        <span class="avatar">AN</span>
                        <span><strong>Aditya Nugraha</strong><small>Kelas VIII · 10.24 WIB</small></span>
                    </div>
                    <div class="symptom">
                        <small>Keluhan</small>
                        <p>Pusing ringan setelah olahraga</p>
                    </div>
                    <div class="card-foot"><span>Ditangani oleh petugas UKS</span><strong>Catatan tersimpan</strong></div>
                </div>
                <div class="note" aria-hidden="true">
                    <span class="note-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3h8l4 4v14H4V3h4Z"/><path d="M8 3v5h8V3M8 14h8M8 18h5"/></svg>
                    </span>
                    <span><strong>Data tertata rapi</strong><small>Riwayat mudah dipantau</small></span>
                </div>
            </div>
        </section>

        <section class="features" id="layanan" aria-labelledby="features-title">
            <div class="wrap">
                <div class="section-head" id="tentang">
                    <div>
                        <p class="eyebrow">Satu langkah lebih peduli</p>
                        <h2 id="features-title">Dukungan sehat untuk aktivitas belajar.</h2>
                    </div>
                    <p>Dari kunjungan harian hingga rekap kesehatan, semua dirancang agar sekolah dapat memberi perhatian yang tepat.</p>
                </div>
                <div class="feature-list">
                    <article class="feature">
                        <span class="feature-number">01 / KUNJUNGAN</span>
                        <h3>Pencatatan yang praktis</h3>
                        <p>Catat keluhan, penanganan, dan waktu kunjungan siswa dalam satu alur yang mudah diikuti.</p>
                    </article>
                    <article class="feature">
                        <span class="feature-number">02 / PEMANTAUAN</span>
                        <h3>Riwayat lebih terarah</h3>
                        <p>Informasi kunjungan tersimpan rapi sehingga petugas dapat melihat kembali riwayat yang dibutuhkan.</p>
                    </article>
                    <article class="feature">
                        <span class="feature-number">03 / LAPORAN</span>
                        <h3>Ringkasan untuk sekolah</h3>
                        <p>Rekap kunjungan membantu sekolah memahami kebutuhan UKS dan merencanakan tindak lanjut.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer class="wrap footer">
        <span><strong>SIUKS</strong> · Sistem Informasi Kesehatan Siswa</span>
        <span>Menjaga sehat, mendukung semangat belajar.</span>
    </footer>
</body>
</html>
