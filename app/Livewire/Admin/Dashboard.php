<?php

namespace App\Livewire\Admin;

use App\Models\Kapela;
use App\Models\KkKatolik;
use App\Models\Kub;
use App\Models\Pastor;
use App\Models\Umat;
use App\Models\Wilayah;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Dashboard Overview')]
class Dashboard extends Component
{
    public function render()
    {
        $totalUmat = Umat::where('is_deleted', 0)->count();
        $totalKk = KkKatolik::where('is_deleted', 0)->count();
        $totalKapela = Kapela::where('is_deleted', 0)->count();
        $totalKub = Kub::where('is_deleted', 0)->count();
        $totalWilayah = Wilayah::where('is_deleted', 0)->count();
        $totalPastor = Pastor::where('is_deleted', 0)->count();

        // Demografi Gender
        $genderL = Umat::where('is_deleted', 0)->where('jenis_kelamin', 'L')->count();
        $genderP = Umat::where('is_deleted', 0)->where('jenis_kelamin', 'P')->count();
        $genderLPercent = $totalUmat > 0 ? round(($genderL / $totalUmat) * 100) : 0;
        $genderPPercent = $totalUmat > 0 ? round(($genderP / $totalUmat) * 100) : 0;

        // Status Sakramen
        $totalBaptis = Umat::where('is_deleted', 0)
            ->where(function ($q) {
                $q->whereNotNull('tgl_baptis')
                  ->orWhere('status_baptis', 'Sudah')
                  ->orWhere('status_baptis', 'Ya');
            })->count();

        $totalKomuni = Umat::where('is_deleted', 0)->whereNotNull('tgl_komuni_1')->count();
        $totalKrisma = Umat::where('is_deleted', 0)->whereNotNull('tgl_krisma')->count();

        // 5 Umat Terbaru
        $recentUmats = Umat::where('is_deleted', 0)
            ->with(['kub', 'wilayah', 'kapela'])
            ->latest('id')
            ->take(6)
            ->get();

        // Distribusi KUB per Wilayah
        $wilayahStats = Wilayah::where('is_deleted', 0)
            ->withCount('kubs')
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'totalUmat' => $totalUmat,
            'totalKk' => $totalKk,
            'totalKapela' => $totalKapela,
            'totalKub' => $totalKub,
            'totalWilayah' => $totalWilayah,
            'totalPastor' => $totalPastor,
            'genderL' => $genderL,
            'genderP' => $genderP,
            'genderLPercent' => $genderLPercent,
            'genderPPercent' => $genderPPercent,
            'totalBaptis' => $totalBaptis,
            'totalKomuni' => $totalKomuni,
            'totalKrisma' => $totalKrisma,
            'recentUmats' => $recentUmats,
            'wilayahStats' => $wilayahStats,
        ]);
    }
}
