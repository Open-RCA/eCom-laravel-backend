<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $PRODUCT_STATUS_ENUM = [
        'ACTIVE' => "ACTIVE",
        'INACTIVE' => "INACTIVE"
        ];

        Schema::create('products', function (Blueprint $table) use ($PRODUCT_STATUS_ENUM) {
            $table->id();
            $table->string('name', 50);
            $table->foreign('product_sub_category_id')->references('id')->on('product_sub_categories')->onDelete('cascade');
            $table->integer('unit_price');
            $table->integer('quantity');
            $table->enum('status', $PRODUCT_STATUS_ENUM)->default($PRODUCT_STATUS_ENUM['ACTIVE']);
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
        Schema::dropIfExists('products');
    }
}
