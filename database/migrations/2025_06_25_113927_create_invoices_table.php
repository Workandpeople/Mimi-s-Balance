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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename');           // Nom ou chemin du fichier PDF
            $table->string('original_name');      // Nom d’origine de l’upload
            $table->decimal('amount', 10, 2);     // Montant total de la facture
            $table->date('invoice_date');         // Date de la facture
            $table->string('merchant')->nullable(); // Nom du commerçant
            $table->foreignUuid('card_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
