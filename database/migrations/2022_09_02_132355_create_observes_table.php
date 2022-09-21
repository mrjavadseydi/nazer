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
        Schema::create('observes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervisor_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('performer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('observe_date');
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
        Schema::dropIfExists('observes');
    }
};
