<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('kapela')) {
            Schema::table('kapela', function (Blueprint $table) {
                if (!Schema::hasColumn('kapela', 'tipe')) {
                    $table->string('tipe', 50)->default('Kapela')->nullable()->after('nama_kapela');
                }
                if (!Schema::hasColumn('kapela', 'pelindung')) {
                    $table->string('pelindung', 255)->nullable()->after('tipe');
                }
                if (!Schema::hasColumn('kapela', 'provinsi_id')) {
                    $table->unsignedBigInteger('provinsi_id')->nullable()->after('penanggung_jawab');
                }
                if (!Schema::hasColumn('kapela', 'kabupaten_id')) {
                    $table->unsignedBigInteger('kabupaten_id')->nullable()->after('provinsi_id');
                }
                if (!Schema::hasColumn('kapela', 'kecamatan_id')) {
                    $table->unsignedBigInteger('kecamatan_id')->nullable()->after('kabupaten_id');
                }
                if (!Schema::hasColumn('kapela', 'desa_id')) {
                    $table->unsignedBigInteger('desa_id')->nullable()->after('kecamatan_id');
                }
                if (!Schema::hasColumn('kapela', 'latitude')) {
                    $table->string('latitude', 50)->nullable()->after('desa_id');
                }
                if (!Schema::hasColumn('kapela', 'longitude')) {
                    $table->string('longitude', 50)->nullable()->after('latitude');
                }
                if (!Schema::hasColumn('kapela', 'maps_url')) {
                    $table->text('maps_url')->nullable()->after('longitude');
                }
                if (!Schema::hasColumn('kapela', 'warna_area')) {
                    $table->string('warna_area', 20)->default('#0284c7')->nullable()->after('maps_url');
                }
                if (!Schema::hasColumn('kapela', 'geojson')) {
                    $table->longText('geojson')->nullable()->after('warna_area');
                }
                if (!Schema::hasColumn('kapela', 'geojson_area')) {
                    $table->longText('geojson_area')->nullable()->after('geojson');
                }
                if (!Schema::hasColumn('kapela', 'foto')) {
                    $table->string('foto', 255)->nullable()->after('geojson_area');
                }
                if (!Schema::hasColumn('kapela', 'logo')) {
                    $table->string('logo', 255)->nullable()->after('foto');
                }
                if (!Schema::hasColumn('kapela', 'sejarah')) {
                    $table->longText('sejarah')->nullable()->after('keterangan');
                }
                if (!Schema::hasColumn('kapela', 'visi')) {
                    $table->text('visi')->nullable()->after('sejarah');
                }
                if (!Schema::hasColumn('kapela', 'misi')) {
                    $table->text('misi')->nullable()->after('visi');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('kapela')) {
            Schema::table('kapela', function (Blueprint $table) {
                $columns = [
                    'tipe', 'pelindung', 'provinsi_id', 'kabupaten_id', 'kecamatan_id',
                    'desa_id', 'latitude', 'longitude', 'maps_url', 'warna_area',
                    'geojson', 'geojson_area', 'foto', 'logo', 'sejarah', 'visi', 'misi'
                ];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('kapela', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
