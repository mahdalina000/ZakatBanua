<?php

namespace Tests\Feature;

use App\Models\BerasPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KalkulatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_zakat_fitrah_uses_price_from_database(): void
    {
        BerasPrice::create(['price' => 16000, 'note' => 'acuan']);

        $this->postJson('/api/kalkulator/zakat-fitrah', ['jumlah_jiwa' => 4])
            ->assertOk()
            ->assertJsonPath('data.jumlah_jiwa', 4)
            ->assertJsonPath('data.harga_beras_per_kg', 16000)
            ->assertJsonPath('data.beras_kg', 10)
            ->assertJsonPath('data.total_rupiah', 160000)
            ->assertJsonPath('data.harga_beras_sumber', 'database');
    }

    public function test_zakat_fitrah_uses_override_price(): void
    {
        BerasPrice::create(['price' => 16000]);

        $this->postJson('/api/kalkulator/zakat-fitrah', [
            'jumlah_jiwa' => 4,
            'harga_beras_override' => 20000,
        ])
            ->assertOk()
            ->assertJsonPath('data.harga_beras_per_kg', 20000)
            ->assertJsonPath('data.total_rupiah', 200000)
            ->assertJsonPath('data.harga_beras_sumber', 'override');
    }

    public function test_zakat_fitrah_falls_back_to_default_when_no_data(): void
    {
        $this->postJson('/api/kalkulator/zakat-fitrah', ['jumlah_jiwa' => 2])
            ->assertOk()
            ->assertJsonPath('data.harga_beras_sumber', 'default')
            ->assertJsonPath('data.beras_kg', 5);
    }

    public function test_zakat_fitrah_requires_positive_jumlah_jiwa(): void
    {
        $this->postJson('/api/kalkulator/zakat-fitrah', ['jumlah_jiwa' => 0])
            ->assertStatus(422)
            ->assertJsonValidationErrors('jumlah_jiwa');
    }

    public function test_zakat_mal_obligatory_when_above_nishab(): void
    {
        $this->postJson('/api/kalkulator/zakat-mal', [
            'total_harta' => 100000000,
            'harga_emas_per_gram' => 1100000,
        ])
            ->assertOk()
            ->assertJsonPath('data.nishab', 93500000)
            ->assertJsonPath('data.wajib_zakat', true)
            ->assertJsonPath('data.zakat', 2500000)
            ->assertJsonPath('data.persentase', 2.5);
    }

    public function test_zakat_mal_not_obligatory_below_nishab(): void
    {
        $this->postJson('/api/kalkulator/zakat-mal', [
            'total_harta' => 50000000,
            'harga_emas_per_gram' => 1100000,
        ])
            ->assertOk()
            ->assertJsonPath('data.wajib_zakat', false)
            ->assertJsonPath('data.zakat', 0);
    }

    public function test_zakat_mal_uses_default_gold_price(): void
    {
        $this->postJson('/api/kalkulator/zakat-mal', ['total_harta' => 100000000])
            ->assertOk()
            ->assertJsonPath('data.nishab', 93500000);
    }

    public function test_zakat_mal_requires_total_harta(): void
    {
        $this->postJson('/api/kalkulator/zakat-mal', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors('total_harta');
    }
}
