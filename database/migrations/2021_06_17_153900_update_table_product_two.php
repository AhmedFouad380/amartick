<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableProductTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->after('id')->nullable()
                ->constrained('companies')
                ->onDelete('cascade');

            $table->string('unit_en')
                ->after('company_id')->default('piece');
            $table->string('unit_ar')
                ->after('unit_en')->default('قطعه');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');

    }
}
