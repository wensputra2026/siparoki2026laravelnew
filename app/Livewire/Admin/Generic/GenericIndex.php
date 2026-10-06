<?php

namespace App\Livewire\Admin\Generic;

use App\Services\GenericModuleService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class GenericIndex extends Component
{
    use WithPagination;

    public string $slug = '';
    public string $search = '';
    public int $perPage = 10;
    public string $sortField = '';
    public string $sortDirection = 'asc';

    // Selections for bulk actions
    public array $selectedIds = [];
    public bool $selectAll = false;

    // Filters
    public ?string $filterWilayah = null;
    public ?string $filterKapela = null;
    public ?string $filterKub = null;
    public ?string $filterStatus = null;

    // Modal state
    public bool $showModal = false;
    public bool $isEdit = false;
    public $editId = null;
    public array $formData = [];

    // Detail Modal
    public bool $showDetailModal = false;
    public array $detailItem = [];

    // Delete Modal
    public bool $showDeleteModal = false;
    public $deleteId = null;
    public bool $isBulkDelete = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount(string $slug)
    {
        $this->slug = $slug;
        $config = GenericModuleService::getConfig($slug);
        if (!$config) {
            abort(404, "Modul '{$slug}' tidak ditemukan.");
        }

        // Set default sort field if primary exists
        foreach ($config['columns'] as $col) {
            if (!empty($col['isPrimary'])) {
                $this->sortField = $col['key'];
                break;
            }
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

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
            $this->selectedIds = $this->getCurrentPageIds();
        } else {
            $this->selectedIds = [];
        }
    }

    public function openCreateModal()
    {
        $this->isEdit = false;
        $this->editId = null;
        $this->formData = [];
        $this->resetErrorBag();

        $config = GenericModuleService::getConfig($this->slug);
        $modelClass = $config['model'];
        $modelInstance = new $modelClass;
        $columns = GenericModuleService::getTableColumns($modelInstance->getTable());

        foreach ($columns as $col) {
            if (in_array($col, ['id', 'created_at', 'updated_at', 'deleted_at'], true)) {
                continue;
            }
            $this->formData[$col] = '';
        }

        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $config = GenericModuleService::getConfig($this->slug);
        $modelClass = $config['model'];
        $modelInstance = new $modelClass;
        $pk = $modelInstance->getKeyName();
        $item = $modelClass::where($pk, $id)->first();

        if (!$item) {
            session()->flash('error', 'Data tidak ditemukan.');
            return;
        }

        $this->isEdit = true;
        $this->editId = $id;
        $this->formData = $item->toArray();
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function save()
    {
        $config = GenericModuleService::getConfig($this->slug);
        $modelClass = $config['model'];
        $modelInstance = new $modelClass;
        $pk = $modelInstance->getKeyName();
        $tableColumns = GenericModuleService::getTableColumns($modelInstance->getTable());

        // Filter formData to only actual table columns
        $filteredData = [];
        foreach ($this->formData as $key => $val) {
            if (in_array($key, $tableColumns, true) && !in_array($key, ['id', $pk, 'created_at', 'updated_at', 'deleted_at'], true)) {
                $filteredData[$key] = $val === '' ? null : $val;
            }
        }

        if ($this->isEdit && $this->editId) {
            $record = $modelClass::where($pk, $this->editId)->first();
            if ($record) {
                $record->update($filteredData);
                session()->flash('success', 'Data ' . $config['title'] . ' berhasil diperbarui.');
            }
        } else {
            $modelClass::create($filteredData);
            session()->flash('success', 'Data ' . $config['title'] . ' berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->formData = [];
    }

    public function viewDetail($id)
    {
        $config = GenericModuleService::getConfig($this->slug);
        $modelClass = $config['model'];
        $modelInstance = new $modelClass;
        $pk = $modelInstance->getKeyName();
        $item = $modelClass::where($pk, $id)->first();

        if ($item) {
            $this->detailItem = $item->toArray();
            $this->showDetailModal = true;
        }
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
            session()->flash('error', 'Pilih minimal satu data untuk dihapus.');
            return;
        }
        $this->isBulkDelete = true;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $config = GenericModuleService::getConfig($this->slug);
        $modelClass = $config['model'];
        $modelInstance = new $modelClass;
        $pk = $modelInstance->getKeyName();

        if ($this->isBulkDelete) {
            $count = count($this->selectedIds);
            $modelClass::whereIn($pk, $this->selectedIds)->delete();
            $this->selectedIds = [];
            $this->selectAll = false;
            session()->flash('success', "{$count} data {$config['title']} berhasil dihapus.");
        } else {
            $item = $modelClass::where($pk, $this->deleteId)->first();
            if ($item) {
                $item->delete();
                session()->flash('success', "Data {$config['title']} berhasil dihapus.");
            }
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function toggleStatus($id, string $column = 'status')
    {
        $config = GenericModuleService::getConfig($this->slug);
        $modelClass = $config['model'];
        $modelInstance = new $modelClass;
        $pk = $modelInstance->getKeyName();
        $item = $modelClass::where($pk, $id)->first();

        if ($item && isset($item->$column)) {
            $current = $item->$column;
            if (is_numeric($current)) {
                $item->$column = $current ? 0 : 1;
            } elseif (in_array(strtolower((string)$current), ['aktif', 'nonaktif', 'non-aktif'], true)) {
                $item->$column = strtolower((string)$current) === 'aktif' ? 'Nonaktif' : 'Aktif';
            } elseif (in_array(strtolower((string)$current), ['published', 'draft'], true)) {
                $item->$column = strtolower((string)$current) === 'published' ? 'draft' : 'published';
            }
            $item->save();
            session()->flash('success', 'Status berhasil diperbarui.');
        }
    }

    private function getCurrentPageIds(): array
    {
        $config = GenericModuleService::getConfig($this->slug);
        $modelClass = $config['model'];
        $modelInstance = new $modelClass;
        $pk = $modelInstance->getKeyName();
        return $this->buildQuery()->pluck($pk)->map(fn($id) => (string)$id)->toArray();
    }

    private function buildQuery()
    {
        $config = GenericModuleService::getConfig($this->slug);
        $modelClass = $config['model'];
        $modelInstance = new $modelClass;
        $tableColumns = GenericModuleService::getTableColumns($modelInstance->getTable());

        $query = $modelClass::query();

        // Automatic eager loading based on columns
        $withRelations = [];
        foreach ($config['columns'] as $col) {
            if (!empty($col['relation'])) {
                $withRelations[] = $col['relation'];
            }
        }
        if (!empty($withRelations)) {
            $query->with(array_unique($withRelations));
        }

        // Apply tenant / role scoping
        $authUser = auth()->user();
        $userRoleSlug = strtolower(preg_replace('/[^a-z0-9]/', '', $authUser?->role?->slug ?? $authUser?->role?->nama_role ?? ''));

        if (str_contains($userRoleSlug, 'kub') && $authUser?->kub_id && in_array('kub_id', $tableColumns, true)) {
            $query->where('kub_id', $authUser->kub_id);
        } elseif (str_contains($userRoleSlug, 'wilayah') && $authUser?->wilayah_id && in_array('wilayah_id', $tableColumns, true)) {
            $query->where('wilayah_id', $authUser->wilayah_id);
        } elseif ((str_contains($userRoleSlug, 'kapela') || str_contains($userRoleSlug, 'stasi')) && $authUser?->kapela_id && in_array('kapela_id', $tableColumns, true)) {
            $query->where('kapela_id', $authUser->kapela_id);
        }

        // Apply Search
        if (!empty($this->search)) {
            $search = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($config, $tableColumns, $search) {
                foreach ($config['columns'] as $col) {
                    $key = $col['key'];
                    if (in_array($key, $tableColumns, true)) {
                        $q->orWhere($key, 'like', $search);
                    }
                    if (!empty($col['altKey']) && in_array($col['altKey'], $tableColumns, true)) {
                        $q->orWhere($col['altKey'], 'like', $search);
                    }
                }
            });
        }

        // Apply Sorting
        if (!empty($this->sortField) && in_array($this->sortField, $tableColumns, true)) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $pk = $modelInstance->getKeyName();
            if (in_array($pk, $tableColumns, true)) {
                $query->orderBy($pk, 'desc');
            }
        }

        return $query;
    }

    public function render()
    {
        $config = GenericModuleService::getConfig($this->slug);
        $records = $this->buildQuery()->paginate($this->perPage);

        // Fetch relational select options for Tom Select components
        $selectOptions = $this->loadSelectOptions();

        return view('livewire.admin.generic.generic-index', [
            'config' => $config,
            'records' => $records,
            'selectOptions' => $selectOptions,
        ])->layout('layouts.admin', [
            'title' => $config['title'] ?? 'Data ' . ucfirst($this->slug),
        ]);
    }

    private function loadSelectOptions(): array
    {
        $options = [];

        if (Schema::hasTable('paroki')) {
            $options['paroki_id'] = \App\Models\Paroki::orderBy('nama_paroki')->get(['id_paroki as id', 'nama_paroki as name'])->toArray();
        }
        if (Schema::hasTable('keuskupan')) {
            $options['keuskupan_id'] = \App\Models\Keuskupan::orderBy('nama_keuskupan')->get(['id_keuskupan as id', 'nama_keuskupan as name'])->toArray();
        }
        if (Schema::hasTable('dekenat')) {
            $options['dekenat_id'] = \App\Models\Dekenat::orderBy('nama_dekenat')->get(['id_dekenat as id', 'nama_dekenat as name'])->toArray();
        }
        if (Schema::hasTable('wilayah')) {
            $options['wilayah_id'] = \App\Models\Wilayah::orderBy('nama_wilayah')->get(['id', 'nama_wilayah as name'])->toArray();
        }
        if (Schema::hasTable('kapela')) {
            $options['kapela_id'] = \App\Models\Kapela::orderBy('nama_kapela')->get(['id', 'nama_kapela as name'])->toArray();
        }
        if (Schema::hasTable('kub')) {
            $options['kub_id'] = \App\Models\Kub::orderBy('nama_kub')->get(['id', 'nama_kub as name'])->toArray();
        }
        if (Schema::hasTable('roles')) {
            $options['role_id'] = \App\Models\Role::orderBy('nama_role')->get(['id', 'nama_role as name'])->toArray();
        }
        if (Schema::hasTable('provinsi')) {
            $options['provinsi_id'] = \App\Models\Provinsi::orderBy('nama_provinsi')->get(['id_provinsi as id', 'nama_provinsi as name'])->toArray();
        }

        return $options;
    }
}
