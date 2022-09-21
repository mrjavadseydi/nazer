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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('nationalityCode', 11);
            $table->string('fullName');
            $table->string('supportStatus');
            $table->string('phone', 15);
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->enum('paid_status', ['employedWithSalary', 'familyWithoutSalary'])->default('employedWithSalary');
            $table->boolean('is_insured')->default(false);
            $table->dateTime('start_date');
            $table->string('employer_status');
            $table->foreignId('plan_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('employers');
    }
};
