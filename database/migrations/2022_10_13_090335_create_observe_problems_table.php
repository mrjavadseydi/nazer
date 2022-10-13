<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObserveProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observe_problems', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Problem::class)->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Observe::class)->cascadeOnDelete();
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
        Schema::dropIfExists('observe_problems');
    }
}
