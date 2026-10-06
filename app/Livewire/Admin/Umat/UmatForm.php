<?php

namespace App\Livewire\Admin\Umat;

use App\Models\Kapela;
use App\Models\KkKatolik;
use App\Models\Kub;
use App\Models\Umat;
use App\Models\Wilayah;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class UmatForm extends Component
{
    public $umatId = null;
    public $isEdit = false;

    // Field Form
    public $nama_lengkap = '';
    public $nama_baptis = '';
    public $nama_lahir = '';
    public $nik = '';
    public $niu = '';
    public $jenis_kelamin = 'L';
    public $tempat_lahir = '';
    public $tanggal_lahir = '';
    public $hubungan_keluarga = 'Kepala Keluarga';
    public $kk_id = '';
    public $status_menikah = 'Belum Menikah';
    public $handphone = '';
    public $email = '';
    public $pekerjaan = '';
    public $pendidikan = '';
    public $golongan_darah = '';

    // Teritorial
    public $wilayah_id = '';
    public $kub_id = '';
    public $kapela_id = '';

    // Sakramen
    public $status_baptis = 'Sudah';
    public $tgl_baptis = '';
    public $paroki_baptis = '';
    public $pastor_baptis = '';
    public $wali_baptis = '';
    public $buku_baptis_no = '';
    public $tgl_komuni_1 = '';
    public $tgl_krisma = '';
    public $tgl_perkawinan = '';

    protected function rules()
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'nik' => 'nullable|string|max:30',
            'kk_id' => 'nullable',
            'wilayah_id' => 'nullable',
            'kub_id' => 'nullable',
            'kapela_id' => 'nullable',
        ];
    }

    protected $messages = [
        'nama_lengkap.required' => 'Nama lengkap umat wajib diisi.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->umatId = $id;
            $this->isEdit = true;
            $umat = Umat::findOrFail($id);

            $this->nama_lengkap = $umat->nama_lengkap;
            $this->nama_baptis = $umat->nama_baptis ?? '';
            $this->nama_lahir = $umat->nama_lahir ?? '';
            $this->nik = $umat->nik ?? '';
            $this->niu = $umat->niu ?? '';
            $this->jenis_kelamin = $umat->jenis_kelamin ?? 'L';
            $this->tempat_lahir = $umat->tempat_lahir ?? '';
            $this->tanggal_lahir = $umat->tanggal_lahir ? $umat->tanggal_lahir->format('Y-m-d') : '';
            $this->hubungan_keluarga = $umat->hubungan_keluarga ?? 'Kepala Keluarga';
            $this->kk_id = $umat->kk_id ?? '';
            $this->status_menikah = $umat->status_menikah ?? 'Belum Menikah';
            $this->handphone = $umat->handphone ?? '';
            $this->email = $umat->email ?? '';
            $this->pekerjaan = $umat->pekerjaan ?? '';
            $this->pendidikan = $umat->pendidikan ?? '';
            $this->golongan_darah = $umat->golongan_darah ?? '';

            $this->wilayah_id = $umat->wilayah_id ?? '';
            $this->kub_id = $umat->kub_id ?? '';
            $this->kapela_id = $umat->kapela_id ?? '';

            $this->status_baptis = $umat->status_baptis ?? 'Sudah';
            $this->tgl_baptis = $umat->tgl_baptis ? $umat->tgl_baptis->format('Y-m-d') : '';
            $this->paroki_baptis = $umat->paroki_baptis ?? '';
            $this->pastor_baptis = $umat->pastor_baptis ?? '';
            $this->wali_baptis = $umat->wali_baptis ?? '';
            $this->buku_baptis_no = $umat->buku_baptis_no ?? '';
            $this->tgl_komuni_1 = $umat->tgl_komuni_1 ? $umat->tgl_komuni_1->format('Y-m-d') : '';
            $this->tgl_krisma = $umat->tgl_krisma ? $umat->tgl_krisma->format('Y-m-d') : '';
            $this->tgl_perkawinan = $umat->tgl_perkawinan ? $umat->tgl_perkawinan->format('Y-m-d') : '';
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_lengkap' => $this->nama_lengkap,
            'nama_baptis' => $this->nama_baptis ?: null,
            'nama_lahir' => $this->nama_lahir ?: null,
            'nik' => $this->nik ?: null,
            'niu' => $this->niu ?: null,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir ?: null,
            'tanggal_lahir' => $this->tanggal_lahir ?: null,
            'hubungan_keluarga' => $this->hubungan_keluarga ?: null,
            'kk_id' => $this->kk_id ?: null,
            'status_menikah' => $this->status_menikah ?: null,
            'handphone' => $this->handphone ?: null,
            'email' => $this->email ?: null,
            'pekerjaan' => $this->pekerjaan ?: null,
            'pendidikan' => $this->pendidikan ?: null,
            'golongan_darah' => $this->golongan_darah ?: null,
            'wilayah_id' => $this->wilayah_id ?: null,
            'kub_id' => $this->kub_id ?: null,
            'kapela_id' => $this->kapela_id ?: null,
            'status_baptis' => $this->status_baptis ?: null,
            'tgl_baptis' => $this->tgl_baptis ?: null,
            'paroki_baptis' => $this->paroki_baptis ?: null,
            'pastor_baptis' => $this->pastor_baptis ?: null,
            'wali_baptis' => $this->wali_baptis ?: null,
            'buku_baptis_no' => $this->buku_baptis_no ?: null,
            'tgl_komuni_1' => $this->tgl_komuni_1 ?: null,
            'tgl_krisma' => $this->tgl_krisma ?: null,
            'tgl_perkawinan' => $this->tgl_perkawinan ?: null,
            'status_aktif' => 1,
            'is_deleted' => 0,
        ];

        if ($this->isEdit) {
            $umat = Umat::findOrFail($this->umatId);
            $umat->update($data);
            $msg = "Data umat {$umat->nama_lengkap} berhasil diperbarui.";
        } else {
            $data['created_by'] = auth()->id();
            $umat = Umat::create($data);
            $msg = "Data umat {$umat->nama_lengkap} berhasil ditambahkan.";
        }

        session()->flash('success', $msg);

        $currentPrefix = explode('/', trim(request()->path(), '/'))[0] ?? 'admin';
        return redirect()->to("/{$currentPrefix}/umat");
    }

    public function render()
    {
        $kks = KkKatolik::where('is_deleted', 0)
            ->orderBy('nama_lahir_pemilik')
            ->take(100)
            ->get();

        $kapelas = Kapela::where('is_deleted', 0)->orderBy('nama_kapela')->get();
        $wilayahs = Wilayah::where('is_deleted', 0)->orderBy('nama_wilayah')->get();
        $kubs = Kub::where('is_deleted', 0)->orderBy('nama_kub')->get();

        return view('livewire.admin.umat.umat-form', [
            'kks' => $kks,
            'kapelas' => $kapelas,
            'wilayahs' => $wilayahs,
            'kubs' => $kubs,
            'isEdit' => $this->isEdit,
            'umatId' => $this->umatId,
        ]);
    }
}
