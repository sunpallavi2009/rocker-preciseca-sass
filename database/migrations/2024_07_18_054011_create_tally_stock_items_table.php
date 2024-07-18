<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tally_stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->unique();
            $table->string('parent')->nullable();
            $table->string('category')->nullable();
            $table->string('gst_applicable')->nullable();
            $table->string('tax_classification_name')->nullable();
            $table->string('gst_type_of_supply')->nullable();
            $table->string('excise_applicability')->nullable();
            $table->string('vat_applicable')->nullable();
            $table->string('costing_method')->nullable();
            $table->string('valuation_method')->nullable();
            $table->string('base_units')->nullable();
            $table->string('additional_units')->nullable();
            $table->string('excise_item_classification')->nullable();
            $table->string('vat_base_unit')->nullable();
            $table->string('is_cost_centres_on')->nullable();
            $table->string('is_batch_wise_on')->nullable();
            $table->integer('alter_id')->nullable();
            $table->string('opening_balance')->nullable();
            $table->double('opening_value')->nullable();
            $table->string('opening_rate')->nullable();
            $table->json('gst_details')->nullable();
            $table->json('hsn_details')->nullable();
            $table->string('language_name')->nullable();
            $table->string('language_id')->nullable();
            $table->json('batch_allocations')->nullable();
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
        Schema::dropIfExists('tally_stock_items');
    }
};
