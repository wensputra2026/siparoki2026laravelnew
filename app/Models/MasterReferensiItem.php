<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterReferensiItem extends Model
{
    use HasFactory;

    protected $table = 'master_referensi_item';
    protected $fillable = [
        'referensi_id',
        'kode',
        'nilai',
        'keterangan',
        'urutan',
        'status',
        'created_by',
    ];

    public function grup()
    {
        return $this->belongsTo(MasterReferensi::class, 'referensi_id');
    }
}
