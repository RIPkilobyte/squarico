<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('email')->unique();
            $table->enum('role', ['Admin', 'User'])->default('User');
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('phone')->nullable();
            $table->date('birth')->nullable();
            $table->string('nationality')->nullable();
            $table->boolean('deleted')->default(false);
            $table->string('password');

            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('house')->nullable();

            $table->integer('investment')->default(0);
            $table->text('notes')->nullable();
            $table->boolean('attention')->default(false);
            $table->boolean('approved')->default(false);
            $table->boolean('identity')->default(false);
            $table->enum('test', ['None', 'Tried', 'Passed'])->default('None');
            $table->enum('investor_type', ['none', 'self', 'certified', 'high'])->default('none');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
}
