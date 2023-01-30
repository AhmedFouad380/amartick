<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {

            $table->foreignId('country_id')->after('manager_id')->nullable()->constrained('countries')->onDelete('restrict');
            $table->foreignId('city_id')->after('country_id')->nullable()->constrained('cities')->onDelete('restrict');
            $table->string('flat_area')
                ->after('city_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');

    }
}
