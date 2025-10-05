<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->string('update_link')->nullable();
            $table->text('expectations_description')->nullable();
            $table->text('profit_description')->nullable();
            $table->date('start_at')->nullable();
            $table->date('deadline')->nullable();
            $table->integer('fts')->default(0);
            $table->integer('price')->default(0);
            $table->integer('profit')->default(0);
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('projects');
    }
}
