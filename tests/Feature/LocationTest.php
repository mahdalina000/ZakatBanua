<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
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

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Masjid Raya An-Nur',
            'address' => 'Jl. Pahlawan No.1',
            'kelurahan' => 'Kuala',
            'kecamatan' => 'Banjarmasin Utara',
            'latitude' => -3.31,
            'longitude' => 114.59,
            'type' => 'upz',
            'phone' => '081234567890',
            'opening_hours' => '08:00-17:00',
        ], $overrides);
    }

    public function test_index_is_public(): void
    {
        Location::create($this->payload());

        $this->getJson('/api/locations')
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonCount(1, 'data');
    }

    public function test_index_filters_by_type(): void
    {
        Location::create($this->payload(['name' => 'A', 'type' => 'upz']));
        Location::create($this->payload(['name' => 'B', 'type' => 'baznas']));

        $this->getJson('/api/locations?type=baznas')
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.name', 'B');
    }

    public function test_index_searches_by_name(): void
    {
        Location::create($this->payload(['name' => 'Masjid An-Nur']));
        Location::create($this->payload(['name' => 'Posko Warga']));

        $this->getJson('/api/locations?search=An-Nur')
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.name', 'Masjid An-Nur');
    }

    public function test_show_returns_404_when_missing(): void
    {
        $this->getJson('/api/locations/999')
            ->assertStatus(404)
            ->assertJsonPath('message', 'Data tidak ditemukan.');
    }

    public function test_store_requires_authentication(): void
    {
        $this->postJson('/api/locations', $this->payload())->assertStatus(401);
    }

    public function test_store_forbidden_for_regular_user(): void
    {
        $this->actingAs($this->regularUser(), 'sanctum')
            ->postJson('/api/locations', $this->payload())
            ->assertStatus(403);
    }

    public function test_admin_can_create_location(): void
    {
        $this->actingAs($this->admin(), 'sanctum')
            ->postJson('/api/locations', $this->payload())
            ->assertStatus(201)
            ->assertJsonPath('data.name', 'Masjid Raya An-Nur')
            ->assertJsonPath('data.type', 'upz')
            ->assertJsonPath('data.type_label', 'UPZ / Masjid');

        $this->assertDatabaseHas('locations', ['name' => 'Masjid Raya An-Nur']);
    }

    public function test_store_validates_required_and_type(): void
    {
        $this->actingAs($this->admin(), 'sanctum')
            ->postJson('/api/locations', ['type' => 'salah'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'address', 'type']);
    }

    public function test_admin_can_update_location(): void
    {
        $location = Location::create($this->payload());

        $this->actingAs($this->admin(), 'sanctum')
            ->putJson("/api/locations/{$location->id}", $this->payload(['name' => 'Revisi', 'type' => 'baznas']))
            ->assertOk()
            ->assertJsonPath('data.name', 'Revisi')
            ->assertJsonPath('data.type_label', 'BAZNAS');
    }

    public function test_update_forbidden_for_regular_user(): void
    {
        $location = Location::create($this->payload());

        $this->actingAs($this->regularUser(), 'sanctum')
            ->putJson("/api/locations/{$location->id}", $this->payload(['name' => 'Revisi']))
            ->assertStatus(403);
    }

    public function test_admin_can_delete_location(): void
    {
        $location = Location::create($this->payload());

        $this->actingAs($this->admin(), 'sanctum')
            ->deleteJson("/api/locations/{$location->id}")
            ->assertOk()
            ->assertJsonPath('message', 'Lokasi dihapus');

        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }

    public function test_delete_forbidden_for_regular_user(): void
    {
        $location = Location::create($this->payload());

        $this->actingAs($this->regularUser(), 'sanctum')
            ->deleteJson("/api/locations/{$location->id}")
            ->assertStatus(403);
    }
}
