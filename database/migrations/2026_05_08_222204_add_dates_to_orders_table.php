<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'delivered_date')) {
                $table->timestamp('delivered_date')->nullable();
            }
            if (!Schema::hasColumn('orders', 'canceled_date')) {
                $table->timestamp('canceled_date')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivered_date', 'canceled_date']);
        });
    }
};
