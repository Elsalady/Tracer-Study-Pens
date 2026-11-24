<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/')->assertRedirect(route('login'));
        $this->get(route('admin.dashboard.ringkasan'))->assertRedirect(route('login'));
    }

    public function test_login_benar_masuk_ke_ringkasan(): void
    {
        $response = $this->post(route('login'), [
            'email' => env('ADMIN_EMAIL'),
            'password' => env('ADMIN_PASSWORD'),
        ]);

        $response->assertRedirect(route('admin.dashboard.ringkasan'));
        $this->assertAuthenticated();

        $this->get(route('admin.dashboard.ringkasan'))->assertOk();
    }

    public function test_login_salah_ditolak(): void
    {
        $response = $this->post(route('login'), [
            'email' => env('ADMIN_EMAIL'),
            'password' => 'kata-sandi-salah',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Email atau kata sandi salah.', session('errors')->first('email'));
        $this->assertGuest();
    }

    public function test_logout_berfungsi(): void
    {
        $this->post(route('login'), [
            'email' => env('ADMIN_EMAIL'),
            'password' => env('ADMIN_PASSWORD'),
        ])->assertRedirect(route('admin.dashboard.ringkasan'));

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->get(route('admin.dashboard.ringkasan'))->assertRedirect(route('login'));
    }

    public function test_login_dibatasi_lima_percobaan_per_menit(): void
    {
        $kredensial = [
            'email' => env('ADMIN_EMAIL'),
            'password' => 'kata-sandi-salah',
        ];

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login'), $kredensial)->assertSessionHasErrors('email');
        }

        $response = $this->post(route('login'), $kredensial);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Terlalu banyak percobaan login.', session('errors')->first('email'));
        $this->assertGuest();
    }

    public function test_login_berhasil_menghapus_catatan_gagal(): void
    {
        $kredensialSalah = [
            'email' => env('ADMIN_EMAIL'),
            'password' => 'kata-sandi-salah',
        ];

        for ($i = 0; $i < 4; $i++) {
            $this->post(route('login'), $kredensialSalah)->assertSessionHasErrors('email');
        }

        $this->post(route('login'), [
            'email' => env('ADMIN_EMAIL'),
            'password' => env('ADMIN_PASSWORD'),
        ])->assertRedirect(route('admin.dashboard.ringkasan'));

        $this->post(route('logout'));

        $this->post(route('login'), $kredensialSalah)->assertSessionHasErrors('email');
        $this->assertStringNotContainsString('Terlalu banyak percobaan login.', session('errors')->first('email'));
    }
}
