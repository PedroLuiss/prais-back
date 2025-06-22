<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $headers = ['Content-Type' => 'application/json'];

    /**
     * A feature test for successful get user response.
     */
    public function test_successful_get_user(): void
    {
        $this->seed();

        $userEmail = config("testing.user_email");
        $user = User::where("email", $userEmail)
            ->firstOrFail();
        Sanctum::actingAs($user);

        $response = $this->withHeaders($this->headers)
            ->getJson("/api/user");
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => [
                "id",
                "name",
                "email",
                "createdAt",
                "updatedAt",
            ]
        ]);
    }

    /**
     * A feature test for unauthorized get user error response.
     */
    public function test_unauthorized_get_user_error(): void
    {
        $response = $this->withHeaders($this->headers)
            ->getJson("/api/user");
        $response->assertUnauthorized();
        $response->assertJsonFragment([
            "message" => "Unauthenticated.",
        ]);
    }

    /**
     * A feature test for successful update user response.
     */
    public function test_successful_update_user(): void
    {
        $this->seed();

        $userEmail = config("testing.user_email");
        $user = User::where("email", $userEmail)
            ->firstOrFail();
        Sanctum::actingAs($user);

        $newUserName = "Peter Parker";

        $response = $this->withHeaders($this->headers)
            ->patchJson(
                "/api/user",
                [
                    "name" => $newUserName,
                ]
            );
        $response->assertOk();
        $response->assertJsonFragment(["name" => $newUserName]);
        $response->assertJsonStructure([
            "data" => [
                "id",
                "name",
                "email",
                "createdAt",
                "updatedAt",
            ]
        ]);
    }

    /**
     * A feature test for unauthorized update user error response.
     */
    public function test_unauthorized_update_user_error(): void
    {
        $response = $this->withHeaders($this->headers)
            ->patchJson("/api/user");
        $response->assertUnauthorized();
        $response->assertJsonFragment([
            "message" => "Unauthenticated.",
        ]);
    }

    /**
     * A feature test for validation update user error response.
     */
    public function test_validation_update_user_error(): void
    {
        $this->seed();

        $userEmail = config("testing.user_email");
        $user = User::where("email", $userEmail)
            ->firstOrFail();
        Sanctum::actingAs($user);

        $newUserName = "Pe";

        $response = $this->withHeaders($this->headers)
            ->patchJson(
                "/api/user",
                [
                    "name" => $newUserName,
                ]
            );
        $response->assertBadRequest();
        $response->assertJsonFragment([
            "message" => __(
                "validation.min.string",
                ["attribute" => "name", "min" => 3],
            ),
        ]);
    }

    /**
     * A feature test for taken_email update user error response.
     */
    public function test_taken_email_update_user_error(): void
    {
        $this->seed();

        $userEmail = config("testing.user_email");
        $user = User::where("email", $userEmail)
            ->firstOrFail();
        Sanctum::actingAs($user);

        $takenEmail = "takenemail@doe.com";
        User::factory()->create(["email" => $takenEmail]);

        $response = $this->withHeaders($this->headers)
            ->patchJson(
                "/api/user",
                [
                    "email" => $takenEmail,
                ]
            );
        $response->assertBadRequest();
        $response->assertJsonFragment([
            "message" => __(
                "validation.exists",
                ["attribute" => "email"],
            ),
        ]);
    }

    /**
     * A feature test for successful delete user response.
     */
    public function test_successful_delete_user(): void
    {
        $this->seed();

        $userEmail = config("testing.user_email");
        $user = User::where("email", $userEmail)
            ->firstOrFail();
        Sanctum::actingAs($user);

        $response = $this->withHeaders($this->headers)
            ->deleteJson("/api/user");
        $response->assertOk();
        $response->assertJsonFragment([
            "message" => __("response.user.delete_user_success"),
        ]);

        $this->assertNotEquals($user->deleted_at, null);
    }

    /**
     * A feature test for unauthorized delete user error response.
     */
    public function test_unauthorized_delete_user_error(): void
    {
        $response = $this->withHeaders($this->headers)
            ->deleteJson("/api/user");
        $response->assertUnauthorized();
        $response->assertJsonFragment([
            "message" => "Unauthenticated.",
        ]);
    }
}
