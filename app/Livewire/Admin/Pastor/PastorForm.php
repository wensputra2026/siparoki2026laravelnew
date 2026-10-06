<?php

namespace App\Livewire\Admin\Pastor;

use App\Models\MasterPastor;
use Livewire\Component;
use Livewire\WithFileUploads;

class PastorForm extends Component
{
    use WithFileUploads;

    public ?int $pastorId = null;
    public bool $isEdit = false;

    public string $nama_pastor = '';
    public ?string $gelar_depan = 'RD.';
    public ?string $gelar_belakang = 'Pr';
    public ?string $jabatan = 'Pastor Paroki';
    public ?string $jenis_imam = 'Diosesan / Projo';
    public ?string $ordo = null;
    public ?string $keuskupan = 'Keuskupan Agung Kupang';
    public ?string $no_hp = null;
    public ?string $email = null;
    public ?string $tanggal_tahbisan = null;
    public ?string $motto_tahbisan = null;
    public ?string $tempat_tahbisan = null;
    public ?string $keterangan = null;
    public string $status = 'Aktif';
    public $foto = null;
    public ?string $currentFoto = null;

    public function mount(?int $id = null)
    {
        if ($id) {
            $this->pastorId = $id;
            $this->isEdit = true;
            $p = MasterPastor::findOrFail($id);

            $this->nama_pastor = $p->nama_pastor;
            $this->gelar_depan = $p->gelar_depan ?? 'RD.';
            $this->gelar_belakang = $p->gelar_belakang ?? 'Pr';
            $this->jabatan = $p->jabatan ?? 'Pastor Paroki';
            $this->jenis_imam = $p->jenis_imam ?? 'Diosesan / Projo';
            $this->ordo = $p->ordo ?? $p->ordo_kongregasi ?? '';
            $this->keuskupan = $p->keuskupan ?? 'Keuskupan Agung Kupang';
            $this->no_hp = $p->no_hp ?? '';
            $this->email = $p->email ?? '';
            $this->tanggal_tahbisan = $p->tanggal_tahbisan ?? $p->tgl_tahbisan ?? null;
            $this->motto_tahbisan = $p->motto_tahbisan ?? '';
            $this->tempat_tahbisan = $p->tempat_tahbisan ?? '';
            $this->keterangan = $p->keterangan ?? '';
            $this->status = $p->status ?? 'Aktif';
            $this->currentFoto = $p->foto ?? null;
        }
    }

    public function save()
    {
        $this->validate([
            'nama_pastor' => 'required|string|max:150',
            'jabatan' => 'required|string|max:100',
            'foto' => 'nullable|image|max:2048',
        ]);

        $payload = [
            'nama_pastor' => $this->nama_pastor,
            'gelar_depan' => $this->gelar_depan,
            'gelar_belakang' => $this->gelar_belakang,
            'jabatan' => $this->jabatan,
            'jenis_imam' => $this->jenis_imam,
            'ordo' => $this->ordo,
            'ordo_kongregasi' => $this->ordo,
            'keuskupan' => $this->keuskupan,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'tanggal_tahbisan' => $this->tanggal_tahbisan,
            'motto_tahbisan' => $this->motto_tahbisan,
            'tempat_tahbisan' => $this->tempat_tahbisan,
            'keterangan' => $this->keterangan,
            'status' => $this->status,
        ];

        if ($this->foto) {
            $path = $this->foto->store('uploads/pastor', 'public');
            $payload['foto'] = $path;
            $this->currentFoto = $path;
            $this->foto = null;
        }

        $prefix = request()->segment(1) ?: 'superadmin';

        if ($this->isEdit && $this->pastorId) {
            $p = MasterPastor::findOrFail($this->pastorId);
            $p->update($payload);
            session()->flash('success', "Data Pastor {$this->nama_pastor} berhasil diperbarui.");
        } else {
            $payload['uuid'] = (string) \Illuminate\Support\Str::uuid();
            MasterPastor::create($payload);
            session()->flash('success', "Pastor {$this->nama_pastor} berhasil ditambahkan.");
        }

        return redirect("/{$prefix}/master-pastor");
    }

    public function render()
    {
        $prefix = request()->segment(1) ?: 'superadmin';

        return view('livewire.admin.pastor.pastor-form', [
            'prefix' => $prefix,
        ])->layout('layouts.admin', [
            'title' => $this->isEdit ? 'Edit Data Pastor' : 'Tambah Pastor Baru',
        ]);
    }
}
