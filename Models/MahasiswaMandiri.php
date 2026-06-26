<?php

// ============================================================
//  UAS Pemrograman Berorientasi Objek (PBO)
//  Kelas   : TRPL 1A
//  Nama    : Irfan Fatih Rizki
//  Tahap   : 4 & 5 — Subclass MahasiswaMandiri + Polimorfisme
// ============================================================

require_once 'koneksi.php';
require_once 'Mahasiswa.php';

class MahasiswaMandiri extends Mahasiswa
{
    // ────────────────────────────────────────────────────────
    //  Properti Tambahan (Spesifik Mandiri)
    //  Mapped dari kolom: golongan_ukt, nama_wali
    // ────────────────────────────────────────────────────────
    protected string $golonganUkt;
    protected string $namaWali;

    // ────────────────────────────────────────────────────────
    //  Constructor
    // ────────────────────────────────────────────────────────
    public function __construct(
        int    $id_mahasiswa,
        string $nama_mahasiswa,
        string $nim_semester,
        float  $tarifUktNominal,
        string $golonganUkt,
        string $namaWali
    ) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim_semester, $tarifUktNominal);
        $this->golonganUkt = $golonganUkt;
        $this->namaWali    = $namaWali;
    }

    // ────────────────────────────────────────────────────────
    //  Implementasi Method Abstrak
    // ────────────────────────────────────────────────────────

    /**
     * OVERRIDE Tahap 5 — Polimorfisme
     * Tagihan = tarifUktNominal + Rp 100.000 (biaya operasional/praktikum)
     */
    public function hitungTagihanSemester(): float
    {
        return $this->tarifUktNominal + 100000;
    }

    /**
     * Menampilkan detail akademik mahasiswa Mandiri
     */
    public function tampilkanSpesifikasiAkademik(): void
    {
        echo "===== SPESIFIKASI AKADEMIK (MANDIRI) =====\n";
        echo "ID Mahasiswa      : " . $this->id_mahasiswa    . "\n";
        echo "Nama              : " . $this->nama_mahasiswa  . "\n";
        echo "NIS               : " . $this->nis             . "\n";
        echo "Semester          : " . $this->semester        . "\n";
        echo "Golongan UKT      : " . $this->golonganUkt     . "\n";
        echo "Nama Wali         : " . $this->namaWali        . "\n";
        echo "Tarif UKT         : Rp " . number_format($this->tarifUktNominal, 0, ',', '.') . "\n";
        echo "Biaya Operasional : Rp 100.000\n";
        echo "Tagihan Semester  : Rp " . number_format($this->hitungTagihanSemester(), 0, ',', '.') . "\n";
        echo "==========================================\n";
    }

    // ────────────────────────────────────────────────────────
    //  Query SELECT-WHERE khusus MahasiswaMandiri
    // ────────────────────────────────────────────────────────

    /**
     * Mengambil data mahasiswa Mandiri berdasarkan id_mahasiswa
     * dari tabel_mahasiswa menggunakan query SELECT-WHERE
     */
    public static function cariById(int $id): void
    {
        global $koneksi;

        $query  = "SELECT * FROM tabel_mahasiswa 
                   WHERE jenis_pembayaran = 'Mandiri' 
                   AND id_mahasiswa = $id";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $mhs = new MahasiswaMandiri(
                $row['id_mahasiswa'],
                $row['nama_mahasiswa'],
                $row['nim_semester'],
                (float) $row['tarif_ukt_nominal'],
                $row['golongan_ukt'],
                $row['nama_wali']
            );
            $mhs->tampilkanSpesifikasiAkademik();
        } else {
            echo "Data mahasiswa Mandiri dengan ID $id tidak ditemukan.\n";
        }
    }
}