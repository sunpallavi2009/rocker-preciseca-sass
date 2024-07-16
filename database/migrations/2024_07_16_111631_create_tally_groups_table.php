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
        Schema::create('tally_groups', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->unique();
            $table->string('name')->nullable();
            $table->string('parent')->nullable();
            $table->string('grp_debit_parent')->nullable();
            $table->string('grp_credit_parent')->nullable();
            $table->string('affects_stock')->nullable();
            $table->string('alter_id')->nullable();
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
        Schema::dropIfExists('tally_groups');
    }
};
