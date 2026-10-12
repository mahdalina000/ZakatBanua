<?php

namespace Tests\Feature;

use App\Models\BerasPrice;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BerasPriceTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'super_admin', 'is_active' => true]);
    }

    private function regularUser(): User
    {
        return User::factory()->create(['role' => 'user', 'is_active' => true]);
    }

    public function test_show_is_public_and_returns_latest_price(): void
    {
        BerasPrice::create(['price' => 15000, 'note' => 'lama']);
        BerasPrice::create(['price' => 16000, 'note' => 'baru']);

        $this->getJson('/api/beras-price')
            ->assertOk()
            ->assertJsonPath('data.price', 16000)
            ->assertJsonPath('data.note', 'baru');
    }

    public function test_show_returns_404_when_empty(): void
    {
        $this->getJson('/api/beras-price')
            ->assertStatus(404)
            ->assertJsonPath('message', 'Data tidak ditemukan.');
    }

    public function test_update_requires_authentication(): void
    {
        $this->putJson('/api/beras-price', ['price' => 17000])->assertStatus(401);
    }

    public function test_update_forbidden_for_regular_user(): void
    {
        $user = $this->regularUser();

        $this->actingAs($user, 'sanctum')
            ->putJson('/api/beras-price', ['price' => 17000])
            ->assertStatus(403);
    }

    public function test_admin_can_update_and_history_is_kept(): void
    {
        BerasPrice::create(['price' => 16000]);

        $this->actingAs($this->admin(), 'sanctum')
            ->putJson('/api/beras-price', ['price' => 17000, 'note' => 'naik'])
            ->assertOk()
            ->assertJsonPath('data.price', 17000)
            ->assertJsonPath('data.note', 'naik');

        $this->assertDatabaseCount('beras_prices', 2);
    }

    public function test_update_validates_price_minimum(): void
    {
        $this->actingAs($this->admin(), 'sanctum')
            ->putJson('/api/beras-price', ['price' => 500])
            ->assertStatus(422)
            ->assertJsonValidationErrors('price');
    }
}
