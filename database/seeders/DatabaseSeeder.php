<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Regions;
use App\Models\Communes;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Regions::create(['description'=>'Noroeste']);
        Regions::create(['description'=>'Noreste']);
        Regions::create(['description'=>'Occidente']);

        Communes::create(['description'=>'Chihuahua', 'id_reg'=>1]);
        Communes::create(['description'=>'Sinaloa', 'id_reg'=>1]);
        Communes::create(['description'=>'Coahuila', 'id_reg'=>2]);
        Communes::create(['description'=>'Nuevo León', 'id_reg'=>2]);
        Communes::create(['description'=>'Jalisco', 'id_reg'=>3]);
        Communes::create(['description'=>'Michoacán', 'id_reg'=>3]);

        User::create([
            'name'=>'Test1',
            'email'=>'test@test1.com',
            'password'=> Hash::make('password') //password
        ]);

        $costumers=[
            [
                'dni'=>'30487115',
                'id_reg'=>1,
                'id_com'=>1,
                'email'=>'test1@customers.com',
                'name'=>fake()->name(),
                'last_name'=>fake()->lastName(),
                'address'=>fake()->address(),
                'date_reg'=>date_create(),
                'status'=>'A'
            ],
            [
                'dni'=>'30487116',
                'id_reg'=>1,
                'id_com'=>2,
                'email'=>'test2@customers.com',
                'name'=>fake()->name(),
                'last_name'=>fake()->lastName(),
                'address'=>fake()->address(),
                'date_reg'=>date_create(),
                'status'=>'A'
            ],
            [
                'dni'=>'30487117',
                'id_reg'=>2,
                'id_com'=>3,
                'email'=>'test3@customers.com',
                'name'=>fake()->name(),
                'last_name'=>fake()->lastName(),
                'address'=>fake()->address(),
                'date_reg'=>date_create(),
                'status'=>'I'
            ],
            [
                'dni'=>'30487118',
                'id_reg'=>3,
                'id_com'=>5,
                'email'=>'test4@customers.com',
                'name'=>fake()->name(),
                'last_name'=>fake()->lastName(),
                'address'=>fake()->address(),
                'date_reg'=>date_create(),
                'status'=>'trash'
            ]
        ];
        Customer::insert($costumers);

    }
}
