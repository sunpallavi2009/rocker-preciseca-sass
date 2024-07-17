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
        Schema::create('tally_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->unique();
            $table->string('currency_name')->nullable();
            $table->string('prior_state_name')->nullable();
            $table->string('income_tax_number')->nullable();
            $table->string('parent')->nullable();
            $table->string('tcs_applicable')->nullable();
            $table->string('tax_classification_name')->nullable();
            $table->string('tax_type')->nullable();
            $table->string('country_of_residence')->nullable();
            $table->integer('ledger_country_isd_code')->nullable();
            $table->string('gst_type')->nullable();
            $table->string('appropriate_for')->nullable();
            $table->string('gst_nature_of_supply')->nullable();
            $table->string('service_category')->nullable();
            $table->string('party_business_style')->nullable();
            $table->string('is_bill_wise_on')->nullable();
            $table->string('is_cost_centres_on')->nullable();
            $table->integer('alter_id')->nullable();
            $table->integer('opening_balance')->nullable();
            $table->string('language_name')->nullable();
            $table->integer('language_id')->nullable();
            $table->date('applicable_from')->nullable();
            $table->string('mailing_name')->nullable();
            $table->string('address')->nullable();
            $table->integer('pincode')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->date('gst_applicable_from')->nullable();
            $table->string('src_of_gst_details')->nullable();
            $table->string('gst_calc_slab_on_mrp')->nullable();
            $table->string('is_reverse_charge_applicable')->nullable();
            $table->string('is_non_gst_goods')->nullable();
            $table->string('gst_ineligible_itc')->nullable();
            $table->string('include_exp_for_slab_calc')->nullable();
            $table->json('gst_rate_details')->nullable();
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
        Schema::dropIfExists('tally_ledgers');
    }
};
