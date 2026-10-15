<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasIndirectId;
use App\Models\Concerns\HasUuid;

class Kapela extends Model
{
    use HasIndirectId, HasUuid;

    protected $table = 'kapela';
    protected $appends = ['hashid', 'iid'];

    protected $fillable = [
        'uuid',
        'paroki_id',
        'kode_kapela',
        'nama_kapela',
        'slug',
        'tipe',
        'pelindung',
        'lokasi',
        'penanggung_jawab',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'latitude',
        'longitude',
        'maps_url',
        'warna_area',
        'geojson',
        'geojson_area',
        'foto',
        'logo',
        'keterangan',
        'sejarah',
        'visi',
        'misi',
        'no_hp',
        'status',
        'created_by',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if (empty($model->slug) && !empty($model->nama_kapela)) {
                $model->slug = \Illuminate\Support\Str::slug($model->nama_kapela);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'is_deleted' => 'boolean',
        ];
    }

    public function paroki()
    {
        return $this->belongsTo(Paroki::class, 'paroki_id', 'id_paroki');
    }

    public function wilayahs()
    {
        return $this->hasMany(Wilayah::class, 'kapela_id');
    }

    public function kubs()
    {
        return $this->hasMany(Kub::class, 'kapela_id');
    }

    public function lingkungan()
    {
        return $this->hasMany(Lingkungan::class, 'kapela_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id', 'id_provinsi');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id', 'id_kabupaten');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

    public function desa()
    {
        return $this->belongsTo(DesaKelurahan::class, 'desa_id', 'id_desa');
    }
}
