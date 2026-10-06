<?php

namespace App\Livewire\Admin\Kk;

use App\Models\Kapela;
use App\Models\KkKatolik;
use App\Models\Kub;
use App\Models\Paroki;
use App\Models\Wilayah;
use Livewire\Component;

class KkForm extends Component
{
    public ?int $kkId = null;
    public bool $isEdit = false;

    // Form fields
    public string $no_kk_kw = '';
    public ?string $no_kk_dukcapil = null;
    public string $nama_baptis_pemilik = '';
    public ?string $nama_lahir_pemilik = null;
    public ?string $nik_pemilik = null;
    public ?string $nama_pasangan = null;
    public ?int $wilayah_id = null;
    public ?int $kapela_id = null;
    public ?int $kub_id = null;
    public ?string $alamat_sekarang = null;
    public ?string $rt = null;
    public ?string $rw = null;
    public ?string $handphone = null;
    public ?string $email = null;
    public ?string $status_kepemilikan_rumah = 'Milik Sendiri';
    public ?string $kategori_ekonomi = 'Mampu';
    public string $status_kk = 'Aktif';

    // Options
    public array $wilayahList = [];
    public array $kapelaList = [];
    public array $kubList = [];

    public function mount(?int $id = null)
    {
        $this->wilayahList = Wilayah::orderBy('nama_wilayah')->get(['id', 'nama_wilayah'])->toArray();
        $this->kapelaList = Kapela::orderBy('nama_kapela')->get(['id', 'nama_kapela'])->toArray();
        $this->kubList = Kub::orderBy('nama_kub')->get(['id', 'nama_kub', 'wilayah_id'])->toArray();

        if ($id) {
            $this->kkId = $id;
            $this->isEdit = true;
            $kk = KkKatolik::findOrFail($id);

            $this->no_kk_kw = $kk->no_kk_kw;
            $this->no_kk_dukcapil = $kk->no_kk_dukcapil;
            $this->nama_baptis_pemilik = $kk->nama_baptis_pemilik;
            $this->nama_lahir_pemilik = $kk->nama_lahir_pemilik;
            $this->nik_pemilik = $kk->nik_pemilik;
            $this->nama_pasangan = $kk->nama_pasangan;
            $this->wilayah_id = $kk->wilayah_id;
            $this->kapela_id = $kk->kapela_id;
            $this->kub_id = $kk->kub_id;
            $this->alamat_sekarang = $kk->alamat_sekarang;
            $this->rt = $kk->rt;
            $this->rw = $kk->rw;
            $this->handphone = $kk->handphone;
            $this->email = $kk->email;
            $this->status_kepemilikan_rumah = $kk->status_kepemilikan_rumah ?? 'Milik Sendiri';
            $this->kategori_ekonomi = $kk->kategori_ekonomi ?? 'Mampu';
            $this->status_kk = $kk->status_kk ?? 'Aktif';
        } else {
            // Auto generate No KK
            $nextSeq = str_pad((KkKatolik::count() + 1), 3, '0', STR_PAD_LEFT);
            $this->no_kk_kw = 'K012001' . $nextSeq;
        }
    }

    public function rules(): array
    {
        return [
            'no_kk_kw' => 'required|string|max:50',
            'nama_baptis_pemilik' => 'required|string|max:255',
            'wilayah_id' => 'nullable|integer',
            'kapela_id' => 'nullable|integer',
            'kub_id' => 'nullable|integer',
            'status_kk' => 'required|string',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'no_kk_kw' => $this->no_kk_kw,
            'no_kk_dukcapil' => $this->no_kk_dukcapil,
            'nama_baptis_pemilik' => $this->nama_baptis_pemilik,
            'nama_lahir_pemilik' => $this->nama_lahir_pemilik ?: $this->nama_baptis_pemilik,
            'nik_pemilik' => $this->nik_pemilik,
            'nama_pasangan' => $this->nama_pasangan,
            'wilayah_id' => $this->wilayah_id,
            'kapela_id' => $this->kapela_id,
            'kub_id' => $this->kub_id,
            'alamat_sekarang' => $this->alamat_sekarang,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'handphone' => $this->handphone,
            'email' => $this->email,
            'status_kepemilikan_rumah' => $this->status_kepemilikan_rumah,
            'kategori_ekonomi' => $this->kategori_ekonomi,
            'status_kk' => $this->status_kk,
        ];

        $prefix = request()->segment(1) ?: 'superadmin';

        if ($this->isEdit && $this->kkId) {
            $kk = KkKatolik::findOrFail($this->kkId);
            $kk->update($data);
            session()->flash('success', "Data KK {$this->no_kk_kw} berhasil diperbarui.");
        } else {
            $data['uuid'] = (string) \Illuminate\Support\Str::uuid();
            KkKatolik::create($data);
            session()->flash('success', "Kartu Keluarga {$this->no_kk_kw} berhasil didaftarkan.");
        }

        return redirect("/{$prefix}/kk-katolik");
    }

    public function render()
    {
        $prefix = request()->segment(1) ?: 'superadmin';

        return view('livewire.admin.kk.kk-form', [
            'prefix' => $prefix,
        ])->layout('layouts.admin', [
            'title' => $this->isEdit ? 'Edit Kartu Keluarga' : 'Tambah Kartu Keluarga Baru',
        ]);
    }
}
