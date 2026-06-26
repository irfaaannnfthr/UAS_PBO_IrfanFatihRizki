<?php
// ============================================================
//  UAS Pemrograman Berorientasi Objek (PBO)
//  Kelas   : TRPL 1A
//  Nama    : Irfan Fatih Rizki
//  Tahap   : 6 — View Antarmuka Daftar Registrasi Pembayaran
// ============================================================

require_once 'Koneksi/koneksi.php';
require_once 'Models/Mahasiswa.php';
require_once 'Models/MahasiswaMandiri.php';
require_once 'Models/MahasiswaBidikmisi.php';
require_once 'Models/MahasiswaPrestasi.php';

// ── Helper format Rupiah ──────────────────────────────────────
function rp(float $n): string {
    return 'Rp ' . number_format($n, 0, ',', '.');
}

// ── Ambil data per kategori dari DB ──────────────────────────
$resMandiri   = mysqli_query($koneksi, "SELECT * FROM tabel_mahasiswa WHERE jenis_pembayaran = 'Mandiri'   ORDER BY id_mahasiswa");
$resBidikmisi = mysqli_query($koneksi, "SELECT * FROM tabel_mahasiswa WHERE jenis_pembayaran = 'Bidikmisi' ORDER BY id_mahasiswa");
$resPrestasi  = mysqli_query($koneksi, "SELECT * FROM tabel_mahasiswa WHERE jenis_pembayaran = 'Prestasi'  ORDER BY id_mahasiswa");

// ── Simpan hasil query ke array agar bisa dipakai 2x ─────────
$dataMandiri   = [];
$dataBidikmisi = [];
$dataPrestasi  = [];

while ($row = mysqli_fetch_assoc($resMandiri))   { $dataMandiri[]   = $row; }
while ($row = mysqli_fetch_assoc($resBidikmisi)) { $dataBidikmisi[] = $row; }
while ($row = mysqli_fetch_assoc($resPrestasi))  { $dataPrestasi[]  = $row; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pembayaran Kuliah — TRPL 1A</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0f1117;
            --surface:   #1a1d27;
            --border:    #2a2d3e;
            --text:      #e8eaf0;
            --muted:     #7a7f9a;
            --mandiri:   #4f8ef7;
            --bidikmisi: #34d399;
            --prestasi:  #f59e0b;
            --radius:    10px;
            --font-body: 'Segoe UI', system-ui, sans-serif;
            --font-mono: 'Consolas', 'Courier New', monospace;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: var(--font-body);
            font-size: 14px;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ── Header ─────────────────────────────────── */
        .site-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 24px 40px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .site-header .logo {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--mandiri), var(--prestasi));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 800; color: #fff;
            flex-shrink: 0;
        }
        .site-header h1 { font-size: 18px; font-weight: 700; letter-spacing: -.3px; }
        .site-header p  { font-size: 12px; color: var(--muted); margin-top: 2px; }

        /* ── Layout ─────────────────────────────────── */
        .container { max-width: 1200px; margin: 0 auto; padding: 36px 24px 60px; }

        /* ── Stats bar ──────────────────────────────── */
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 40px; }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 24px;
            border-top: 3px solid var(--accent, var(--mandiri));
        }
        .stat-card.m { --accent: var(--mandiri);   }
        .stat-card.b { --accent: var(--bidikmisi); }
        .stat-card.p { --accent: var(--prestasi);  }
        .stat-card .label { font-size: 11px; text-transform: uppercase; letter-spacing: .8px; color: var(--muted); }
        .stat-card .value { font-size: 28px; font-weight: 800; color: var(--accent); margin: 4px 0 2px; }
        .stat-card .sub   { font-size: 12px; color: var(--muted); }

        /* ── Section ────────────────────────────────── */
        .section { margin-bottom: 48px; }
        .section-header {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }
        .badge {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 4px 12px; border-radius: 20px;
            font-size: 11px; font-weight: 700; letter-spacing: .5px;
            text-transform: uppercase;
        }
        .badge.m { background: rgba(79,142,247,.15); color: var(--mandiri); }
        .badge.b { background: rgba(52,211,153,.15); color: var(--bidikmisi); }
        .badge.p { background: rgba(245,158,11,.15); color: var(--prestasi); }
        .section-header h2 { font-size: 16px; font-weight: 700; }

        /* ── Table ──────────────────────────────────── */
        .table-wrap { overflow-x: auto; border-radius: var(--radius); border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; }
        thead { background: var(--surface); }
        thead th {
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: var(--muted);
            white-space: nowrap;
            border-bottom: 1px solid var(--border);
        }
        tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.03); }
        tbody td { padding: 13px 16px; vertical-align: middle; font-size: 13px; }

        /* ── Cell styles ────────────────────────────── */
        .cell-id    { color: var(--muted); font-family: var(--font-mono); font-size: 12px; }
        .cell-name  { font-weight: 600; }
        .cell-nim   { font-family: var(--font-mono); font-size: 12px; color: var(--muted); }
        .cell-money { font-family: var(--font-mono); font-size: 13px; font-weight: 600; }
        .cell-tagihan   { font-family: var(--font-mono); font-size: 13px; font-weight: 700; }
        .cell-tagihan.m { color: var(--mandiri); }
        .cell-tagihan.b { color: var(--bidikmisi); }
        .cell-tagihan.p { color: var(--prestasi); }
        .cell-info  { font-size: 12px; color: var(--muted); }
        .pill { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; background: rgba(79,142,247,.1); color: var(--mandiri); }
        .pill.free { background: rgba(52,211,153,.1); color: var(--bidikmisi); }

        /* ── Footer ─────────────────────────────────── */
        .site-footer { text-align: center; padding: 24px; border-top: 1px solid var(--border); color: var(--muted); font-size: 12px; }

        @media (max-width: 640px) {
            .stats { grid-template-columns: 1fr; }
            .site-header { padding: 16px 20px; }
            .container { padding: 24px 16px 48px; }
        }
    </style>
</head>
<body>

<header class="site-header">
    <div class="logo">P</div>
    <div>
        <h1>Sistem Registrasi Pembayaran Kuliah</h1>
        <p>UAS Pemrograman Berorientasi Objek &mdash; TRPL 1A &mdash; Irfan Fatih Rizki</p>
    </div>
</header>

<div class="container">

    <!-- Stats -->
    <div class="stats">
        <div class="stat-card m">
            <div class="label">Mahasiswa Mandiri</div>
            <div class="value"><?= count($dataMandiri) ?></div>
            <div class="sub">UKT + Rp 100.000 operasional</div>
        </div>
        <div class="stat-card b">
            <div class="label">Mahasiswa Bidikmisi</div>
            <div class="value"><?= count($dataBidikmisi) ?></div>
            <div class="sub">Biaya ditanggung negara (KIP-K)</div>
        </div>
        <div class="stat-card p">
            <div class="label">Mahasiswa Prestasi</div>
            <div class="value"><?= count($dataPrestasi) ?></div>
            <div class="sub">Potongan beasiswa 75%</div>
        </div>
    </div>

    <!-- A. MANDIRI -->
    <div class="section">
        <div class="section-header">
            <span class="badge m">Mandiri</span>
            <h2>Daftar Mahasiswa Mandiri</h2>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Smt</th>
                        <th>Gol. UKT</th>
                        <th>Nama Wali</th>
                        <th>Tarif UKT</th>
                        <th>Biaya Operasional</th>
                        <th>Tagihan Semester</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($dataMandiri as $row):
                    $obj = new MahasiswaMandiri(
                        (int)$row['id_mahasiswa'],
                        $row['nama_mahasiswa'],
                        $row['nim_semester'],
                        (float)$row['tarif_ukt_nominal'],
                        $row['golongan_ukt'],
                        $row['nama_wali']
                    );
                ?>
                <tr>
                    <td class="cell-id">#<?= $obj->getIdMahasiswa() ?></td>
                    <td class="cell-name"><?= htmlspecialchars($obj->getNamaMahasiswa()) ?></td>
                    <td class="cell-nim"><?= htmlspecialchars($obj->getNis()) ?></td>
                    <td class="cell-info"><?= $obj->getSemester() ?></td>
                    <td><span class="pill"><?= htmlspecialchars($row['golongan_ukt']) ?></span></td>
                    <td class="cell-info"><?= htmlspecialchars($row['nama_wali']) ?></td>
                    <td class="cell-money"><?= rp($obj->getTarifUktNominal()) ?></td>
                    <td class="cell-info">Rp 100.000</td>
                    <td class="cell-tagihan m"><?= rp($obj->hitungTagihanSemester()) ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- B. BIDIKMISI -->
    <div class="section">
        <div class="section-header">
            <span class="badge b">Bidikmisi</span>
            <h2>Daftar Mahasiswa Bidikmisi</h2>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Smt</th>
                        <th>No. KIP Kuliah (KK)</th>
                        <th>Nama Wali</th>
                        <th>Dana Saku/Bulan</th>
                        <th>Tagihan Semester</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($dataBidikmisi as $row):
                    $obj = new MahasiswaBidikmisi(
                        (int)$row['id_mahasiswa'],
                        $row['nama_mahasiswa'],
                        $row['nim_semester'],
                        (float)$row['tarif_ukt_nominal'],
                        $row['nomor_kk'],
                        (float)$row['dana_saku_subsidi']
                    );
                ?>
                <tr>
                    <td class="cell-id">#<?= $obj->getIdMahasiswa() ?></td>
                    <td class="cell-name"><?= htmlspecialchars($obj->getNamaMahasiswa()) ?></td>
                    <td class="cell-nim"><?= htmlspecialchars($obj->getNis()) ?></td>
                    <td class="cell-info"><?= $obj->getSemester() ?></td>
                    <td class="cell-info"><?= htmlspecialchars($row['nomor_kk']) ?></td>
                    <td class="cell-info"><?= htmlspecialchars($row['nama_wali']) ?></td>
                    <td class="cell-money"><?= rp((float)$row['dana_saku_subsidi']) ?></td>
                    <td><span class="pill free">Rp 0 &mdash; Ditanggung Negara</span></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- C. PRESTASI -->
    <div class="section">
        <div class="section-header">
            <span class="badge p">Prestasi</span>
            <h2>Daftar Mahasiswa Prestasi</h2>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Smt</th>
                        <th>Instansi Beasiswa</th>
                        <th>Min. IPK</th>
                        <th>Tarif UKT</th>
                        <th>Potongan</th>
                        <th>Tagihan Semester</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($dataPrestasi as $row):
                    $obj = new MahasiswaPrestasi(
                        (int)$row['id_mahasiswa'],
                        $row['nama_mahasiswa'],
                        $row['nim_semester'],
                        (float)$row['tarif_ukt_nominal'],
                        $row['nama_instansi_beasiswa'],
                        (float)$row['minimal_ipk_syarat']
                    );
                ?>
                <tr>
                    <td class="cell-id">#<?= $obj->getIdMahasiswa() ?></td>
                    <td class="cell-name"><?= htmlspecialchars($obj->getNamaMahasiswa()) ?></td>
                    <td class="cell-nim"><?= htmlspecialchars($obj->getNis()) ?></td>
                    <td class="cell-info"><?= $obj->getSemester() ?></td>
                    <td class="cell-info"><?= htmlspecialchars($row['nama_instansi_beasiswa']) ?></td>
                    <td class="cell-info"><?= number_format((float)$row['minimal_ipk_syarat'], 2) ?></td>
                    <td class="cell-money"><?= rp($obj->getTarifUktNominal()) ?></td>
                    <td class="cell-info">75%</td>
                    <td class="cell-tagihan p"><?= rp($obj->hitungTagihanSemester()) ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<footer class="site-footer">
    &copy; <?= date('Y') ?> &mdash; UAS PBO TRPL 1A &mdash; Irfan Fatih Rizki &mdash; DB: DB_UAS_PBO_TRPL1A_IrfanFatihRizki
</footer>

</body>
</html>