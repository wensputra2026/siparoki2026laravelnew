<?php

namespace App\Livewire\Admin\Statistik;

use App\Models\Kapela;
use App\Models\KkKatolik;
use App\Models\Kub;
use App\Models\Umat;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatistikDashboard extends Component
{
    public ?int $filterWilayah = null;
    public ?int $filterKapela = null;
    public ?int $filterKub = null;

    public function render()
    {
        $prefix = request()->segment(1) ?: 'superadmin';

        $umatQuery = Umat::query();
        $kkQuery = KkKatolik::query();

        if ($this->filterWilayah) {
            $umatQuery->whereHas('kk', fn($q) => $q->where('wilayah_id', $this->filterWilayah));
            $kkQuery->where('wilayah_id', $this->filterWilayah);
        }
        if ($this->filterKapela) {
            $umatQuery->whereHas('kk', fn($q) => $q->where('kapela_id', $this->filterKapela));
            $kkQuery->where('kapela_id', $this->filterKapela);
        }
        if ($this->filterKub) {
            $umatQuery->whereHas('kk', fn($q) => $q->where('kub_id', $this->filterKub));
            $kkQuery->where('kub_id', $this->filterKub);
        }

        $totalUmat = (clone $umatQuery)->count();
        $totalKk = (clone $kkQuery)->count();
        $totalWilayah = Wilayah::count();
        $totalKapela = Kapela::count();
        $totalKub = Kub::count();

        // Gender
        $totalLaki = (clone $umatQuery)->whereIn('jenis_kelamin', ['Laki-Laki', 'Laki-laki', 'L'])->count();
        $totalPerempuan = (clone $umatQuery)->whereIn('jenis_kelamin', ['Perempuan', 'P'])->count();

        // Sakramen
        $totalBaptis = (clone $umatQuery)->where(function ($q) {
            $q->whereNotNull('tgl_baptis')->orWhere('status_baptis', 'Sudah');
        })->count();
        $totalKomuni = (clone $umatQuery)->whereNotNull('tgl_komuni_1')->count();
        $totalKrisma = (clone $umatQuery)->whereNotNull('tgl_krisma')->count();
        $totalNikah = (clone $umatQuery)->where(function ($q) {
            $q->whereNotNull('tgl_perkawinan')->orWhereIn('status_menikah', ['Menikah', 'Kawin', 'Menikah Gereja']);
        })->count();

        // Age groups
        $currentYear = date('Y');
        $balita = (clone $umatQuery)->whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 5")->count();
        $anak = (clone $umatQuery)->whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 6 AND 12")->count();
        $remaja = (clone $umatQuery)->whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 17")->count();
        $omk = (clone $umatQuery)->whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 35")->count();
        $dewasa = (clone $umatQuery)->whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 36 AND 59")->count();
        $lansia = (clone $umatQuery)->whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60")->count();

        // Wilayah distribution
        $wilayahStats = Wilayah::withCount(['kks', 'kubs'])->orderBy('nama_wilayah')->get();

        // Options for Tom Select
        $wilayahOptions = Wilayah::orderBy('nama_wilayah')->get(['id', 'nama_wilayah']);
        $kapelaOptions = Kapela::orderBy('nama_kapela')->get(['id', 'nama_kapela']);
        $kubOptions = Kub::orderBy('nama_kub')->get(['id', 'nama_kub']);

        return view('livewire.admin.statistik.statistik-dashboard', [
            'prefix' => $prefix,
            'totalUmat' => $totalUmat,
            'totalKk' => $totalKk,
            'totalWilayah' => $totalWilayah,
            'totalKapela' => $totalKapela,
            'totalKub' => $totalKub,
            'totalLaki' => $totalLaki,
            'totalPerempuan' => $totalPerempuan,
            'totalBaptis' => $totalBaptis,
            'totalKomuni' => $totalKomuni,
            'totalKrisma' => $totalKrisma,
            'totalNikah' => $totalNikah,
            'balita' => $balita,
            'anak' => $anak,
            'remaja' => $remaja,
            'omk' => $omk,
            'dewasa' => $dewasa,
            'lansia' => $lansia,
            'wilayahStats' => $wilayahStats,
            'wilayahOptions' => $wilayahOptions,
            'kapelaOptions' => $kapelaOptions,
            'kubOptions' => $kubOptions,
        ])->layout('layouts.admin', [
            'title' => 'Demografi & Statistik Umat',
        ]);
    }
}
