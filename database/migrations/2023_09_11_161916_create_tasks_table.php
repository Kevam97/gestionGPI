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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specific_objective_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('project_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->double('value');
            $table->time('start');
            $table->time('end');
            $table->json('documents')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
