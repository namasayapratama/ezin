<?php 
namespace App\Exports;

use App\Models\IzinKeluar;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class IzinKeluarExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell
{
    protected $data;
    protected $schoolName;
    protected $start;
    protected $end;

    public function __construct($data, $start = null, $end = null, $schoolName = null) {
        $this->data = $data;
        $this->start = $start ? Carbon::parse($start) : Carbon::now()->startOfMonth();
        $this->end = $end ? Carbon::parse($end) : Carbon::now()->endOfMonth();
        $this->schoolName = $schoolName ?? setting('school_name', 'APLIKASI E-IZIN SEKOLAH');
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($izin): array
    {
        return [
            $izin->user->name,
            $izin->user->kelas,
            \Carbon\Carbon::parse($izin->waktu_izin)->format('d/m/Y H:i'),
            $izin->alasan,
        ];
    }

    public function headings(): array
    {
        return ['Nama', 'Kelas', 'Tanggal', 'Alasan'];
    }

    public function startCell(): string
    {
        return 'A4'; // Data mulai dari baris ke-4
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Nama sekolah
                $event->sheet->setCellValue('A1', $this->schoolName);
                // Judul
                $event->sheet->setCellValue('A2', 'REKAP IZIN KELUAR');
                // Periode
                $event->sheet->setCellValue('A3', 'Periode: ' . $this->start->translatedFormat('d F Y') . ' s/d ' . $this->end->translatedFormat('d F Y'));

                // (Opsional) Merge cell biar rapi
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->mergeCells('A2:D2');
                $event->sheet->mergeCells('A3:D3');

                // (Opsional) Tambahkan style tebal
                $event->sheet->getStyle('A1:A3')->getFont()->setBold(true);
            }
        ];
    }
}