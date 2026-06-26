<?php

// ============================================================
//  UAS Pemrograman Berorientasi Objek (PBO)
//  Kelas   : TRPL 1A
//  Nama    : Irfan Fatih Rizki
//  Tahap   : 4 — Subclass MahasiswaPrestasi
// ============================================================

require_once 'koneksi.php';
require_once 'Mahasiswa.php';

class MahasiswaPrestasi extends Mahasiswa
{
    // ────────────────────────────────────────────────────────
    //  Properti Tambahan (Spesifik Prestasi)
    //  Mapped dari kolom: nama_instansi_beasiswa,
    //                     minimal_ipk_syarat
    // ────────────────────────────────────────────────────────
    protected string $namaInstansiBeasiswa;
    protected float  $minimalIpkSyarat;

    // ────────────────────────────────────────────────────────
    //  Constructor
    // ────────────────────────────────────────────────────────
    public function __construct(
        int    $id_mahasiswa,
        string $nama_mahasiswa,
        string $nim_semester,
        float  $tarifUktNominal,
        string $namaInstansiBeasiswa,
        float  $minimalIpkSyarat
    ) {
        parent::__construct($id_mahasiswa, $nama_mahasiswa, $nim_semester, $tarifUktNominal);
        $this->namaInstansiBeasiswa = $namaInstansiBeasiswa;
        $this->minimalIpkSyarat     = $minimalIpkSyarat;
    }

    // ────────────────────────────────────────────────────────
    //  Implementasi Method Abstrak
    // ────────────────────────────────────────────────────────

    /**
     * Prestasi = tarif UKT dikurangi subsidi beasiswa
     * Jika tarif_ukt_nominal = 0, tagihan = 0 (full beasiswa)
     */
    public function hitungTagihanSemester(): float
    {
        return $this->tarifUktNominal;
    }

    /**
     * Menampilkan detail akademik mahasiswa Prestasi
     */
    public function tampilkanSpesifikasiAkademik(): void
    {
        echo "===== SPESIFIKASI AKADEMIK (PRESTASI) =====\n";
        echo "ID Mahasiswa      : " . $this->id_mahasiswa        . "\n";
        echo "Nama              : " . $this->nama_mahasiswa      . "\n";
        echo "NIS               : " . $this->nis                 . "\n";
        echo "Semester          : " . $this->semester            . "\n";
        echo "Instansi Beasiswa : " . $this->namaInstansiBeasiswa . "\n";
        echo "Minimal IPK       : " . number_format($this->minimalIpkSyarat, 2) . "\n";
        echo "Tagihan Semester  : Rp " . number_format($this->hitungTagihanSemester(), 0, ',', '.') . "\n";
        echo "============================================\n";
    }

    // ────────────────────────────────────────────────────────
    //  Query SELECT-WHERE khusus MahasiswaPrestasi
    // ────────────────────────────────────────────────────────

    /**
     * Mengambil data mahasiswa Prestasi berdasarkan id_mahasiswa
     * dari tabel_mahasiswa menggunakan query SELECT-WHERE
     */
    public static function cariById(int $id): void
    {
        global $koneksi;

        $query  = "SELECT * FROM tabel_mahasiswa 
                   WHERE jenis_pembayaran = 'Prestasi' 
                   AND id_mahasiswa = $id";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $mhs = new MahasiswaPrestasi(
                $row['id_mahasiswa'],
                $row['nama_mahasiswa'],
                $row['nim_semester'],
                (float) $row['tarif_ukt_nominal'],
                $row['nama_instansi_beasiswa'],
                (float) $row['minimal_ipk_syarat']
            );
            $mhs->tampilkanSpesifikasiAkademik();
        } else {
            echo "Data mahasiswa Prestasi dengan ID $id tidak ditemukan.\n";
        }
    }
}