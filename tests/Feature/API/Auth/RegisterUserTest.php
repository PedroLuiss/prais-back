<?php

namespace Tests\Feature\API\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    protected $headers = ['Content-Type' => 'application/json'];

    /**
     * A feature for the successful register response.
     */
    public function test_successful_register(): void
    {
        $this->seed();

        $userName = "New User";
        $userEmail = "newuser12111@doe.com";
        $userPassword = config("testing.user_password");

        $response = $this->withHeaders($this->headers)
            ->postJson(
                "/api/auth/register",
                [
                    "name" => $userName,
                    "email" => $userEmail,
                    "password" => $userPassword,
                ],
            );
        $response->assertCreated();
        $response->assertJsonFragment(["email" => $userEmail]);
        $response->assertJsonStructure([
            "data" => [
                "id",
                "name",
                "email",
                "createdAt",
                "updatedAt",
            ],
        ]);
    }

    /**
     * A feature for the validation error response.
     */
    public function test_validation_error(): void
    {
        $this->seed();

        $userEmail = "newuser12111@doe.com";
        $userPassword = config("testing.user_password");

        $response = $this->withHeaders($this->headers)
            ->postJson(
                "/api/auth/register",
                [
                    "email" => $userEmail,
                    "password" => $userPassword,
                ],
            );
        $response->assertBadRequest();
        $response->assertJsonFragment([
            "message" => __(
                "validation.required",
                ["attribute" => "name"],
            ),
        ]);
    }
}
