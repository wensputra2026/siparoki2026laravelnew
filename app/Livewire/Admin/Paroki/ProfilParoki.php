<?php

namespace App\Livewire\Admin\Paroki;

use App\Http\Controllers\Concerns\ParokiModuleTrait;
use App\Models\Dekenat;
use App\Models\DesaKelurahan;
use App\Models\Kabupaten;
use App\Models\Kapela;
use App\Models\Kecamatan;
use App\Models\Keluarga;
use App\Models\Keuskupan;
use App\Models\KkKatolik;
use App\Models\Kub;
use App\Models\Lingkungan;
use App\Models\MasterPastor;
use App\Models\Paroki;
use App\Models\ProfilParoki as ProfilParokiModel;
use App\Models\Provinsi;
use App\Models\Umat;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilParoki extends Component
{
    use WithFileUploads, ParokiModuleTrait;

    // Current paroki ID that is actively selected / default
    public ?int $currentParokiId = null;

    // Selected paroki ID in dropdown on the right panel
    public ?int $selectedParokiId = null;

    // Search query for paroki dropdown popover
    public string $parokiSearchQuery = '';
    public bool $isDropdownOpen = false;

    // List of all paroki for dropdown
    public array $allParoki = [];

    // Stat counts matching katedral top stat cards
    public int $totalWilayah = 0;
    public int $totalLingkungan = 0;
    public int $totalKapela = 0;
    public int $totalKub = 0;
    public int $totalUmat = 0;
    public int $totalKk = 0;

    // Pastors bertugas for this active paroki
    public array $pastorsBertugas = [];

    // Modals state (Matching katedral: Edit Data Profil, Upload Banner, Gambar & Sejarah)
    public bool $showEditModal = false;
    public bool $showBannerModal = false;
    public bool $showImageModal = false;

    // Backward compatibility aliases
    public bool $showEditProfilModal = false;
    public bool $showEditParokiModal = false;

    // ── Form for Modal Edit Data Profil (Full Master Paroki) ─────────
    public array $form = [
        'nama_paroki' => '',
        'kode_paroki' => '',
        'pelindung_paroki' => '',
        'status' => 'Aktif',
        'status_paroki' => 'Mandiri / Definitif',
        'tanggal_berdiri' => '',
        'keuskupan_id' => '',
        'dekenat_id' => '',
        'nama_pastor_paroki_aktif' => '',
        'nama_pastor_rekan' => '',
        'pastor_rekan_array' => [],
        'provinsi_id' => '',
        'kabupaten_id' => '',
        'kecamatan_id' => '',
        'desa_id' => '',
        'alamat' => '',
        'telepon' => '',
        'whatsapp' => '',
        'email' => '',
        'website' => '',
        'maps_url' => '',
        'maps_embed' => '',
        'latitude' => '',
        'longitude' => '',
        'keterangan' => '',
    ];

    public string $pastorRekanInput = '';

    // ── Fields for Modal Banner Header ───────────────────────────────
    public $bannerUpload = null;
    public ?string $bannerPreview = null;

    // ── Fields for Modal Gambar & Sejarah ────────────────────────────
    public $logoUpload = null;
    public ?string $logoPreview = null;
    public string $keteranganSejarah = '';

    // Legacy fields for compatibility
    public $currentBanner = null;
    public $currentLogo = null;
    public string $sejarah = '';
    public string $visi = '';
    public string $misi = '';
    public string $frater = '';
    public string $jadwal_misa = '';
    public string $facebook = '';
    public string $instagram = '';
    public string $youtube = '';
    public string $pastor_paroki = '';
    public string $pastor_rekan = '';

    // Reference dropdown options
    public array $keuskupanList = [];
    public array $dekenatList = [];
    public array $provinsiList = [];
    public array $kabupatenList = [];
    public array $kecamatanList = [];
    public array $desaList = [];
    public array $statusOptions = [
        'Mandiri / Definitif', 'Paroki', 'Stasi', 'Kuasi Paroki', 'Filial', 'Rektorat',
    ];

    public function mount(): void
    {
        $this->loadAllParoki();
        $this->loadMasterReferences();
        $this->resolveCurrentParokiId();
        $this->selectedParokiId = $this->currentParokiId;
        $this->calculateStats();
        $this->loadPastorsBertugas();
    }

    public function loadAllParoki(): void
    {
        $this->allParoki = Paroki::with(['keuskupan', 'dekenat'])
            ->orderBy('nama_paroki')
            ->get(['id_paroki', 'nama_paroki', 'kode_paroki', 'keuskupan_id', 'dekenat_id', 'status_paroki', 'status'])
            ->map(function ($p) {
                return [
                    'id_paroki' => $p->id_paroki,
                    'nama_paroki' => $p->nama_paroki,
                    'kode_paroki' => $p->kode_paroki ?? '',
                    'nama_keuskupan' => $p->keuskupan?->nama_keuskupan ?? 'Keuskupan Agung Kupang',
                    'nama_dekenat' => $p->dekenat?->nama_dekenat ?? '',
                ];
            })
            ->toArray();
    }

    public function loadMasterReferences(): void
    {
        $this->keuskupanList = Keuskupan::orderBy('nama_keuskupan')
            ->get(['id_keuskupan as id', 'nama_keuskupan as name'])
            ->toArray();

        $this->provinsiList = Provinsi::orderBy('nama_provinsi')
            ->get(['id_provinsi as id', 'nama_provinsi as name'])
            ->toArray();
    }

    public function calculateStats(): void
    {
        $this->totalWilayah = Schema::hasTable('wilayah') ? Wilayah::count() : 0;
        $this->totalLingkungan = Schema::hasTable('lingkungan') ? Lingkungan::count() : 0;
        $this->totalKapela = Schema::hasTable('kapela') ? Kapela::count() : 0;
        $this->totalKub = Schema::hasTable('kub') ? Kub::count() : 0;
        $this->totalUmat = Schema::hasTable('umat') ? Umat::count() : 0;

        if (Schema::hasTable('keluarga')) {
            $this->totalKk = Keluarga::count();
        } elseif (Schema::hasTable('kk_katolik')) {
            $this->totalKk = KkKatolik::count();
        } else {
            $this->totalKk = 0;
        }
    }

    public function loadPastorsBertugas(): void
    {
        $paroki = $this->getCurrentParokiProperty();
        if (!$paroki || !Schema::hasTable('master_pastor')) {
            $this->pastorsBertugas = [];
            return;
        }

        $curParokiId = (int)$paroki->id_paroki;
        $curParokiName = strtolower(trim($paroki->nama_paroki ?? ''));
        $pastorParokiName = strtolower(trim($paroki->nama_pastor_paroki_aktif ?? ''));
        $pastorRekanName = strtolower(trim($paroki->nama_pastor_rekan ?? ''));

        $this->pastorsBertugas = MasterPastor::orderBy('urutan')
            ->orderBy('nama_pastor')
            ->get()
            ->filter(function ($p) use ($curParokiId, $curParokiName, $pastorParokiName, $pastorRekanName) {
                // 1. Direct paroki_id match
                if (!empty($p->paroki_id) && (int)$p->paroki_id === $curParokiId) {
                    return true;
                }

                // 2. String match in paroki_tugas
                $pTugas = strtolower(trim($p->paroki_tugas ?? ''));
                if (!empty($curParokiName) && !empty($pTugas)) {
                    if (str_contains($pTugas, $curParokiName) || str_contains($curParokiName, $pTugas)) {
                        return true;
                    }
                }

                // 3. Name match with pastor paroki or rekan
                $pNama = strtolower(trim($p->nama_pastor ?? ''));
                $pFormatted = strtolower(trim(MasterPastor::formatNama($p)));
                if (!empty($pNama)) {
                    if (!empty($pastorParokiName) && (str_contains($pastorParokiName, $pNama) || str_contains($pNama, $pastorParokiName))) {
                        return true;
                    }
                    if (!empty($pastorRekanName) && (str_contains($pastorRekanName, $pNama) || str_contains($pNama, $pastorRekanName))) {
                        return true;
                    }
                }
                if (!empty($pFormatted)) {
                    if (!empty($pastorParokiName) && (str_contains($pastorParokiName, $pFormatted) || str_contains($pFormatted, $pastorParokiName))) {
                        return true;
                    }
                    if (!empty($pastorRekanName) && (str_contains($pastorRekanName, $pFormatted) || str_contains($pFormatted, $pastorRekanName))) {
                        return true;
                    }
                }

                return false;
            })
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'nama_pastor' => $p->nama_pastor,
                    'nama_formatted' => MasterPastor::formatNama($p),
                    'jabatan' => $p->jabatan ?: 'Pastor Rekan',
                    'status' => $p->status,
                    'foto' => $p->foto,
                    'paroki_tugas' => $p->paroki_tugas ?: 'Paroki Santo Vinsensius a Paulo Benlutu',
                    'ordo' => $p->ordo ?: $p->ordo_kongregasi ?: '',
                ];
            })
            ->values()
            ->toArray();
    }

    protected function resolveCurrentParokiId(): void
    {
        // 1. From pengaturan_aplikasi
        if (Schema::hasTable('pengaturan_aplikasi')) {
            $setting = DB::table('pengaturan_aplikasi')->first();
            if (!empty($setting?->paroki_id) && Paroki::find($setting->paroki_id)) {
                $this->currentParokiId = (int)$setting->paroki_id;
                return;
            }
        }

        // 2. From session
        if (session()->has('paroki_id') || session()->has('default_paroki_id')) {
            $sessId = session('paroki_id') ?? session('default_paroki_id');
            if ($sessId && Paroki::find($sessId)) {
                $this->currentParokiId = (int)$sessId;
                return;
            }
        }

        // 3. From profil_paroki
        if (Schema::hasTable('profil_paroki')) {
            $profil = DB::table('profil_paroki')->first();
            if (!empty($profil?->paroki_id) && Paroki::find($profil->paroki_id)) {
                $this->currentParokiId = (int)$profil->paroki_id;
                return;
            }
        }

        // 4. Fallback to Benlutu (380) or first paroki
        $benlutu = Paroki::where('nama_paroki', 'like', '%Benlutu%')->first();
        if ($benlutu) {
            $this->currentParokiId = $benlutu->id_paroki;
            return;
        }

        $first = Paroki::first();
        $this->currentParokiId = $first?->id_paroki;
    }

    public function selectParokiItem(int $id): void
    {
        $this->selectedParokiId = $id;
        $this->isDropdownOpen = false;
        $this->parokiSearchQuery = '';
    }

    /**
     * Set Default Paroki & Sinkronkan Data (Matches katedral setDefaultParoki)
     */
    public function setDefault(): void
    {
        if (empty($this->selectedParokiId)) {
            session()->flash('error', 'Silakan pilih paroki terlebih dahulu.');
            return;
        }

        $paroki = Paroki::with(['keuskupan', 'dekenat', 'provinsi', 'kabupaten', 'kecamatan', 'desa'])
            ->find($this->selectedParokiId);

        if (!$paroki) {
            session()->flash('error', 'Data paroki tidak ditemukan.');
            return;
        }

        $this->currentParokiId = $paroki->id_paroki;
        session()->put('paroki_id', $paroki->id_paroki);
        session()->put('default_paroki_id', $paroki->id_paroki);

        // Sync globally using trait
        $this->syncParokiToGlobalSettings($paroki);
        $this->clearAllCache();
        $this->calculateStats();
        $this->loadPastorsBertugas();

        session()->flash('success', "Paroki default berhasil diubah ke {$paroki->nama_paroki}. Seluruh tampilan Frontend dan Backend otomatis tersinkronisasi.");
    }

    public function applyAndSync(): void
    {
        $this->setDefault();
    }

    // ── MODAL 1: EDIT DATA PROFIL (Full Master Paroki Form) ──────────
    public function openEditModal(): void
    {
        $paroki = $this->getCurrentParokiProperty();
        if (!$paroki) return;

        $pastorRekanArr = !empty($paroki->nama_pastor_rekan)
            ? array_map('trim', explode(',', $paroki->nama_pastor_rekan))
            : [];
        $pastorRekanArr = array_values(array_filter($pastorRekanArr));

        $tglBerdiri = '';
        if ($paroki->tanggal_berdiri) {
            $tglBerdiri = is_string($paroki->tanggal_berdiri)
                ? substr($paroki->tanggal_berdiri, 0, 10)
                : $paroki->tanggal_berdiri->format('Y-m-d');
        }

        $this->form = [
            'nama_paroki' => $paroki->nama_paroki ?? '',
            'kode_paroki' => $paroki->kode_paroki ?? '',
            'pelindung_paroki' => $paroki->pelindung_paroki ?? '',
            'status' => $paroki->status ?? 'Aktif',
            'status_paroki' => $paroki->status_paroki ?? 'Mandiri / Definitif',
            'tanggal_berdiri' => $tglBerdiri,
            'keuskupan_id' => $paroki->keuskupan_id ?? '',
            'dekenat_id' => $paroki->dekenat_id ?? '',
            'nama_pastor_paroki_aktif' => $paroki->nama_pastor_paroki_aktif ?? '',
            'nama_pastor_rekan' => $paroki->nama_pastor_rekan ?? '',
            'pastor_rekan_array' => $pastorRekanArr,
            'provinsi_id' => $paroki->provinsi_id ?? '',
            'kabupaten_id' => $paroki->kabupaten_id ?? '',
            'kecamatan_id' => $paroki->kecamatan_id ?? '',
            'desa_id' => $paroki->desa_id ?? '',
            'alamat' => $paroki->alamat ?? '',
            'telepon' => $paroki->telepon ?? '',
            'whatsapp' => $paroki->whatsapp ?? '',
            'email' => $paroki->email ?? '',
            'website' => $paroki->website ?? '',
            'maps_url' => $paroki->maps_url ?? '',
            'maps_embed' => $paroki->maps_embed ?? '',
            'latitude' => $paroki->latitude ?? '',
            'longitude' => $paroki->longitude ?? '',
            'keterangan' => $paroki->keterangan ?? '',
        ];

        $this->pastorRekanInput = '';

        // Load dependent dropdowns
        if ($paroki->keuskupan_id) {
            $this->dekenatList = Dekenat::where('keuskupan_id', $paroki->keuskupan_id)
                ->orderBy('nama_dekenat')
                ->get(['id_dekenat as id', 'nama_dekenat as name'])
                ->toArray();
        } else {
            $this->dekenatList = [];
        }

        if ($paroki->provinsi_id) {
            $this->kabupatenList = Kabupaten::where('provinsi_id', $paroki->provinsi_id)
                ->where('is_deleted', 0)
                ->orderBy('nama_kabupaten')
                ->get(['id_kabupaten as id', 'nama_kabupaten as name'])
                ->toArray();
        } else {
            $this->kabupatenList = [];
        }

        if ($paroki->kabupaten_id) {
            $this->kecamatanList = Kecamatan::where('kabupaten_id', $paroki->kabupaten_id)
                ->where('is_deleted', 0)
                ->orderBy('nama_kecamatan')
                ->get(['id_kecamatan as id', 'nama_kecamatan as name'])
                ->toArray();
        } else {
            $this->kecamatanList = [];
        }

        if ($paroki->kecamatan_id) {
            $this->desaList = DesaKelurahan::where('kecamatan_id', $paroki->kecamatan_id)
                ->where('is_deleted', 0)
                ->orderBy('nama_desa')
                ->get(['id_desa as id', 'nama_desa as name'])
                ->toArray();
        } else {
            $this->desaList = [];
        }

        $this->showEditModal = true;
        $this->showEditParokiModal = true;
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->showEditParokiModal = false;
    }

    public function addPastorRekan(): void
    {
        $clean = trim($this->pastorRekanInput);
        if ($clean !== '') {
            if (!in_array($clean, $this->form['pastor_rekan_array'], true)) {
                $this->form['pastor_rekan_array'][] = $clean;
            }
            $this->pastorRekanInput = '';
        }
    }

    public function removePastorRekan(int $index): void
    {
        if (isset($this->form['pastor_rekan_array'][$index])) {
            unset($this->form['pastor_rekan_array'][$index]);
            $this->form['pastor_rekan_array'] = array_values($this->form['pastor_rekan_array']);
        }
    }

    public function updatedFormKeuskupanId($val): void
    {
        $this->dekenatList = $val
            ? Dekenat::where('keuskupan_id', $val)->orderBy('nama_dekenat')->get(['id_dekenat as id', 'nama_dekenat as name'])->toArray()
            : [];
        $this->form['dekenat_id'] = '';
    }

    public function updatedFormProvinsiId($val): void
    {
        $this->kabupatenList = $val
            ? Kabupaten::where('provinsi_id', $val)->where('is_deleted', 0)->orderBy('nama_kabupaten')->get(['id_kabupaten as id', 'nama_kabupaten as name'])->toArray()
            : [];
        $this->form['kabupaten_id'] = '';
        $this->form['kecamatan_id'] = '';
        $this->form['desa_id'] = '';
        $this->kecamatanList = [];
        $this->desaList = [];
    }

    public function updatedFormKabupatenId($val): void
    {
        $this->kecamatanList = $val
            ? Kecamatan::where('kabupaten_id', $val)->where('is_deleted', 0)->orderBy('nama_kecamatan')->get(['id_kecamatan as id', 'nama_kecamatan as name'])->toArray()
            : [];
        $this->form['kecamatan_id'] = '';
        $this->form['desa_id'] = '';
        $this->desaList = [];
    }

    public function updatedFormKecamatanId($val): void
    {
        $this->desaList = $val
            ? DesaKelurahan::where('kecamatan_id', $val)->where('is_deleted', 0)->orderBy('nama_desa')->get(['id_desa as id', 'nama_desa as name'])->toArray()
            : [];
        $this->form['desa_id'] = '';
    }

    public function saveParokiModal(): void
    {
        $this->validate([
            'form.nama_paroki' => 'required|string|max:255',
            'form.email' => 'nullable|email|max:150',
            'form.telepon' => 'nullable|string|max:50',
            'form.whatsapp' => 'nullable|string|max:50',
        ]);

        $paroki = $this->getCurrentParokiProperty();
        if (!$paroki) return;

        // Sync pastor rekan array back to comma-separated string
        if (!empty($this->form['pastor_rekan_array'])) {
            $this->form['nama_pastor_rekan'] = implode(', ', $this->form['pastor_rekan_array']);
        }

        $validCols = Schema::getColumnListing('paroki');
        $cleanData = [];
        foreach ($this->form as $k => $v) {
            if ($k !== 'pastor_rekan_array' && in_array($k, $validCols, true)) {
                $cleanData[$k] = $v !== '' ? $v : null;
            }
        }

        if (in_array('updated_by', $validCols, true) && auth()->check()) {
            $cleanData['updated_by'] = auth()->id();
        }

        $paroki->update($cleanData);
        $paroki->refresh();

        // Sync to global settings
        $this->syncParokiToGlobalSettings($paroki);
        $this->clearAllCache();
        $this->calculateStats();
        $this->loadPastorsBertugas();

        $this->showEditModal = false;
        $this->showEditParokiModal = false;

        session()->flash('success', "Profil Paroki {$paroki->nama_paroki} berhasil diperbarui dan disinkronkan secara global.");
    }

    // ── MODAL 2: UPLOAD BANNER HEADER WEBSITE PUBLIK ─────────────────
    public function openBannerModal(): void
    {
        $paroki = $this->getCurrentParokiProperty();
        $profil = $this->getProfilProperty();

        $this->bannerUpload = null;
        $this->bannerPreview = siparoki_asset($paroki?->banner ?? $profil?->banner);
        $this->showBannerModal = true;
    }

    public function closeBannerModal(): void
    {
        $this->showBannerModal = false;
        $this->bannerUpload = null;
    }

    public function updatedBannerUpload(): void
    {
        $this->validate([
            'bannerUpload' => 'image|max:5120',
        ]);
        $this->bannerPreview = $this->bannerUpload->temporaryUrl();
    }

    public function saveBannerModal(): void
    {
        $this->validate([
            'bannerUpload' => 'required|image|max:5120',
        ]);

        $paroki = $this->getCurrentParokiProperty();
        if (!$paroki) return;

        $file = $this->bannerUpload;
        $ext = $file->getClientOriginalExtension() ?: 'webp';
        $filename = 'banner_' . time() . '_' . Str::random(8) . '.' . $ext;

        if (!file_exists(public_path('uploads/banner'))) {
            @mkdir(public_path('uploads/banner'), 0775, true);
        }
        $targetBanner = public_path('uploads/banner/' . $filename);
        @copy($file->getRealPath(), $targetBanner);

        $savedBannerUrl = '/uploads/banner/' . $filename;

        // Static fallbacks for public views
        try {
            if (!file_exists(public_path('assets/uploads/profil'))) {
                @mkdir(public_path('assets/uploads/profil'), 0775, true);
            }
            if (!file_exists(public_path('uploads/profil'))) {
                @mkdir(public_path('uploads/profil'), 0775, true);
            }
            @copy($targetBanner, public_path('assets/uploads/profil/banner_1786529079.JPG'));
            @copy($targetBanner, public_path('uploads/profil/banner_1786529079.JPG'));
        } catch (\Throwable $e) {}

        // Update paroki table if banner column exists
        if (Schema::hasColumn('paroki', 'banner')) {
            $paroki->update(['banner' => $savedBannerUrl]);
            $paroki->refresh();
        }

        // Update profil_paroki
        if (Schema::hasTable('profil_paroki')) {
            $cols = Schema::getColumnListing('profil_paroki');
            $pData = [];
            if (in_array('banner', $cols, true)) $pData['banner'] = $savedBannerUrl;
            if (in_array('foto_gereja', $cols, true)) $pData['foto_gereja'] = $savedBannerUrl;
            if (!empty($pData)) {
                $row = DB::table('profil_paroki')->first();
                if ($row) {
                    $pk = in_array('id', $cols, true) ? 'id' : $cols[0];
                    DB::table('profil_paroki')->where($pk, $row->$pk)->update($pData);
                }
            }
        }

        $this->syncParokiToGlobalSettings($paroki);
        $this->clearAllCache();

        $this->showBannerModal = false;
        $this->bannerUpload = null;

        session()->flash('success', "Banner header berhasil diunggah dan disinkronkan ke seluruh tampilan website publik.");
    }

    // ── MODAL 3: GAMBAR & SEJARAH PAROKI ─────────────────────────────
    public function openImageModal(): void
    {
        $paroki = $this->getCurrentParokiProperty();
        $profil = $this->getProfilProperty();

        $this->logoUpload = null;
        $this->logoPreview = siparoki_asset($paroki?->logo ?? $profil?->logo);
        $this->keteranganSejarah = $paroki?->keterangan ?? $profil?->sejarah ?? '';

        $this->showImageModal = true;
        $this->showEditProfilModal = true;
    }

    public function closeImageModal(): void
    {
        $this->showImageModal = false;
        $this->showEditProfilModal = false;
        $this->logoUpload = null;
    }

    public function updatedLogoUpload(): void
    {
        $this->validate([
            'logoUpload' => 'image|max:3072',
        ]);
        $this->logoPreview = $this->logoUpload->temporaryUrl();
    }

    public function saveImageModal(): void
    {
        $this->validate([
            'logoUpload' => 'nullable|image|max:3072',
        ]);

        $paroki = $this->getCurrentParokiProperty();
        if (!$paroki) return;

        $newLogoUrl = null;
        if ($this->logoUpload) {
            $file = $this->logoUpload;
            $ext = $file->getClientOriginalExtension() ?: 'webp';
            $filename = 'paroki_' . time() . '_' . Str::random(8) . '.' . $ext;
            if (!file_exists(public_path('uploads/paroki'))) {
                @mkdir(public_path('uploads/paroki'), 0775, true);
            }
            $targetLogo = public_path('uploads/paroki/' . $filename);
            @copy($file->getRealPath(), $targetLogo);
            $newLogoUrl = '/uploads/paroki/' . $filename;
        }

        $parokiUpdate = [
            'keterangan' => $this->keteranganSejarah,
        ];
        if ($newLogoUrl) {
            $parokiUpdate['logo'] = $newLogoUrl;
        }
        $paroki->update($parokiUpdate);
        $paroki->refresh();

        // Update profil_paroki
        if (Schema::hasTable('profil_paroki')) {
            $cols = Schema::getColumnListing('profil_paroki');
            $pData = [];
            if (in_array('sejarah', $cols, true)) $pData['sejarah'] = $this->keteranganSejarah;
            if ($newLogoUrl && in_array('logo', $cols, true)) $pData['logo'] = $newLogoUrl;
            if (!empty($pData)) {
                $row = DB::table('profil_paroki')->first();
                if ($row) {
                    $pk = in_array('id', $cols, true) ? 'id' : $cols[0];
                    DB::table('profil_paroki')->where($pk, $row->$pk)->update($pData);
                }
            }
        }

        $this->syncParokiToGlobalSettings($paroki);
        $this->clearAllCache();

        $this->showImageModal = false;
        $this->showEditProfilModal = false;
        $this->logoUpload = null;

        session()->flash('success', "Gambar lambang dan narasi sejarah paroki berhasil disimpan.");
    }

    // ── Backward-Compatibility Method Aliases ───────────────────────
    public function openModalEditProfil(): void { $this->openImageModal(); }
    public function closeModalEditProfil(): void { $this->closeImageModal(); }
    public function saveProfilModal(): void { $this->saveImageModal(); }
    public function openModalEditParoki(): void { $this->openEditModal(); }
    public function closeModalEditParoki(): void { $this->closeEditModal(); }

    public function getCurrentParokiProperty(): ?Paroki
    {
        if (!$this->currentParokiId) {
            $this->resolveCurrentParokiId();
        }

        return $this->currentParokiId
            ? Paroki::with(['keuskupan', 'dekenat', 'provinsi', 'kabupaten', 'kecamatan', 'desa'])->find($this->currentParokiId)
            : null;
    }

    public function getProfilProperty(): ?ProfilParokiModel
    {
        return ProfilParokiModel::first();
    }

    protected function clearAllCache(): void
    {
        $cacheKeys = [
            'active_paroki_middleware_v3',
            'active_paroki_model_v3',
            'siparoki-cache-active_paroki_middleware_v3',
            'global_app_profile',
            'global_app_settings',
            'global_pengaturan_aplikasi_first',
            'default_paroki_id',
            'ref_paroki_list_v2',
            'ref_paroki_with_relations',
            'ref_keuskupan_list',
            'ref_dekenat_list_v4',
            'ref_provinsi_list',
            'ref_kabupaten_list',
            'ref_kecamatan_list',
            'ref_desa_scoped_ntt',
        ];
        foreach ($cacheKeys as $k) Cache::forget($k);
        Cache::increment('global_view_data_version');
        for ($v = 1; $v <= 20; $v++) {
            Cache::forget("frontend.common_data.{$v}");
        }
    }

    public function render()
    {
        $pd = $this->getCurrentParokiProperty();
        $profil = $this->getProfilProperty();

        // Filtered paroki list based on search query
        $filteredParokis = $this->allParoki;
        if (trim($this->parokiSearchQuery) !== '') {
            $q = strtolower(trim($this->parokiSearchQuery));
            $filteredParokis = array_values(array_filter($this->allParoki, function ($p) use ($q) {
                return (isset($p['nama_paroki']) && str_contains(strtolower($p['nama_paroki']), $q))
                    || (isset($p['nama_keuskupan']) && str_contains(strtolower($p['nama_keuskupan']), $q))
                    || (isset($p['kode_paroki']) && str_contains(strtolower($p['kode_paroki']), $q));
            }));
        }

        // Selected paroki display label
        $selectedParokiName = 'Pilih Paroki...';
        if ($this->selectedParokiId) {
            foreach ($this->allParoki as $p) {
                if ($p['id_paroki'] == $this->selectedParokiId) {
                    $selectedParokiName = $p['nama_paroki'] . ' (' . ($p['nama_keuskupan'] ?: 'Keuskupan Agung Kupang') . ')';
                    break;
                }
            }
        } elseif ($pd) {
            $selectedParokiName = $pd->nama_paroki . ' (' . ($pd->keuskupan?->nama_keuskupan ?: 'Keuskupan Agung Kupang') . ')';
        }

        $viewData = array_merge(get_object_vars($this), [
            'pd' => $pd,
            'paroki' => $pd,
            'profil' => $profil,
            'currentPrefix' => request()->segment(1) ?: 'superadmin',
            'filteredParokis' => $filteredParokis,
            'selectedParokiName' => $selectedParokiName,
        ]);

        return view('livewire.admin.paroki.profil-paroki', $viewData)
            ->layout('layouts.admin', ['title' => 'Profil Paroki - SIPAROKI']);
    }
}
