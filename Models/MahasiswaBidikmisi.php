<?php

// ============================================================
//  UAS Pemrograman Berorientasi Objek (PBO)
//  Kelas   : TRPL 1A
//  Nama    : Irfan Fatih Rizki
//  Tahap   : 4 — Subclass MahasiswaBidikmisi
// ============================================================

require_once 'koneksi.php';
require_once 'Mahasiswa.php';

class MahasiswaBidikmisi extends Mahasiswa
{
    // ────────────────────────────────────────────────────────
    //  Properti Tambahan (Spesifik Bidikmisi)
    //  Mapped dari kolom: nomor_kk (sebagai nomorKipKuliah),
    //                     dana_saku_subsidi
    // ────────────────────────────────────────────────────────
    protected string $nomorKipKuliah;
    protected float  $danaSakuSubsidi;

    // ────────────────────────────────────────────────────────
    //  Constructor
    // ────────────────────────────────────────────────────────
    public function __construct(
        int    $id_mahasiswa,
        string $nama_mahasiswa,
        string $nim_semester,
        float  $tarifUktNominal,
        string $nomorKipKuliah,
        float  $danaSakuSubsidi
    ) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim_semester, $tarifUktNominal);
        $this->nomorKipKuliah  = $nomorKipKuliah;
        $this->danaSakuSubsidi = $danaSakuSubsidi;
    }

    // ────────────────────────────────────────────────────────
    //  Implementasi Method Abstrak
    // ────────────────────────────────────────────────────────

    /**
     * Bidikmisi = UKT ditanggung penuh, tagihan Rp 0
     */
    public function hitungTagihanSemester(): float
    {
        return 0;
    }

    /**
     * Menampilkan detail akademik mahasiswa Bidikmisi
     */
    public function tampilkanSpesifikasiAkademik(): void
    {
        echo "===== SPESIFIKASI AKADEMIK (BIDIKMISI) =====\n";
        echo "ID Mahasiswa    : " . $this->id_mahasiswa    . "\n";
        echo "Nama            : " . $this->nama_mahasiswa  . "\n";
        echo "NIS             : " . $this->nis             . "\n";
        echo "Semester        : " . $this->semester        . "\n";
        echo "No. KIP Kuliah  : " . $this->nomorKipKuliah  . "\n";
        echo "Dana Saku/Bulan : Rp " . number_format($this->danaSakuSubsidi, 0, ',', '.') . "\n";
        echo "Tagihan Semester: Rp " . number_format($this->hitungTagihanSemester(), 0, ',', '.') . " (Ditanggung Negara)\n";
        echo "=============================================\n";
    }

    // ────────────────────────────────────────────────────────
    //  Query SELECT-WHERE khusus MahasiswaBidikmisi
    // ────────────────────────────────────────────────────────

    /**
     * Mengambil data mahasiswa Bidikmisi berdasarkan id_mahasiswa
     * dari tabel_mahasiswa menggunakan query SELECT-WHERE
     */
    public static function cariById(int $id): void
    {
        global $koneksi;

        $query  = "SELECT * FROM tabel_mahasiswa 
                   WHERE jenis_pembayaran = 'Bidikmisi' 
                   AND id_mahasiswa = $id";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $mhs = new MahasiswaBidikmisi(
                $row['id_mahasiswa'],
                $row['nama_mahasiswa'],
                $row['nim_semester'],
                (float) $row['tarif_ukt_nominal'],
                $row['nomor_kk'],
                (float) $row['dana_saku_subsidi']
            );
            $mhs->tampilkanSpesifikasiAkademik();
        } else {
            echo "Data mahasiswa Bidikmisi dengan ID $id tidak ditemukan.\n";
        }
    }
}