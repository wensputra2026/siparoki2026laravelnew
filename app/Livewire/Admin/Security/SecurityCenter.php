<?php

namespace App\Livewire\Admin\Security;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class SecurityCenter extends Component
{
    public int $max_login_attempts = 5;
    public int $lockout_minutes = 60;
    public int $session_timeout_minutes = 120;
    public bool $force_strong_password = true;
    public bool $enable_brute_force_protection = true;

    // Block IP form
    public string $newIp = '';
    public string $reason = '';

    public function mount()
    {
        if (Schema::hasTable('security_settings')) {
            $settings = DB::table('security_settings')->pluck('setting_value', 'setting_key')->toArray();
            $this->max_login_attempts = (int) ($settings['max_login_attempts'] ?? 5);
            $this->lockout_minutes = (int) ($settings['lockout_minutes'] ?? 60);
            $this->session_timeout_minutes = (int) ($settings['session_timeout_minutes'] ?? 120);
            $this->force_strong_password = ($settings['force_strong_password'] ?? '1') === '1';
            $this->enable_brute_force_protection = ($settings['enable_brute_force_protection'] ?? '1') === '1';
        }
    }

    public function saveSettings()
    {
        if (Schema::hasTable('security_settings')) {
            $data = [
                'max_login_attempts' => (string) $this->max_login_attempts,
                'lockout_minutes' => (string) $this->lockout_minutes,
                'session_timeout_minutes' => (string) $this->session_timeout_minutes,
                'force_strong_password' => $this->force_strong_password ? '1' : '0',
                'enable_brute_force_protection' => $this->enable_brute_force_protection ? '1' : '0',
            ];

            foreach ($data as $key => $val) {
                DB::table('security_settings')->updateOrInsert(
                    ['setting_key' => $key],
                    ['setting_value' => $val, 'updated_at' => now()]
                );
            }

            session()->flash('success', 'Pengaturan keamanan dan proteksi sistem berhasil diperbarui.');
        }
    }

    public function blockIp()
    {
        $this->validate([
            'newIp' => 'required|ip',
        ]);

        if (Schema::hasTable('blocked_ips')) {
            DB::table('blocked_ips')->insert([
                'ip_address' => $this->newIp,
                'reason' => $this->reason ?: 'Pemblokiran manual oleh admin',
                'blocked_by' => auth()->user()?->nama_lengkap ?? 'Administrator',
                'created_at' => now(),
            ]);

            $this->newIp = '';
            $this->reason = '';
            session()->flash('success', 'Alamat IP berhasil diblokir.');
        }
    }

    public function unblockIp($id)
    {
        if (Schema::hasTable('blocked_ips')) {
            DB::table('blocked_ips')->where('id', $id)->delete();
            session()->flash('success', 'Alamat IP berhasil dipulihkan.');
        }
    }

    public function render()
    {
        $prefix = request()->segment(1) ?: 'superadmin';

        $blockedIps = [];
        if (Schema::hasTable('blocked_ips')) {
            $blockedIps = DB::table('blocked_ips')->orderBy('id', 'desc')->get();
        }

        $auditLogs = [];
        if (Schema::hasTable('audit_logs')) {
            $auditLogs = DB::table('audit_logs')->orderBy('id', 'desc')->limit(20)->get();
        }

        return view('livewire.admin.security.security-center', [
            'blockedIps' => $blockedIps,
            'auditLogs' => $auditLogs,
            'prefix' => $prefix,
        ])->layout('layouts.admin', [
            'title' => 'Security Center & Firewall',
        ]);
    }
}
