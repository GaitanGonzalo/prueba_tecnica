<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $token;
    protected $headers;

    public function getToken():String {
        $data = [
            'email'=>'test@test1.com',
            'password'=>'password'
        ];
        $response = $this->postJson(route('api.login'), $data);
        $access_token = $response->json()['access_token'];
        return $access_token;
    }

    public function getHeaders()
    {
        $this->token = $this->getToken();
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'X-Api-Key'=>'xheehwb-dnsjna1-c0djedd'
        ];
    }
}
