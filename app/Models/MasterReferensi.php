<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterReferensi extends Model
{
    use HasFactory;

    protected $table = 'master_referensi';
    protected $fillable = [
        'kode_grup',
        'nama_grup',
        'deskripsi',
        'tabel_sumber',
        'kolom_sumber',
        'urutan',
        'status',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(MasterReferensiItem::class, 'referensi_id')->orderBy('urutan');
    }
}
