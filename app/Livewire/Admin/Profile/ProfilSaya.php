<?php

namespace App\Livewire\Admin\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilSaya extends Component
{
    use WithFileUploads;

    // Profile Details
    public string $nama_lengkap = '';
    public string $username = '';
    public string $email = '';
    public ?string $no_hp = null;
    public $foto = null;
    public ?string $currentFoto = null;

    // Password Update
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount()
    {
        $user = auth()->user() ?? User::first();
        if ($user) {
            $this->nama_lengkap = $user->nama_lengkap ?? $user->name ?? '';
            $this->username = $user->username ?? '';
            $this->email = $user->email ?? '';
            $this->no_hp = $user->no_hp ?? '';
            $this->currentFoto = $user->foto ?? null;
        }
    }

    public function updateProfile()
    {
        $user = auth()->user() ?? User::first();
        if (!$user) return;

        $userId = $user->getKey();
        $this->validate([
            'nama_lengkap' => 'required|string|max:150',
            'username' => 'required|string|max:100|unique:users,username,' . $userId,
            'email' => 'required|email|max:150|unique:users,email,' . $userId,
            'no_hp' => 'nullable|string|max:30',
            'foto' => 'nullable|image|max:2048',
        ]);

        $payload = [
            'nama_lengkap' => $this->nama_lengkap,
            'username' => $this->username,
            'email' => $this->email,
            'no_hp' => $this->no_hp,
        ];

        $cols = Schema::getColumnListing('users');
        if (in_array('name', $cols, true)) {
            $payload['name'] = $this->nama_lengkap;
        }

        if ($this->foto) {
            $path = $this->foto->store('uploads/users', 'public');
            $payload['foto'] = $path;
            $this->currentFoto = $path;
            $this->foto = null;
        }

        $user->update($payload);
        session()->flash('success_profile', 'Profil berhasil diperbarui.');
    }

    public function updatePassword()
    {
        $user = auth()->user() ?? User::first();
        if (!$user) return;

        $this->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Kata sandi saat ini tidak cocok.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        session()->flash('success_password', 'Kata sandi berhasil diperbarui.');
    }

    public function render()
    {
        $user = auth()->user() ?? User::first();
        $prefix = request()->segment(1) ?: 'superadmin';

        return view('livewire.admin.profile.profil-saya', [
            'user' => $user,
            'prefix' => $prefix,
        ])->layout('layouts.admin', [
            'title' => 'Profil Saya',
        ]);
    }
}
