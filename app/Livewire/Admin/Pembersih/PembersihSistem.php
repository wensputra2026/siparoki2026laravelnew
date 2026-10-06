<?php

namespace App\Livewire\Admin\Pembersih;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PembersihSistem extends Component
{
    public function clearApplicationCache()
    {
        try {
            Cache::flush();
            Artisan::call('cache:clear');
            session()->flash('success', 'Cache aplikasi dan memori sementara berhasil dibersihkan.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    public function clearViewCache()
    {
        try {
            Artisan::call('view:clear');
            session()->flash('success', 'Kompilasi template Blade berhasil disegarkan.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal membersihkan template: ' . $e->getMessage());
        }
    }

    public function clearRouteConfigCache()
    {
        try {
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            session()->flash('success', 'Routing dan konfigurasi berhasil disegarkan.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal menyegarkan konfigurasi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $prefix = request()->segment(1) ?: 'superadmin';

        return view('livewire.admin.pembersih.pembersih-sistem', [
            'prefix' => $prefix,
        ])->layout('layouts.admin', [
            'title' => 'Pembersih Sistem & Optimasi',
        ]);
    }
}
