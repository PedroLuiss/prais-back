<?php

namespace Tests\Feature\API\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class LogoutUserTest extends TestCase
{
    use RefreshDatabase;

    protected $headers = ['Content-Type' => 'application/json'];

    /**
     * A feature test for the successful logout response.
     */
    public function test_successful_logout(): void
    {
        $this->seed();

        $userEmail = config("testing.user_email");

        $user = User::where("email", $userEmail)
            ->firstOrFail();

        Sanctum::actingAs($user);

        $response = $this->withHeaders($this->headers)
            ->deleteJson('/api/auth');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            "message" => __("response.ok_success"),
        ]);
    }
}
