<?php

// ============================================================
//  UAS Pemrograman Berorientasi Objek (PBO)
//  Kelas   : TRPL 1A
//  Nama    : Irfan Fatih Rizki
//  Tahap   : 3 — Implementasi Abstraksi (Abstraction)
// ============================================================

abstract class Mahasiswa
{
    // ────────────────────────────────────────────────────────
    //  Properti Terenkapsulasi (protected)
    //  Dipetakan langsung dari kolom tabel_mahasiswa (Tahap 1)
    // ────────────────────────────────────────────────────────

    /**
     * Mapped dari kolom: id_mahasiswa
     */
    protected int $id_mahasiswa;

    /**
     * Mapped dari kolom: nama_mahasiswa
     */
    protected string $nama_mahasiswa;

    /**
     * Mapped dari kolom: nim_semester (bagian NIM)
     * Format nim_semester di DB → "2201001/4"
     * $nis mengambil bagian sebelum "/"
     */
    protected string $nis;

    /**
     * Mapped dari kolom: nim_semester (bagian Semester)
     * $semester mengambil bagian setelah "/"
     */
    protected int $semester;

    /**
     * Mapped dari kolom: tarif_ukt_nominal
     */
    protected float $tarifUktNominal;


    // ────────────────────────────────────────────────────────
    //  Constructor
    //  Menerima nilai dari kolom DB dan memetakannya ke properti
    // ────────────────────────────────────────────────────────

    public function __construct(
        int    $id_mahasiswa,
        string $nama_mahasiswa,
        string $nim_semester,       // nilai mentah dari kolom nim_semester DB
        float  $tarifUktNominal
    ) {
        $this->id_mahasiswa    = $id_mahasiswa;
        $this->nama_mahasiswa  = $nama_mahasiswa;
        $this->tarifUktNominal = $tarifUktNominal;

        // Memecah "2201001/4" → nis = "2201001", semester = 4
        $parts          = explode('/', $nim_semester);
        $this->nis      = $parts[0];
        $this->semester = (int) ($parts[1] ?? 1);
    }


    // ────────────────────────────────────────────────────────
    //  Metode Abstrak (Wajib diimplementasikan oleh child class)
    // ────────────────────────────────────────────────────────

    /**
     * Menghitung total tagihan yang harus dibayar mahasiswa
     * pada semester berjalan.
     * Implementasi berbeda-beda tergantung jenis pembayaran.
     */
    abstract public function hitungTagihanSemester(): float;

    /**
     * Menampilkan spesifikasi / detail akademik mahasiswa
     * sesuai jenis pembayarannya (Mandiri / Bidikmisi / Prestasi).
     */
    abstract public function tampilkanSpesifikasiAkademik(): void;


    // ────────────────────────────────────────────────────────
    //  Getter — akses properti protected dari luar class
    // ────────────────────────────────────────────────────────

    public function getIdMahasiswa(): int
    {
        return $this->id_mahasiswa;
    }

    public function getNamaMahasiswa(): string
    {
        return $this->nama_mahasiswa;
    }

    public function getNis(): string
    {
        return $this->nis;
    }

    public function getSemester(): int
    {
        return $this->semester;
    }

    public function getTarifUktNominal(): float
    {
        return $this->tarifUktNominal;
    }
}