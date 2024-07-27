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
            $table->date('date')->nullable()->after('total_price');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->date('date')->nullable()->after('total_price');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
};
