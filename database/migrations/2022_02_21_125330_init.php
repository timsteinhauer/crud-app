<?php

use App\Models\Basics\Salutation;
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
        $adminRole = Role::create(["name" => "Admin"]);
        $adminPermission = Permission::create(["name" => "do admin"]);
        $adminPermission->assignRole($adminRole);

        $customerRole = Role::create(["name" => "Kunde"]);
        $customerPermission = Permission::create(["name" => "do customer"]);
        $customerPermission->assignRole($customerRole);

        // insert default Users
        $users = [
            [
                "name" => "Tim Steinhauer",
                "email" => "t.steinhauer@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
                "roles" => ["Admin"],
            ],[
                "name" => "Max Muster",
                "email" => "maxmuster@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test1",
                "email" => "test1@high-office.com",
                "email_verified_at" => null,
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test2",
                "email" => "test2@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test3",
                "email" => "test3@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test4",
                "email" => "test4@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test5",
                "email" => "test5@high-office.com",
                "email_verified_at" => null,
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test6",
                "email" => "test6@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test7",
                "email" => "test7@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test8",
                "email" => "test8@high-office.com",
                "email_verified_at" => null,
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test9",
                "email" => "test9@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],[
                "name" => "Test10",
                "email" => "test10@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
            ],
        ];

        foreach ($users as $user){

            if( isset($user["roles"])){
                $roles = $user["roles"];
                unset($user["roles"]);
            }else{
                $roles = ["Kunde"];
            }

            $user = \App\Models\User::create($user);
            $user->update(["email_verified_at" => $user["email_verified_at"]]);

            foreach ($roles as $role){
                $user->assignRole($role);
            }
        }

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
