<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->contrained()->onDelete('SET NULL')->comment('业主ID');
            $table->foreignId('contract_id')->nullable()->constrained()->onDelete('SET NULL')->comment('所属合同');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('SET NULL')->comment('操作人');
            $table->decimal('payment', 22, 2)->comment('本次缴费');
            $table->decimal('before_pay', 22, 2)->comment('缴费前差款');
            $table->decimal('after_pay', 22, 2)->comment('缴费后差款');
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
        Schema::dropIfExists('contract_records');
    }
}
