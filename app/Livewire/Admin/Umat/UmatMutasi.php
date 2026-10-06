<?php

namespace App\Livewire\Admin\Umat;

use App\Models\KkKatolik;
use App\Models\Kub;
use App\Models\Paroki;
use App\Models\Umat;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Mutasi & Perubahan Status Umat')]
class UmatMutasi extends Component
{
    public $umatId;
    public $mode = 'mutasi'; // 'mutasi' or 'pisah'
    public $currentPrefix = 'superadmin';

    // Form fields
    public $kk_tujuan_id = '';
    public $alasan = '';
    public $no_surat_pindah = '';
    public $tgl_mutasi = '';

    // Data displays
    public $nama_lengkap = '';
    public $nama_baptis = '';
    public $nik = '';
    public $kk_asal_nomor = '';
    public $kk_asal_kepala = '';
    public $kub_asal_nama = '';
    public $wilayah_asal_nama = '';

    public function mount($id)
    {
        $this->currentPrefix = request()->segment(1) ?: 'superadmin';
        $this->umatId = $id;
        $this->tgl_mutasi = date('Y-m-d');

        $umat = Umat::with('kk.kub', 'kk.wilayah', 'kk.kapela')
            ->where('id', $id)
            ->orWhere('uuid', $id)
            ->firstOrFail();

        $this->umatId = $umat->id;
        $this->nama_lengkap = $umat->nama_lengkap;
        $this->nama_baptis = $umat->nama_baptis;
        $this->nik = $umat->nik;

        $this->kk_asal_nomor = $umat->kk?->no_kk_kw ?? '-';
        $this->kk_asal_kepala = $umat->kk?->nama_lahir_pemilik ?? '-';
        $this->kub_asal_nama = $umat->kk?->kub?->nama_kub ?? '-';
        $this->wilayah_asal_nama = $umat->kk?->wilayah?->nama_wilayah ?? '-';

        // Check if mode is pisah from URL
        if (request()->is('*pisah*')) {
            $this->mode = 'pisah';
        }
    }

    public function simpanMutasi()
    {
        $this->validate([
            'kk_tujuan_id' => 'required|integer|exists:kk_katolik,id',
            'alasan' => 'required|string|min:3',
            'no_surat_pindah' => 'nullable|string|max:100',
            'tgl_mutasi' => 'required|date',
        ], [
            'kk_tujuan_id.required' => 'Pilih Kartu Keluarga (KK) tujuan mutasi.',
            'alasan.required' => 'Alasan mutasi wajib diisi.',
            'tgl_mutasi.required' => 'Tanggal mutasi wajib diisi.',
        ]);

        $umat = Umat::with('kk.kub', 'kk.wilayah', 'kk.kapela')->findOrFail($this->umatId);
        $kkLama = $umat->kk;
        $kubAsal = $kkLama?->kub;
        $kkBaru = KkKatolik::with('kub', 'wilayah', 'kapela')->findOrFail($this->kk_tujuan_id);
        $kubTujuan = $kkBaru->kub;

        if ($kkLama && (int) $kkLama->id === (int) $kkBaru->id) {
            $this->addError('kk_tujuan_id', 'KK tujuan tidak boleh sama dengan KK asal.');
            return;
        }

        DB::transaction(function () use ($umat, $kkLama, $kkBaru, $kubAsal, $kubTujuan) {
            $umat->kk_sebelumnya_id = $kkLama?->id;
            $umat->kk_id = $kkBaru->id;
            $umat->tanggal_keluar_dari_kk = $this->tgl_mutasi;
            $umat->tanggal_menjadi_anggota_kk = $this->tgl_mutasi;
            $umat->updated_by = Auth::id();
            $umat->save();

            DB::table('riwayat_mutasi_umat')->insert([
                'umat_id' => $umat->id,
                'jenis_mutasi' => $this->mode === 'pisah' ? 'Pisah KK' : 'Mutasi KUB',
                'kk_id' => $kkBaru->id,
                'kub_asal_id' => $kubAsal?->id,
                'kub_tujuan_id' => $kubTujuan?->id,
                'wilayah_asal_id' => $kkLama?->wilayah_id,
                'wilayah_tujuan_id' => $kkBaru->wilayah_id,
                'paroki_asal_id' => $kubAsal?->paroki_id,
                'paroki_tujuan_id' => $kubTujuan?->paroki_id,
                'alasan' => $this->alasan,
                'no_surat_pindah' => $this->no_surat_pindah ?: null,
                'tgl_surat_pindah' => $this->tgl_mutasi ?: null,
                'tgl_mutasi' => $this->tgl_mutasi ?: now(),
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        session()->flash('success', "Proses mutasi umat {$this->nama_lengkap} ke KK {$kkBaru->nama_lahir_pemilik} berhasil dicatat.");
        return $this->redirect("/{$this->currentPrefix}/umat", navigate: true);
    }

    public function render()
    {
        $kkOptions = KkKatolik::with('kub')
            ->select('id', 'no_kk_kw', 'nama_lahir_pemilik', 'nama_baptis_pemilik', 'kub_id')
            ->orderBy('nama_lahir_pemilik')
            ->take(100)
            ->get();

        return view('livewire.admin.umat.umat-mutasi', [
            'kkOptions' => $kkOptions,
        ]);
    }
}
