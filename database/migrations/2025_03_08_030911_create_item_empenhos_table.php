<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_empenhos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empenho_id')
                ->constrained('empenhos')
                ->onDelete('cascade'); // Garante que ao deletar um empenho, seus itens também sejam removidos
            $table->string('codigo_item');
            $table->string('descricao');
            $table->decimal('valor_atual', 10, 2);
            $table->integer('sequencial');
            $table->integer('quantidade')->nullable();
            $table->integer('quantidade_disponivel')->nullable();
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_empenhos');
    }
};
