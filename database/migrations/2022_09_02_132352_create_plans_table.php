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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('level')->nullable();
            $table->enum('status', ['اجرا نشده', 'جاری', 'جمع آوری شده', 'راکد'])->nullable();
            $table->json('tags')->nullable();
            $table->integer('distance')->nullable();
            $table->text('address')->nullable();
            $table->text('address2')->nullable();
            $table->string('area')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->dateTime('last_observe_date')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->enum('implement_method', ['هدایت شغلی', 'راهبری شغلی']);
            $table->enum('self_sufficiency_status', ['خودکفا شده', 'خودکفا نشده'])->nullable();
            $table->boolean('is_special')->default(false);
            $table->text('special_reason')->nullable();
            $table->boolean('is_exhibition')->default(false);
            $table->enum('exhibition_level', ['شهرستانی', 'استانی', 'کشوری'])->nullable();
            $table->enum('exhibition_desire', ['کم', 'متوسط', 'زیاد'])->nullable();
            $table->boolean('has_employment')->default(false);
            $table->foreignId('organization_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('performer_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('plans');
    }
};
