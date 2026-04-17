<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationApiTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Test get user notifications
     */
    public function test_get_user_notifications(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/notifications');

        $response->assertOk();
        $response->assertJsonStructure([
            'data',
            'pagination' => ['total', 'per_page', 'current_page', 'last_page'],
        ]);
    }

    /**
     * Test get unread notifications
     */
    public function test_get_unread_notifications(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/notifications/unread');

        $response->assertOk();
        $response->assertJsonStructure([
            'unread_count',
            'notifications' => [
                '*' => ['id', 'type', 'data', 'created_at', 'time_ago'],
            ],
        ]);
    }

    /**
     * Test get unread count
     */
    public function test_get_unread_count(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/notifications/unread-count');

        $response->assertOk();
        $response->assertJsonStructure(['unread_count']);
    }

    /**
     * Test mark notification as read
     */
    public function test_mark_notification_as_read(): void
    {
        $notification = DatabaseNotification::create([
            'id' => 'test-notification-id',
            'type' => 'App\Notifications\PasswordUpdatedNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $this->user->id,
            'data' => json_encode(['title' => 'Test Notification']),
        ]);

        $response = $this->actingAs($this->user)
            ->postJson('/api/notifications/' . $notification->id . '/read');

        $response->assertOk();
        $response->assertJsonStructure(['message', 'notification']);

        $notification->refresh();
        $this->assertNotNull($notification->read_at);
    }

    /**
     * Test mark all notifications as read
     */
    public function test_mark_all_notifications_as_read(): void
    {
        // Create multiple notifications
        for ($i = 0; $i < 3; $i++) {
            DatabaseNotification::create([
                'id' => 'test-notification-' . $i,
                'type' => 'App\Notifications\PasswordUpdatedNotification',
                'notifiable_type' => User::class,
                'notifiable_id' => $this->user->id,
                'data' => json_encode(['title' => 'Test Notification ' . $i]),
            ]);
        }

        $response = $this->actingAs($this->user)
            ->postJson('/api/notifications/mark-all-as-read');

        $response->assertOk();
        $response->assertJsonStructure(['message', 'updated_count']);
    }

    /**
     * Test delete notification
     */
    public function test_delete_notification(): void
    {
        $notification = DatabaseNotification::create([
            'id' => 'test-notification-delete',
            'type' => 'App\Notifications\PasswordUpdatedNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $this->user->id,
            'data' => json_encode(['title' => 'Test Notification']),
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson('/api/notifications/' . $notification->id);

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        $this->assertNull(DatabaseNotification::find($notification->id));
    }

    /**
     * Test delete all notifications
     */
    public function test_delete_all_notifications(): void
    {
        // Create multiple notifications
        for ($i = 0; $i < 3; $i++) {
            DatabaseNotification::create([
                'id' => 'test-notification-delete-' . $i,
                'type' => 'App\Notifications\PasswordUpdatedNotification',
                'notifiable_type' => User::class,
                'notifiable_id' => $this->user->id,
                'data' => json_encode(['title' => 'Test Notification ' . $i]),
            ]);
        }

        $response = $this->actingAs($this->user)
            ->deleteJson('/api/notifications');

        $response->assertOk();
        $response->assertJsonStructure(['message', 'deleted_count']);
    }

    /**
     * Test unauthorized access
     */
    public function test_unauthorized_access_returns_401(): void
    {
        $response = $this->getJson('/api/notifications');

        $response->assertUnauthorized();
    }

    /**
     * Test accessing other user's notification returns 404
     */
    public function test_accessing_other_user_notification_returns_404(): void
    {
        $otherUser = User::factory()->create();
        
        $notification = DatabaseNotification::create([
            'id' => 'test-other-user-notification',
            'type' => 'App\Notifications\PasswordUpdatedNotification',
            'notifiable_type' => User::class,
            'notifiable_id' => $otherUser->id,
            'data' => json_encode(['title' => 'Other User Notification']),
        ]);

        $response = $this->actingAs($this->user)
            ->postJson('/api/notifications/' . $notification->id . '/read');

        $response->assertNotFound();
    }
}
