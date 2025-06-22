<?php

namespace Tests\Feature\API\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    protected $headers = ['Content-Type' => 'application/json'];

    /**
     * A feature test for the successful login response.
     */
    public function test_successful_login(): void
    {
        $userEmail = config("testing.user_email");
        $userPassword = config("testing.user_password");

        $this->seed();

        $response = $this->withHeaders($this->headers)
            ->postJson(
                '/api/auth', 
                [
                    'email' => $userEmail,
                    'password' => $userPassword,
                ],
            );
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(["email" => $userEmail]);
        $response->assertJsonStructure([
            "data" => [
                "id",
                "name",
                "email",
                "createdAt",
                "updatedAt",
                "token",
            ],
        ]);
    }

    /**
     * A feature test for the validation error response.
     */
    public function test_validation_error(): void
    {
        $userEmail = config("testing.user_email");

        $this->seed();

        $response = $this->withHeaders($this->headers)
            ->postJson(
                '/api/auth', 
                [
                    'email' => $userEmail,
                ],
            );
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            "message" => __(
                "validation.required",
                ["attribute" => "password"],
            ),
        ]);
    }

    /**
     * A feature test for the invalid credentials error response.
     */
    public function test_invalid_credentials_error(): void
    {
        $userEmail = config("testing.user_email");
        $badPassword = "badpassword";

        $this->seed();

        $response = $this->withHeaders($this->headers)
            ->postJson(
                '/api/auth', 
                [
                    'email' => $userEmail,
                    'password' => $badPassword,
                ],
            );
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            "message" => __("response.login.invalid_credentials_error"),
        ]);
    }

    /**
     * A feature test for the not found error response.
     */
    public function test_not_found_error(): void
    {
        $this->seed();
        
        $userEmail = "newuser12111@doe.com";
        User::factory()->create([
            "email" => $userEmail,
        ]);
        $newUser = User::where(["email"=>$userEmail])->first();
        $newUser->deleted_at = now();
        $newUser->save();

        $userPassword = config("testing.user_password");

        $response = $this->withHeaders($this->headers)
            ->postJson(
                '/api/auth', 
                [
                    'email' => $userEmail,
                    'password' => $userPassword,
                ],
            );
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            "message" => __("response.login.invalid_credentials_error"),
        ]);
    }
}
