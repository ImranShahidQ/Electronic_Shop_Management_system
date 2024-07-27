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
        Schema::table('sales', function (Blueprint $table) {
            $table->string('customer_name')->nullable();
            $table->decimal('pay_price', 10, 2)->default(0);
            $table->decimal('due_price', 10, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'pay_price', 'due_price']);
        });
    }
};
