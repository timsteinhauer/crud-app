<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });

        // insert default Users
        $users = [
            [
                "name" => "Tim Steinhauer",
                "email" => "t.steinhauer@high-office.com",
                "email_verified_at" => now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20948Crud!_*"),
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

            $user = \App\Models\User::create($user);
            $user->update(["email_verified_at" => $user["email_verified_at"]]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
