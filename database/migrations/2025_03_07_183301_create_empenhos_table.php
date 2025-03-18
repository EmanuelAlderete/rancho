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
        Schema::create('empenhos', function (Blueprint $table) {
            $table->id();  // Chave primária
            $table->date('data');  // Data do empenho
            $table->string('documento')->unique();  // Número completo do documento
            $table->string('documento_resumido')->nullable();  // Versão curta do documento
            $table->text('observacao')->nullable();  // Descrição detalhada
            $table->decimal('valor', 15, 2);  // Valor do empenho
            $table->timestamps();  // Campos created_at e updated_at
            $table->foreignId('fornecedor_id')->constrained('fornecedores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empenhos');
    }
};
