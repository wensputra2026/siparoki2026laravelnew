<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Pengumuman extends Model
{

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'slug',
        'ringkasan',
        'kategori',
        'gambar',
        'penulis',
        'tgl_mulai',
        'tgl_selesai',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'tgl_mulai' => 'date',
            'tgl_selesai' => 'date',
            'status' => 'boolean',
            'is_deleted' => 'boolean',
        ];
    }

    /**
     * Mutator untuk kolom status agar nilai string 'Nonaktif' / 'Aktif'
     * tidak salah dikonversi oleh boolean casting PHP.
     */
    public function setStatusAttribute($value): void
    {
        if (is_string($value)) {
            $this->attributes['status'] = in_array(strtolower(trim($value)), ['aktif', '1', 'true', 'ya', 'active'], true) ? 1 : 0;
        } elseif (is_bool($value)) {
            $this->attributes['status'] = $value ? 1 : 0;
        } else {
            $this->attributes['status'] = (int) $value === 1 ? 1 : 0;
        }
    }
}
