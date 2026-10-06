<?php

namespace App\Livewire\Admin\Kk;

use App\Models\KkKatolik;
use App\Models\Paroki;
use Livewire\Component;

class KkDetail extends Component
{
    public int $kkId;
    public ?KkKatolik $kk = null;
    public ?Paroki $paroki = null;

    public function mount(int $id)
    {
        $this->kkId = $id;
        $this->kk = KkKatolik::with([
            'wilayah',
            'kapela',
            'kub',
            'anggota' => function ($q) {
                $q->orderByRaw("FIELD(hubungan_keluarga, 'Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Orang Tua', 'Mertua', 'Famili Lain') ASC")
                  ->orderBy('tanggal_lahir', 'asc');
            }
        ])->findOrFail($id);

        $this->paroki = Paroki::with(['keuskupan'])->first();
    }

    public function render()
    {
        $prefix = request()->segment(1) ?: 'superadmin';

        return view('livewire.admin.kk.kk-detail', [
            'prefix' => $prefix,
        ])->layout('layouts.admin', [
            'title' => 'Kartu Keluarga: ' . ($this->kk?->no_kk_kw ?? ''),
        ]);
    }
}
