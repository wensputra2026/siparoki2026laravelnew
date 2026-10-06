<?php

namespace App\Livewire\Admin\Panduan;

use Livewire\Component;

class PanduanHakAkses extends Component
{
    public function render()
    {
        $prefix = request()->segment(1) ?: 'superadmin';

        return view('livewire.admin.panduan.panduan-hak-akses', [
            'prefix' => $prefix,
        ])->layout('layouts.admin', [
            'title' => 'Panduan Hak Akses & Kewenangan (RBAC)',
        ]);
    }
}
