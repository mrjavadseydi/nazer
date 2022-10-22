<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeildsToBankBranche extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_branches', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\City::class)->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->string('boss_name')->nullable();
            $table->string('boss_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_branche', function (Blueprint $table) {
            //
        });
    }
}
