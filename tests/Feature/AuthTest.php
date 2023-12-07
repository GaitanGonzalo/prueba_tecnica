<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase {
    use RefreshDatabase;
    protected $seed = true;

    public function test_login_with_password_empty()
    {
        $data = [
            'email'=>'test@test1.com'
        ];
        $response = $this->postJson(route('api.login'), $data);
        $response->assertStatus(422);
        $this->assertEquals($response->json()['message'], "The password field is required.");
        $this->assertArrayHasKey("password", $response->json()['errors']);
    }

    public function test_login_with_wrong_password()
    {
        $data = [
            'email'=>'test@test1.com',
            'password'=>'pepito123'
        ];
        $response = $this->postJson(route('api.login'), $data);
        $response->assertStatus(400);
        $this->assertEquals($response->json()['message'], "Invalid credentials");
    }

    public function test_login_with_email_empty()
    {
        $data = [
            'password'=>'password'
        ];
        $response = $this->postJson(route('api.login'), $data);
        $response->assertStatus(422);
        $this->assertEquals($response->json()['message'], "The email field is required.");
        $this->assertArrayHasKey("email", $response->json()['errors']);
    }
    public function test_login_with_wrong_email()
    {
        $data = [
            'email'=>'test@test4.com',
            'password'=>'password'
        ];
        $response = $this->postJson(route('api.login'), $data);
        $response->assertStatus(400);
        $this->assertEquals($response->json()['message'], "Invalid credentials");
    }

    public function test_login_with_empty_data()
    {
        $response = $this->postJson(route('api.login'));
        $response->assertStatus(422);
        $this->assertArrayHasKey("email", $response->json()['errors']);
        $this->assertArrayHasKey("password", $response->json()['errors']);
    }

    public function test_login_with_inyection_sql()
    {
        $data = [
            'email'=>'´OR 1=1;/*',
            'password'=>'*/--'
        ];
        $response = $this->postJson(route('api.login'), $data);
        $response->assertStatus(422);
        $this->assertEquals($response->json()['message'], "The email field must be a valid email address.");
        $this->assertArrayHasKey("email", $response->json()['errors']);
    }

    public function test_login_with_rigth_data()
    {
        $data = [
            'email'=>'test@test1.com',
            'password'=>'password'
        ];
        $response = $this->postJson(route('api.login'), $data);
        $response->assertStatus(200);
        $this->assertArrayHasKey("access_token", $response->json());
    }
}