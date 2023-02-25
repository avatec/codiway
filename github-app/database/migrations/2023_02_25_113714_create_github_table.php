<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('githubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->integer('forks')->nullable();
            $table->integer('stars')->nullable();
            $table->integer('watchers')->nullable();
            $table->dateTime('pull_request_date')->nullable();
            $table->dateTime('release_date')->nullable();
            $table->integer('open_pull_requests')->nullable();
            $table->integer('closed_pull_requests')->nullable();
            $table->dateTime('last_pull_merge_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('githubs');
    }
};
