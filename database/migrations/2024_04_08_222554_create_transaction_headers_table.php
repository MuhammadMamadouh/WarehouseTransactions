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
        Schema::create('transaction_headers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('transaction_date');
            $table->string('document_no');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('from_warehouse_id');
            $table->unsignedBigInteger('to_warehouse_id');
            $table->unsignedBigInteger('journal_entry_id');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('from_warehouse_id')->references('id')->on('warehouses');
            $table->foreign('to_warehouse_id')->references('id')->on('warehouses');
            $table->integer('total_price');
            $table->integer('total_discount');
            $table->integer('total_payment');
            $table->integer('total_change');
            $table->string('note');
            $table->tinyInteger('transaction_type');
            $table->foreign('journal_entry_id')->references('id')->on('journal_entry_headers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_headers');
    }
};
