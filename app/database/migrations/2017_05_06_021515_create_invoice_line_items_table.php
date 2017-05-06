<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_line_items', function (Blueprint $table) {

          $table->uuid('id');
          $table->uuid('invoice_id');
          $table->integer('row_order');
          $table->uuid('item_id');
          $table->string('description')->nullable();
          $table->integer('quantity')->default(1);
          $table->decimal('unit_price', 11, 2);
          $table->float('discount_rate')->nullable();
          $table->uuid('tax_rate_id');
          $table->timestamps();
          $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_line_items');
    }
}
