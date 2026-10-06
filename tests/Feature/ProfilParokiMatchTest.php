<?php

namespace Tests\Feature;

use App\Models\Paroki;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class ProfilParokiMatchTest extends TestCase
{
    public function test_profil_paroki_renders_with_superadmin()
    {
        $user = User::where('username', 'superadmin')->first() ?? User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        $response = $this->actingAs($user)->get('/superadmin/profil-paroki');
        $response->assertStatus(200);
        $response->assertSee('Detail Profil Paroki');
        $response->assertSee('Setup Default');
        $response->assertSee('Upload Banner');
        $response->assertSee('Gambar & Sejarah');
        $response->assertSee('Edit Data Profil');
        $response->assertSee('IDENTITAS PAROKI');
        $response->assertSee('PELAYAN PASTORAL');
        $response->assertSee('LOKASI & WILAYAH ADMINISTRATIF');
        $response->assertSee('KONTAK & MEDIA INFORMASI');
        $response->assertSee('Paroki Utama (Default)');
        $response->assertSee('Auto-Sinkronisasi Aktif:');
    }

    public function test_livewire_profil_paroki_component_features()
    {
        $user = User::where('username', 'superadmin')->first() ?? User::first();

        Livewire::actingAs($user)
            ->test(\App\Livewire\Admin\Paroki\ProfilParoki::class)
            ->assertSet('showEditModal', false)
            ->assertSet('showBannerModal', false)
            ->assertSet('showImageModal', false)
            ->call('openEditModal')
            ->assertSet('showEditModal', true)
            ->call('closeEditModal')
            ->assertSet('showEditModal', false)
            ->call('openBannerModal')
            ->assertSet('showBannerModal', true)
            ->call('closeBannerModal')
            ->assertSet('showBannerModal', false)
            ->call('openImageModal')
            ->assertSet('showImageModal', true)
            ->call('closeImageModal')
            ->assertSet('showImageModal', false);
    }
}
