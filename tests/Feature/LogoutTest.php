<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_logout()
    {
        // Tworzenie i logowanie użytkownika
        $user = User::factory()->create();
        $this->actingAs($user);

        // Wykonaj żądanie POST do routingu wylogowania
        $response = $this->post('/logout');

        // Sprawdź, czy użytkownik został wylogowany
        $this->assertGuest();
    }
}
