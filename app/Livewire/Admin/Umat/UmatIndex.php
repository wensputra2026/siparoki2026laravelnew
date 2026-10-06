<?php

namespace App\Livewire\Admin\Umat;

use App\Models\Kapela;
use App\Models\Kub;
use App\Models\Umat;
use App\Models\Wilayah;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Data Umat Paroki')]
class UmatIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterWilayah = '';
    public $filterKub = '';
    public $filterKapela = '';
    public $filterGender = '';
    public $filterBaptis = '';
    public $perPage = 15;
    public $sortField = 'id';
    public $sortAsc = false;

    // Modal detail state
    public $selectedUmat = null;
    public $showDetailModal = false;

    // Delete confirmation state
    public $deleteId = null;
    public $deleteName = '';
    public $showDeleteModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterWilayah' => ['except' => ''],
        'filterKub' => ['except' => ''],
        'filterKapela' => ['except' => ''],
        'filterGender' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterWilayah()
    {
        $this->resetPage();
    }

    public function updatingFilterKub()
    {
        $this->resetPage();
    }

    public function updatingFilterKapela()
    {
        $this->resetPage();
    }

    public function updatingFilterGender()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterWilayah', 'filterKub', 'filterKapela', 'filterGender', 'filterBaptis']);
        $this->resetPage();
    }

    public function viewDetail($id)
    {
        $this->selectedUmat = Umat::with(['kk', 'kub', 'wilayah', 'kapela', 'lingkungan'])->find($id);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedUmat = null;
    }

    public function confirmDelete($id, $nama)
    {
        $this->deleteId = $id;
        $this->deleteName = $nama;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $umat = Umat::find($this->deleteId);
            if ($umat) {
                $umat->update(['is_deleted' => 1]);
                $this->dispatch('notify', [
                    'message' => "Data umat {$this->deleteName} berhasil dihapus.",
                    'type' => 'success'
                ]);
            }
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deleteName = '';
    }

    public function render()
    {
        $query = Umat::query()
            ->where('is_deleted', 0)
            ->with(['kk', 'kub', 'wilayah', 'kapela']);

        if (!empty($this->search)) {
            $search = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', $search)
                  ->orWhere('nama_baptis', 'like', $search)
                  ->orWhere('nik', 'like', $search)
                  ->orWhere('niu', 'like', $search)
                  ->orWhere('handphone', 'like', $search);
            });
        }

        if (!empty($this->filterWilayah)) {
            $query->where('wilayah_id', $this->filterWilayah);
        }

        if (!empty($this->filterKub)) {
            $query->where('kub_id', $this->filterKub);
        }

        if (!empty($this->filterKapela)) {
            $query->where('kapela_id', $this->filterKapela);
        }

        if (!empty($this->filterGender)) {
            $query->where('jenis_kelamin', $this->filterGender);
        }

        if ($this->filterBaptis === 'sudah') {
            $query->where(function ($q) {
                $q->whereNotNull('tgl_baptis')
                  ->orWhere('status_baptis', 'Sudah')
                  ->orWhere('status_baptis', 'Ya');
            });
        } elseif ($this->filterBaptis === 'belum') {
            $query->where(function ($q) {
                $q->whereNull('tgl_baptis')
                  ->where(function ($sq) {
                      $sq->whereNull('status_baptis')
                         ->orWhere('status_baptis', 'Belum');
                  });
            });
        }

        $umats = $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                       ->paginate($this->perPage);

        $kapelas = Kapela::where('is_deleted', 0)->orderBy('nama_kapela')->get();
        $wilayahs = Wilayah::where('is_deleted', 0)->orderBy('nama_wilayah')->get();
        $kubs = Kub::where('is_deleted', 0)->orderBy('nama_kub')->get();

        return view('livewire.admin.umat.umat-index', [
            'umats' => $umats,
            'kapelas' => $kapelas,
            'wilayahs' => $wilayahs,
            'kubs' => $kubs,
            'search' => $this->search,
            'filterWilayah' => $this->filterWilayah,
            'filterKub' => $this->filterKub,
            'filterKapela' => $this->filterKapela,
            'filterGender' => $this->filterGender,
            'filterBaptis' => $this->filterBaptis,
            'sortField' => $this->sortField,
            'sortAsc' => $this->sortAsc,
            'selectedUmat' => $this->selectedUmat,
            'showDetailModal' => $this->showDetailModal,
            'showDeleteModal' => $this->showDeleteModal,
            'deleteName' => $this->deleteName,
        ]);
    }
}
