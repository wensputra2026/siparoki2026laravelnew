<?php

namespace App\Livewire\Admin\Kk;

use App\Models\Kapela;
use App\Models\KkKatolik;
use App\Models\Kub;
use App\Models\Wilayah;
use Livewire\Component;
use Livewire\WithPagination;

class KkIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;
    public string $sortField = 'id';
    public string $sortDirection = 'desc';

    // Filters
    public ?string $filterWilayah = null;
    public ?string $filterKapela = null;
    public ?string $filterKub = null;
    public ?string $filterStatus = null;

    // Selections
    public array $selectedIds = [];
    public bool $selectAll = false;

    // Delete modal
    public bool $showDeleteModal = false;
    public $deleteId = null;
    public bool $isBulkDelete = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterWilayah' => ['except' => null],
        'filterKapela' => ['except' => null],
        'filterKub' => ['except' => null],
        'filterStatus' => ['except' => null],
        'perPage' => ['except' => 10],
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterWilayah() { $this->resetPage(); }
    public function updatingFilterKapela() { $this->resetPage(); }
    public function updatingFilterKub() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedIds = $this->buildQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedIds = [];
        }
    }

    public function resetFilters()
    {
        $this->filterWilayah = null;
        $this->filterKapela = null;
        $this->filterKub = null;
        $this->filterStatus = null;
        $this->search = '';
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->isBulkDelete = false;
        $this->showDeleteModal = true;
    }

    public function confirmBulkDelete()
    {
        if (empty($this->selectedIds)) {
            session()->flash('error', 'Pilih minimal satu data KK untuk dihapus.');
            return;
        }
        $this->isBulkDelete = true;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->isBulkDelete) {
            $count = count($this->selectedIds);
            KkKatolik::whereIn('id', $this->selectedIds)->delete();
            $this->selectedIds = [];
            $this->selectAll = false;
            session()->flash('success', "{$count} data Kartu Keluarga berhasil dihapus.");
        } else {
            $kk = KkKatolik::find($this->deleteId);
            if ($kk) {
                $kk->delete();
                session()->flash('success', "Data KK {$kk->no_kk_kw} berhasil dihapus.");
            }
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    private function buildQuery()
    {
        $query = KkKatolik::query()
            ->with(['wilayah', 'kapela', 'kub'])
            ->withCount('anggota');

        // Scoping
        $authUser = auth()->user();
        $userRoleSlug = strtolower(preg_replace('/[^a-z0-9]/', '', $authUser?->role?->slug ?? $authUser?->role?->nama_role ?? ''));

        if (str_contains($userRoleSlug, 'kub') && $authUser?->kub_id) {
            $query->where('kub_id', $authUser->kub_id);
        } elseif (str_contains($userRoleSlug, 'wilayah') && $authUser?->wilayah_id) {
            $query->where('wilayah_id', $authUser->wilayah_id);
        } elseif ((str_contains($userRoleSlug, 'kapela') || str_contains($userRoleSlug, 'stasi')) && $authUser?->kapela_id) {
            $query->where('kapela_id', $authUser->kapela_id);
        }

        if ($this->filterWilayah) {
            $query->where('wilayah_id', $this->filterWilayah);
        }
        if ($this->filterKapela) {
            $query->where('kapela_id', $this->filterKapela);
        }
        if ($this->filterKub) {
            $query->where('kub_id', $this->filterKub);
        }
        if ($this->filterStatus) {
            $query->where('status_kk', $this->filterStatus);
        }

        if (!empty($this->search)) {
            $search = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($search) {
                $q->where('no_kk_kw', 'like', $search)
                  ->orWhere('no_kk_dukcapil', 'like', $search)
                  ->orWhere('nama_baptis_pemilik', 'like', $search)
                  ->orWhere('nama_lahir_pemilik', 'like', $search)
                  ->orWhere('alamat_sekarang', 'like', $search)
                  ->orWhereHas('anggota', function ($aq) use ($search) {
                      $aq->where('nama_lengkap', 'like', $search)
                         ->orWhere('nama_baptis', 'like', $search);
                  });
            });
        }

        return $query->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $kks = $this->buildQuery()->paginate($this->perPage);

        // Stats
        $totalKk = KkKatolik::count();
        $totalKkAktif = KkKatolik::where('status_kk', 'Aktif')->count();
        $totalJiwa = \App\Models\Umat::count();

        // Options for Tom Select
        $wilayahOptions = Wilayah::orderBy('nama_wilayah')->get(['id', 'nama_wilayah']);
        $kapelaOptions = Kapela::orderBy('nama_kapela')->get(['id', 'nama_kapela']);
        $kubOptions = Kub::orderBy('nama_kub')->get(['id', 'nama_kub', 'wilayah_id']);

        $currentPrefix = request()->segment(1) ?: 'superadmin';

        return view('livewire.admin.kk.kk-index', [
            'kks' => $kks,
            'totalKk' => $totalKk,
            'totalKkAktif' => $totalKkAktif,
            'totalJiwa' => $totalJiwa,
            'wilayahOptions' => $wilayahOptions,
            'kapelaOptions' => $kapelaOptions,
            'kubOptions' => $kubOptions,
            'prefix' => $currentPrefix,
        ])->layout('layouts.admin', [
            'title' => 'Kartu Keluarga (KK) Katolik',
        ]);
    }
}
