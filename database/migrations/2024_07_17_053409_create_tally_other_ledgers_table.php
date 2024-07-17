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
        Schema::create('tally_other_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->unique();
            $table->string('currency_name')->nullable();
            $table->string('prior_state_name')->nullable();
            $table->string('income_tax_number')->nullable();
            $table->string('gst_registration_type')->nullable();
            $table->string('parent')->nullable();
            $table->string('tax_classification_name')->nullable();
            $table->string('tax_type')->nullable();
            $table->string('gst_type')->nullable();
            $table->string('appropriate_for')->nullable();
            $table->string('service_category')->nullable();
            $table->string('excise_ledger_classification')->nullable();
            $table->string('excise_duty_type')->nullable();
            $table->string('excise_nature_of_purchase')->nullable();
            $table->string('ledger_fbt_category')->nullable();
            $table->string('is_bill_wise_on')->nullable();
            $table->string('is_cost_centres_on')->nullable();
            $table->integer('alter_id')->nullable();
            $table->string('name')->nullable();
            $table->date('applicable_from')->nullable();
            $table->string('gstn_no')->nullable();
            $table->text('address')->nullable();
            $table->date('mailing_applicable_from')->nullable();
            $table->string('pincode')->nullable();
            $table->string('mailing_name')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
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
        Schema::dropIfExists('tally_other_ledgers');
    }
};
