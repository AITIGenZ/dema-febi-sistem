<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\PasswordUpdatedNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordUpdateNotificationTest extends TestCase
{
    /**
     * Test password update sends notification
     */
    public function test_password_update_sends_notification(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->put('/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        Notification::assertSentTo(
            $user,
            PasswordUpdatedNotification::class
        );

        $response->assertSessionHas('status', 'password-updated');
    }

    /**
     * Test password update without current password fails
     */
    public function test_password_update_without_current_password_fails(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->put('/password', [
            'current_password' => '',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('updatePassword');
    }

    /**
     * Test password confirmation mismatch fails
     */
    public function test_password_confirmation_mismatch_fails(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->put('/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('updatePassword');
    }
}
