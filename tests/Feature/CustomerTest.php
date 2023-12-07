<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerTest extends TestCase {
    use RefreshDatabase;
    protected $seed = true;

    public function test_canot_access_index_without_token()
    {
        
        $response = $this->getJson(route('api.customer.index'));
        $response->assertStatus(401);
        $this->assertEquals($response->json(), "Unauthorized");
    }

    public function test_canot_access_store_without_token()
    {
        
        $response = $this->postJson(route('api.customer.store'));
        $response->assertStatus(401);
        $this->assertEquals($response->json(), "Unauthorized");
    }

    public function test_canot_access_destroy_without_token()
    {
        
        $response = $this->deleteJson(route('api.customer.del', ['customer'=>'30225155']),[]);
        $response->assertStatus(401);
        $this->assertEquals($response->json(), "Unauthorized");
    }

    public function test_get_user_can_access_index(){
        $this->getHeaders();
        $response = $this->getJson(route('api.customer.index'), $this->headers);
        $response->assertStatus(200);
        
        $this->assertEquals(2, count($response->json()));
        $this->assertArrayHasKey('name', $response->json()['customers'][0]);
        $this->assertArrayHasKey('last_name', $response->json()['customers'][0]);
        $this->assertArrayHasKey('address', $response->json()['customers'][0]);
        $this->assertArrayHasKey('communes', $response->json()['customers'][0]);
        $this->assertArrayHasKey('regions', $response->json()['customers'][0]);
        $this->assertArrayHasKey('description', $response->json()['customers'][0]['communes']);
        $this->assertArrayHasKey('description', $response->json()['customers'][0]['regions']);
        $this->assertEquals($response->json()['success'], true);
    }

    public function test_post_user_canot_create_customer_with_communes_and_regions_not_related(){
        $this->getHeaders();
        $data = [
            'dni'=>'30487119',
            'id_reg'=>1, 
            'id_com'=>4, //the correct communes is 1 and 2
            'email'=>'test4@customers.com',
            'name'=>fake()->name(),
            'last_name'=>fake()->lastName(),
            'address'=>fake()->address(),
            'date_reg'=>date_create()
        ];
        $response = $this->postJson(route('api.customer.store'), $data, $this->headers);
        $response->assertStatus(422);
        $this->assertEquals($response->json()['message'], "The selected id com is invalid.");
        $this->assertArrayHasKey("id_com", $response->json()['errors']);
    }

    public function test_post_user_canot_create_customer_with_communes_and_regions_unexist(){
        $this->getHeaders();
        $data = [
            'dni'=>'30487119',
            'id_reg'=>10,
            'id_com'=>22,//the correct communes is 1 and 2
            'email'=>'test4@customers.com',
            'name'=>fake()->name(),
            'last_name'=>fake()->lastName(),
            'address'=>fake()->address(),
            'date_reg'=>date_create()
        ];
        $response = $this->postJson(route('api.customer.store'), $data, $this->headers);
        $response->assertStatus(422);
        $this->assertEquals($response->json()['message'], "The selected id reg is invalid. (and 1 more error)");
        $this->assertArrayHasKey("id_reg", $response->json()['errors']);
        $this->assertArrayHasKey("id_com", $response->json()['errors']);
        $this->assertEquals($response->json()['errors']["id_reg"][0], "The selected id reg is invalid.");
        $this->assertEquals($response->json()['errors']["id_com"][0], "The selected id com is invalid.");
    }

    public function test_post_user_canot_create_customer_with_wrong_data(){
        $this->getHeaders();
        $data = [
            'dni'=>'30487119',
            'id_reg'=>1, 
            'id_com'=>2,//the correct communes is 1 and 2
            'email'=>'test4customers.com',
            'name'=>'pedro prueba1 d cdsdedddcfdk cjdfffkfffk cddddkfk ckfffkdddk cdkffkf kddskdk fe',
            'last_name'=>'armando  d cdsdedddcfdk cjdfffkfffk cddddkfk ckfffkdddk cdkffkf kddskdk fe eeddds',
            'address'=>'av. libertador',
        ];
        $response = $this->postJson(route('api.customer.store'), $data, $this->headers);
        $response->assertStatus(422);
        $this->assertEquals($response->json()['message'], "The email field must be a valid email address. (and 2 more errors)");
        $this->assertArrayHasKey("email", $response->json()['errors']);
        $this->assertArrayHasKey("name", $response->json()['errors']);
        $this->assertArrayHasKey("last_name", $response->json()['errors']);
        $this->assertEquals($response->json()['errors']["email"][0], "The email field must be a valid email address.");
        $this->assertEquals($response->json()['errors']["name"][0], "The name field must not be greater than 45 characters.");
        $this->assertEquals($response->json()['errors']["last_name"][0], "The last name field must not be greater than 45 characters.");
        
    }

    public function test_post_user_canot_create_customer_with_empty_data(){
        $this->getHeaders();
        $data = [];
        $response = $this->postJson(route('api.customer.store'), $data, $this->headers);
        $response->assertStatus(422);
        $this->assertEquals($response->json()['message'], "The dni field is required. (and 6 more errors)");
        $this->assertArrayHasKey("dni", $response->json()['errors']);
        $this->assertArrayHasKey("name", $response->json()['errors']);
        $this->assertArrayHasKey("last_name", $response->json()['errors']);
        $this->assertArrayHasKey("email", $response->json()['errors']);
        $this->assertArrayHasKey("id_reg", $response->json()['errors']);
        $this->assertArrayHasKey("id_com", $response->json()['errors']);
        $this->assertArrayHasKey("address", $response->json()['errors']);
    }

    public function test_post_user_can_create_customer(){
        $this->getHeaders();
        $data = [
            'dni'=>'30487119',
            'id_reg'=>1, 
            'id_com'=>2,//the correct communes is 1 and 2
            'email'=>'test5@customers.com',
            'name'=>'pedro post',
            'last_name'=>'armando',
            'address'=>'av. libertador 544',
        ];
        $response = $this->postJson(route('api.customer.store'), $data, $this->headers);
        $response->assertStatus(201);
       //dd($response->json());
        $this->assertEquals($response->json()['customer']['dni'], '30487119');
        $this->assertEquals($response->json()['success'], true);
    }

    public function test_delete_user_can_not_delete_a_record_that_does_not_exist(){
        $this->getHeaders();
        $response = $this->deleteJson(route('api.customer.del', ['customer'=>'30225155']),[], $this->headers);
        $this->assertEquals($response->json()['message'], "Record does not exist");
        $this->assertEquals($response->json()['success'], false);
        $response->assertStatus(404);

    }

    public function test_delete_user_can_not_delete_with_status_trash(){
        $this->getHeaders();
        $response = $this->deleteJson(route('api.customer.del', ['customer'=>'30487118']),[], $this->headers);
        $this->assertEquals($response->json()['message'], "Record does not exist");
        $this->assertEquals($response->json()['success'], false);
        $response->assertStatus(404);

    }

    public function test_delete_user_can_delete_a_record_active(){
        $this->getHeaders();
        $response = $this->deleteJson(route('api.customer.del', ['customer'=>'30487116']),[], $this->headers);
        $this->assertEquals($response->json()['message'], "Deleted record");
        $this->assertEquals($response->json()['success'], true);
        $response->assertStatus(200);

    }

    public function test_get_user_can_not_access_with_expire_token(){
        $header = [
            'Authorization' => 'Bearer eyJpbmZvIjp7ImVtYWlsIjoidGVzdEB0ZXN0MS5jb20iLCJzZXNzaW9uIjp7ImRhdGUiOiIyMDIzLTEyLTA2IDAzOjA0OjU4Ljk1ODEwMCIsInRpbWV6b25lX3R5cGUiOjMsInRpbWV6b25lIjoiVVRDIn0sInJhbmRvbSI6MzE3fSwiZXhwaXJhdGlvbiI6MTcwMTgzNTQ5OH0=.210c9ad9545ee25b0189fc735a825b5b879abf90',
            'X-Api-Key'=>['xheehwb-dnsjna1-c0djedd']
        ];

        $response = $this->getJson(route('api.customer.index'), $header);
        $response->assertStatus(401);
        $this->assertEquals($response->json()['message'], "Expired token");
    }

    public function test_get_user_can_not_access_with_ivalid_token(){
        $header = [
            'Authorization' => 'Bearer eyJpbmZvIjp7ImVtYWlsIjoidGVzdEB0ZXN0MS5eg20iLCJzZXNzaW9uIjp7ImRhdGUiOiIyMDIzLTEyLTA2IDAzOjA0OjU4Ljk1ODEwMCIsInRpbWV6b25lX3R5cGUiOjMsInRpbWV6b25lIjoiVVRDIn0sInJhbmRvbSI6MzE3fSwiZXhwaXJhdGlvbiI6MTcwMTgzNTQ5OH0=.210c9ad9545ee25b0189fc735a825b5b879abf90',
            'X-Api-Key'=>['xheehwb-dnsjna1-c0djedd']
        ];

        $response = $this->getJson(route('api.customer.index'), $header);
        $response->assertStatus(401);
        $this->assertEquals($response->json()['message'], "Invalid token");
    }
}