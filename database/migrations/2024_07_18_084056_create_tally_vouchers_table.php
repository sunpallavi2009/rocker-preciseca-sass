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
        Schema::create('tally_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->unique();
            $table->string('company_guid')->nullable();
            $table->string('voucher_type')->nullable();
            $table->string('is_cancelled')->nullable();
            $table->string('alter_id')->nullable();
            $table->string('party_ledger_name')->nullable();
            $table->string('voucher_number')->nullable();
            $table->date('voucher_date')->nullable();
            $table->string('reference_no')->nullable();
            $table->date('reference_date')->nullable();
            $table->string('place_of_supply')->nullable();
            $table->string('country_of_residense')->nullable();
            $table->string('gst_registration_type')->nullable();
            $table->string('narration')->nullable();
            $table->string('cost_center_name')->nullable();
            $table->string('cost_center_amount')->nullable();
            $table->string('numbering_style')->nullable();
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
        Schema::dropIfExists('tally_vouchers');
    }
};
