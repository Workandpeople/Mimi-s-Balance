<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('role', ['candidate', 'enterprise'])->default('candidate');
            $table->string('name');
            $table->string('firstname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->longText('profile_photo')->nullable();
            $table->longText('profile_banner')->nullable();
            $table->string('cv')->nullable();
            $table->text('about')->nullable();
            $table->integer('expected_salary')->nullable();
            $table->string('company_name')->nullable();
            $table->string('siret')->nullable();
            $table->text('recruitment_description')->nullable();
            $table->text('team_description')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
