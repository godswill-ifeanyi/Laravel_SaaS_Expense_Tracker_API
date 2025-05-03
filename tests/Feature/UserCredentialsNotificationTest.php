<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserCredentials;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCredentialsNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed company and user
        $this->seed(\Database\Seeders\CompanySeeder::class);
    }

    public function test_created_sends_notification_and_hashes_password()
    {
        Notification::fake();

        // Create the user (this should trigger the observer)
        $plainPassword = 'secret123';
        $user = User::factory()->make([
            'email' => 'newuser@example.com',
            'password' => $plainPassword
        ]);

        // Assert the notification was sent
        $user->save(); // triggers observer

    Notification::assertSentTo($user, UserCredentials::class,
        function ($notification, $channels) use ($user, $plainPassword) {
            $this->assertEquals($user->email, $notification->getEmail());
            $this->assertEquals($plainPassword, $notification->getPassword());
            return true;
        }
    );

    $user->refresh(); // reload from DB to ensure we have updated data

    $this->assertNotEquals($plainPassword, $user->password); // Ensure it's hashed
    $this->assertTrue(Hash::check($plainPassword, $user->password));
    }
}
