<?php

namespace App\Livewire\Admin\Settings;

use App\Models\PengaturanMidtrans;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class PengaturanHub extends Component
{
    public string $activeTab = 'pembayaran';

    // Midtrans settings
    public string $midtrans_server_key = '';
    public string $midtrans_client_key = '';
    public string $midtrans_merchant_id = '';
    public string $midtrans_environment = 'sandbox';
    public bool $midtrans_is_active = false;

    // OTP settings
    public string $otp_provider = 'Fonnte';
    public string $otp_api_key = '';
    public string $otp_sender_number = '';
    public string $otp_template = 'Kode verifikasi SIPAROKI Anda adalah: {{otp}}. Berlaku 10 menit.';
    public string $otp_status = 'Aktif';

    // SEO settings
    public string $meta_title = '';
    public string $meta_description = '';
    public string $meta_keywords = '';

    // Maintenance
    public bool $is_maintenance = false;
    public string $maintenance_message = 'Website sedang dalam pemeliharaan berkala.';

    public function mount(?string $tab = null)
    {
        if ($tab) {
            $this->activeTab = $tab;
        }

        // Load midtrans
        $midtrans = PengaturanMidtrans::first();
        if ($midtrans) {
            $this->midtrans_server_key = $midtrans->server_key ?? '';
            $this->midtrans_client_key = $midtrans->client_key ?? '';
            $this->midtrans_merchant_id = $midtrans->merchant_id ?? '';
            $this->midtrans_environment = $midtrans->environment ?? 'sandbox';
            $this->midtrans_is_active = (bool) ($midtrans->is_active ?? false);
        }

        // Load OTP
        if (Schema::hasTable('pengaturan_otp')) {
            $otp = DB::table('pengaturan_otp')->first();
            if ($otp) {
                $this->otp_provider = $otp->provider ?? 'Fonnte';
                $this->otp_api_key = $otp->api_key ?? '';
                $this->otp_sender_number = $otp->sender_number ?? '';
                $this->otp_template = $otp->template_otp ?? $this->otp_template;
                $this->otp_status = $otp->status ?? 'Aktif';
            }
        }

        // Load App / SEO settings
        if (Schema::hasTable('pengaturan_aplikasi')) {
            $app = DB::table('pengaturan_aplikasi')->first();
            if ($app) {
                $this->meta_title = $app->meta_title ?? $app->nama_aplikasi ?? '';
                $this->meta_description = $app->meta_description ?? '';
                $this->meta_keywords = $app->meta_keywords ?? '';
                $this->is_maintenance = (bool) ($app->is_maintenance ?? false);
                $this->maintenance_message = $app->maintenance_message ?? $this->maintenance_message;
            }
        }
    }

    public function saveMidtrans()
    {
        $payload = [
            'server_key' => $this->midtrans_server_key,
            'client_key' => $this->midtrans_client_key,
            'merchant_id' => $this->midtrans_merchant_id,
            'environment' => $this->midtrans_environment,
            'is_active' => $this->midtrans_is_active,
            'updated_at' => now(),
        ];

        $midtrans = PengaturanMidtrans::first();
        if ($midtrans) {
            $midtrans->update($payload);
        } else {
            $payload['created_at'] = now();
            PengaturanMidtrans::create($payload);
        }

        session()->flash('success_midtrans', 'Pengaturan Midtrans Payment Gateway berhasil disimpan.');
    }

    public function saveOtp()
    {
        if (Schema::hasTable('pengaturan_otp')) {
            $payload = [
                'provider' => $this->otp_provider,
                'api_key' => $this->otp_api_key,
                'sender_number' => $this->otp_sender_number,
                'template_otp' => $this->otp_template,
                'status' => $this->otp_status,
                'updated_at' => now(),
            ];

            $exists = DB::table('pengaturan_otp')->exists();
            if ($exists) {
                DB::table('pengaturan_otp')->update($payload);
            } else {
                $payload['created_at'] = now();
                DB::table('pengaturan_otp')->insert($payload);
            }

            session()->flash('success_otp', 'Pengaturan WhatsApp Gateway / OTP berhasil disimpan.');
        }
    }

    public function saveSeo()
    {
        if (Schema::hasTable('pengaturan_aplikasi')) {
            $payload = [
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'meta_keywords' => $this->meta_keywords,
                'is_maintenance' => $this->is_maintenance ? 1 : 0,
                'maintenance_message' => $this->maintenance_message,
                'updated_at' => now(),
            ];

            $exists = DB::table('pengaturan_aplikasi')->exists();
            if ($exists) {
                DB::table('pengaturan_aplikasi')->update($payload);
            } else {
                $payload['created_at'] = now();
                DB::table('pengaturan_aplikasi')->insert($payload);
            }

            session()->flash('success_seo', 'Pengaturan SEO dan Sistem berhasil disimpan.');
        }
    }

    public function render()
    {
        $prefix = request()->segment(1) ?: 'superadmin';

        $pembayaranList = [];
        if (Schema::hasTable('metode_pembayaran')) {
            $pembayaranList = DB::table('metode_pembayaran')->orderBy('urutan')->get();
        }

        return view('livewire.admin.settings.pengaturan-hub', [
            'pembayaranList' => $pembayaranList,
            'prefix' => $prefix,
        ])->layout('layouts.admin', [
            'title' => 'Pengaturan Aplikasi Terpadu',
        ]);
    }
}
