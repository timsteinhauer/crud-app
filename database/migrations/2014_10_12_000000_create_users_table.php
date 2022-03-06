<?php

use App\Models\Basics\Salutation;
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
            $table->unsignedBigInteger('customer_id')->nullable();

            $table->boolean('is_operator')->default(0);

            $table->tinyInteger('salutation_id')->default(1);
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        Schema::create('salutations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->string('sentence', 30);
        });


        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);

            $table->timestamps();
        });


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
