<?php

namespace App\Livewire\Admin\Backup;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithFileUploads;

class BackupDatabase extends Component
{
    use WithFileUploads;

    public $uploadSql = null;
    public bool $showDeleteModal = false;
    public $deleteId = null;

    public function generateBackup()
    {
        $backupDir = storage_path('app/backups');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $fileName = 'backup_' . config('database.connections.mysql.database') . '_' . date('Y-m-d_H-i-s') . '.sql';
        $filePath = $backupDir . '/' . $fileName;

        // Perform fast table export
        $tables = DB::select('SHOW TABLES');
        $dbName = 'Tables_in_' . config('database.connections.mysql.database');

        $sqlContent = "-- Siparoki Database Backup\n";
        $sqlContent .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
        $sqlContent .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$dbName;
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $sqlContent .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sqlContent .= $createTable[0]->{'Create Table'} . ";\n\n";

            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($val) {
                    if (is_null($val)) return "NULL";
                    return "'" . addslashes((string)$val) . "'";
                }, (array)$row);

                $sqlContent .= "INSERT INTO `{$tableName}` VALUES (" . implode(',', $values) . ");\n";
            }
            $sqlContent .= "\n";
        }
        $sqlContent .= "SET FOREIGN_KEY_CHECKS=1;\n";

        file_put_contents($filePath, $sqlContent);

        if (Schema::hasTable('backup_database')) {
            DB::table('backup_database')->insert([
                'nama_file' => $fileName,
                'ukuran' => filesize($filePath),
                'dibuat_oleh' => auth()->user()?->nama_lengkap ?? 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        session()->flash('success', "Cadangan database {$fileName} berhasil dibuat.");
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $record = DB::table('backup_database')->where('id', $this->deleteId)->first();
        if ($record) {
            $filePath = storage_path('app/backups/' . $record->nama_file);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            DB::table('backup_database')->where('id', $this->deleteId)->delete();
            session()->flash('success', 'File cadangan database berhasil dihapus.');
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $prefix = request()->segment(1) ?: 'superadmin';

        $backups = [];
        if (Schema::hasTable('backup_database')) {
            $backups = DB::table('backup_database')->orderBy('id', 'desc')->get();
        }

        return view('livewire.admin.backup.backup-database', [
            'backups' => $backups,
            'prefix' => $prefix,
        ])->layout('layouts.admin', [
            'title' => 'Backup & Restore Database',
        ]);
    }
}
