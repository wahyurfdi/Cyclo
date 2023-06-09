<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrashTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trash_transaction', function (Blueprint $table) {
            $table->string('code', 32)->primary();
            $table->bigInteger('customer_id');
            $table->string('pickup_name', 64);
            $table->string('pickup_telp', 16);
            $table->text('pickup_address');
            $table->string('pickup_location_detail', 64)->nullable();
            $table->string('status_code', 64);
            $table->integer('total_qty')->default(0);
            $table->decimal('total_weight', 10, 2)->default(0);
            $table->integer('total_coin')->default(0);
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
        Schema::dropIfExists('trash_transaction');
    }
}
