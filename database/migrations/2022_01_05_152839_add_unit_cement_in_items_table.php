<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitCementInItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('product_unit', 50)->nullable()->default('')->after('quantity');
            $table->double('meter_square')->nullable()->default(0)->after('product_unit');
        });
        Schema::table('document_items', function (Blueprint $table) {
            $table->string('product_unit', 50)->nullable()->default('')->after('quantity');
            $table->double('meter_square')->nullable()->default(0)->after('product_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $dropColumn = function ($table, $column) {
            if (Schema::hasColumn($table, $column)) {
                Schema::dropColumns($table, $column);
            }
        };
        $dropColumn('items', 'product_unit');
        $dropColumn('items', 'amount_of_cement');
        $dropColumn('items', 'meter_square');

        $dropColumn('document_items', 'product_unit');
        $dropColumn('document_items', 'amount_of_cement');
        $dropColumn('document_items', 'meter_square');

    }
}
