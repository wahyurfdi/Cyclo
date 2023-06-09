<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrashTransactionItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trash_transaction_item', function (Blueprint $table) {
            $table->id();
            $table->string('trash_transaction_code', 32);
            $table->bigInteger('trash_type_id');
            $table->integer('qty')->default(0);
            $table->decimal('weight', 10, 2)->default(0);
            $table->integer('coin')->default(0);
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
        Schema::dropIfExists('trash_transaction_item');
    }
}
