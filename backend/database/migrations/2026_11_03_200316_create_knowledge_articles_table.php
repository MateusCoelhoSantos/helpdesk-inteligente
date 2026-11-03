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
        Schema::create('knowledge_articles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('ticket_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');

            $table->text('problem');

            $table->text('cause');

            $table->text('solution');

            $table->text('prevention');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_articles');
    }
};
