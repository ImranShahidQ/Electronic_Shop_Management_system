<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('total_price', 10, 2)->default(0)->after('stock');
        });

        // Populate the total_price column for existing products
        $products = \App\Models\Product::all();
        foreach ($products as $product) {
            $product->total_price = $product->price * $product->stock;
            $product->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
};
