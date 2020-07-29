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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('min_price')->default(0);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_deleted')->default(false); //Лучше разделить эти объекты, потому как объект не удаляется и может использоваться повторно, либо на реализация может быть изменена на подключение сущности статусов
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
