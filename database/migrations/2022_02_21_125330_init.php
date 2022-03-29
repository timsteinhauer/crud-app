<?php

use App\Models\Basics\Salutation;
use App\Models\Customer\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Salutation::insert([
            ["name" => "Herr", "sentence" => "Sehr geehrter Herr"],
            ["name" => "Frau", "sentence" => "Sehr geehrte Frau"],
            ["name" => "Diverse", "sentence" => "Guten Tag"],
        ]);


        //
        // https://spatie.be/docs/laravel-permission/v5/basic-usage/basic-usage
        //
        $adminRole = Role::create(["name" => "Admin", "is_operator_role" => 1]);
        $adminPermission = Permission::create(["name" => "manage admin stuff"]);
        $adminPermission->assignRole($adminRole);

        $customerRole = Role::create(["name" => "Benutzerverwaltung"]);
        $customerPermission = Permission::create(["name" => "manage customer users"]);
        $customerPermission->assignRole($customerRole);

        //
        // insert default Users
        //
        $users = [
            [
                "name" => "Tim Steinhauer",
                "email" => "t.steinhauer@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
                "is_operator" => 1,
                "roles" => ["Admin"],
            ],[
                "name" => "Kunde Muster",
                "email" => "kunde@high-office.com",
                "email_verified_at" => now(),
                "customer_id" => 1,
                "roles" => ["Benutzerverwaltung"],
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test1",
                "email" => "test1@high-office.com",
                "email_verified_at" => null,
                "customer_id" => 2,
                "roles" => ["Benutzerverwaltung"],
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test2",
                "email" => "test2@high-office.com",
                "email_verified_at" => now(),
                "customer_id" => 3,
                "roles" => ["Benutzerverwaltung"],
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test3",
                "email" => "test3@high-office.com",
                "email_verified_at" => now(),
                "customer_id" => 1,
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test4",
                "email" => "test4@high-office.com",
                "email_verified_at" => now(),
                "customer_id" => 2,
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test5",
                "email" => "test5@high-office.com",
                "email_verified_at" => null,
                "customer_id" => 3,
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test6",
                "email" => "test6@high-office.com",
                "email_verified_at" => now(),
                "customer_id" => 1,
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test7",
                "email" => "test7@high-office.com",
                "email_verified_at" => now(),
                "customer_id" => 2,
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test8",
                "email" => "test8@high-office.com",
                "email_verified_at" => null,
                "customer_id" => 3,
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test9",
                "email" => "test9@high-office.com",
                "email_verified_at" => now(),
                "customer_id" => 1,
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],[
                "name" => "Test10",
                "email" => "test10@high-office.com",
                "email_verified_at" => now(),
                "customer_id" => 2,
                "password" => \Illuminate\Support\Facades\Hash::make("12345Crud!!!"),
            ],
        ];

        foreach ($users as $user){

            if( isset($user["roles"])){
                $roles = $user["roles"];
                unset($user["roles"]);
            }else{
                $roles = [];
            }

            $user = \App\Models\User::create($user);
            $user->update(["email_verified_at" => $user["email_verified_at"]]);

            foreach ($roles as $role){
                $user->assignRole($role);
            }
        }


        //
        // add default Customers
        //
        $customer1 = Customer::create(["name" => "Kunde 1", "created_at" => now(), "updated_at" => now()]);
        $customer2 = Customer::create(["name" => "Kunde 2", "created_at" => now(), "updated_at" => now()]);
        $customer3 = Customer::create(["name" => "Kunde 3", "created_at" => now(), "updated_at" => now()]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
