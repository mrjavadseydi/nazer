<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalItemValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_item_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\PhysicalItems::class)->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Plan::class)->cascadeOnDelete();
            $table->string('value');
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
        Schema::dropIfExists('phyical_item_values');
    }
}
