<?php

namespace Tests\Feature;

use App\Models\KalenderProker;
use App\Models\Kegiatan;
use App\Models\Divisi;
use App\Models\User;
use App\Notifications\ProkerNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class KalenderProkerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $kegiatan;
    protected $divisi;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        $this->divisi = Divisi::factory()->create();
        $this->kegiatan = Kegiatan::factory()->create();
        $this->user = User::factory()->create([
            'divisi_id' => $this->divisi->id
        ]);
    }

    /**
     * Test dapat melihat kalender publik tanpa login
     */
    public function test_dapat_melihat_kalender_publik_tanpa_login(): void
    {
        $kalender = KalenderProker::factory()->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'is_publik' => true,
        ]);

        $response = $this->getJson('/api/kalender/events');
        
        $response->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('data.0.id', $kalender->id);
    }

    /**
     * Test tidak dapat melihat kalender private tanpa login
     */
    public function test_tidak_dapat_melihat_kalender_private_tanpa_login(): void
    {
        $kalender = KalenderProker::factory()->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'is_publik' => false,
        ]);

        $response = $this->getJson('/api/kalender/events');
        
        $response->assertStatus(200)
                 ->assertJsonPath('success', true);
        
        // Verify private event not in results
        $ids = collect($response->json('data'))->pluck('id');
        $this->assertNotContains($kalender->id, $ids);
    }

    /**
     * Test list kalender dengan login
     */
    public function test_dapat_list_kalender_dengan_login(): void
    {
        $kalender = KalenderProker::factory()->count(5)->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
        ]);

        $response = $this->actingAs($this->user)
                         ->getJson('/api/kalender');
        
        $response->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('pagination.total', 5);
    }

    /**
     * Test buat kalender dengan login
     */
    public function test_dapat_buat_kalender_dengan_login(): void
    {
        Notification::fake();

        $response = $this->actingAs($this->user)
                         ->postJson('/api/kalender', [
                             'kegiatan_id' => $this->kegiatan->id,
                             'divisi_id' => $this->divisi->id,
                             'tgl_mulai' => '2026-05-01',
                             'tgl_selesai' => '2026-05-02',
                             'warna' => '#3B82F6',
                             'is_publik' => true,
                             'status' => 'scheduled'
                         ]);

        $response->assertStatus(201)
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('data.status', 'scheduled');

        $this->assertDatabaseHas('kalender_prokers', [
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'status' => 'scheduled'
        ]);

        // Verify notification sent
        Notification::assertSentTo($this->user, ProkerNotification::class);
    }

    /**
     * Test validasi buat kalender
     */
    public function test_validasi_buat_kalender(): void
    {
        // Missing kegiatan_id
        $response = $this->actingAs($this->user)
                         ->postJson('/api/kalender', [
                             'divisi_id' => $this->divisi->id,
                             'tgl_mulai' => '2026-05-01',
                         ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('kegiatan_id');

        // Invalid date format
        $response = $this->actingAs($this->user)
                         ->postJson('/api/kalender', [
                             'kegiatan_id' => $this->kegiatan->id,
                             'tgl_mulai' => 'invalid-date',
                         ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('tgl_mulai');

        // tgl_selesai before tgl_mulai
        $response = $this->actingAs($this->user)
                         ->postJson('/api/kalender', [
                             'kegiatan_id' => $this->kegiatan->id,
                             'tgl_mulai' => '2026-05-05',
                             'tgl_selesai' => '2026-05-01',
                         ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('tgl_selesai');
    }

    /**
     * Test update kalender
     */
    public function test_dapat_update_kalender(): void
    {
        Notification::fake();

        $kalender = KalenderProker::factory()->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'status' => 'scheduled'
        ]);

        $response = $this->actingAs($this->user)
                         ->putJson("/api/kalender/{$kalender->id}", [
                             'status' => 'ongoing'
                         ]);

        $response->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('data.status', 'ongoing');

        $this->assertDatabaseHas('kalender_prokers', [
            'id' => $kalender->id,
            'status' => 'ongoing'
        ]);

        // Verify notification sent
        Notification::assertSentTo($this->user, ProkerNotification::class);
    }

    /**
     * Test delete kalender
     */
    public function test_dapat_delete_kalender(): void
    {
        $kalender = KalenderProker::factory()->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
        ]);

        $response = $this->actingAs($this->user)
                         ->deleteJson("/api/kalender/{$kalender->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('kalender_prokers', [
            'id' => $kalender->id
        ]);
    }

    /**
     * Test mark as ongoing
     */
    public function test_dapat_mark_as_ongoing(): void
    {
        $kalender = KalenderProker::factory()->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'status' => 'scheduled'
        ]);

        $response = $this->actingAs($this->user)
                         ->postJson("/api/kalender/{$kalender->id}/mark-ongoing");

        $response->assertStatus(200)
                 ->assertJsonPath('data.status', 'ongoing');

        $this->assertDatabaseHas('kalender_prokers', [
            'id' => $kalender->id,
            'status' => 'ongoing'
        ]);
    }

    /**
     * Test mark as completed
     */
    public function test_dapat_mark_as_completed(): void
    {
        $kalender = KalenderProker::factory()->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'status' => 'ongoing'
        ]);

        $response = $this->actingAs($this->user)
                         ->postJson("/api/kalender/{$kalender->id}/mark-completed");

        $response->assertStatus(200)
                 ->assertJsonPath('data.status', 'completed');
    }

    /**
     * Test mark as cancelled
     */
    public function test_dapat_mark_as_cancelled(): void
    {
        $kalender = KalenderProker::factory()->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'status' => 'scheduled'
        ]);

        $response = $this->actingAs($this->user)
                         ->postJson("/api/kalender/{$kalender->id}/mark-cancelled");

        $response->assertStatus(200)
                 ->assertJsonPath('data.status', 'cancelled');
    }

    /**
     * Test bulk update status
     */
    public function test_dapat_bulk_update_status(): void
    {
        $kalenders = KalenderProker::factory()->count(3)->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'status' => 'scheduled'
        ]);

        $ids = $kalenders->pluck('id')->toArray();

        $response = $this->actingAs($this->user)
                         ->postJson('/api/kalender/bulk-update-status', [
                             'ids' => $ids,
                             'status' => 'completed'
                         ]);

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);

        foreach ($kalenders as $kalender) {
            $this->assertDatabaseHas('kalender_prokers', [
                'id' => $kalender->id,
                'status' => 'completed'
            ]);
        }
    }

    /**
     * Test filter by divisi
     */
    public function test_dapat_filter_by_divisi(): void
    {
        $divisi2 = Divisi::factory()->create();

        KalenderProker::factory()->count(3)->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
        ]);

        KalenderProker::factory()->count(2)->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $divisi2->id,
        ]);

        $response = $this->actingAs($this->user)
                         ->getJson("/api/kalender?divisi_id={$this->divisi->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('pagination.total', 3);
    }

    /**
     * Test filter by status
     */
    public function test_dapat_filter_by_status(): void
    {
        KalenderProker::factory()->count(2)->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'status' => 'scheduled'
        ]);

        KalenderProker::factory()->count(3)->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'status' => 'completed'
        ]);

        $response = $this->actingAs($this->user)
                         ->getJson('/api/kalender?status=completed');

        $response->assertStatus(200)
                 ->assertJsonPath('pagination.total', 3);
    }

    /**
     * Test get detail kalender
     */
    public function test_dapat_get_detail_kalender(): void
    {
        $kalender = KalenderProker::factory()->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
        ]);

        $response = $this->actingAs($this->user)
                         ->getJson("/api/kalender/{$kalender->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('data.id', $kalender->id)
                 ->assertJsonPath('data.kegiatan.nama', $this->kegiatan->nama_kegiatan)
                 ->assertJsonPath('data.divisi.nama', $this->divisi->nama_divisi);
    }

    /**
     * Test get event options untuk FullCalendar
     */
    public function test_dapat_get_event_options(): void
    {
        $kalender = KalenderProker::factory()->create([
            'kegiatan_id' => $this->kegiatan->id,
            'divisi_id' => $this->divisi->id,
            'warna' => '#FF0000',
            'is_publik' => true
        ]);

        $response = $this->actingAs($this->user)
                         ->getJson("/api/kalender/{$kalender->id}/event-options");

        $response->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('data.color', '#FF0000')
                 ->assertJsonPath('data.className', 'event-publik');
    }

    /**
     * Test non-authenticated user cannot create
     */
    public function test_non_authenticated_cannot_create(): void
    {
        $response = $this->postJson('/api/kalender', [
            'kegiatan_id' => $this->kegiatan->id,
            'tgl_mulai' => '2026-05-01',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test non-authenticated user cannot update
     */
    public function test_non_authenticated_cannot_update(): void
    {
        $kalender = KalenderProker::factory()->create();

        $response = $this->putJson("/api/kalender/{$kalender->id}", [
            'status' => 'ongoing'
        ]);

        $response->assertStatus(401);
    }
}
