
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeildsToPlansTables2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->bigInteger('loan_amount')->nullable();
            $table->string('loan_time',100)->nullable();
            $table->bigInteger('installment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans_tables_2', function (Blueprint $table) {
            //
        });
    }
}
