<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatapointCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datapoint_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_id');
            $table->integer('project_id');
            $table->string('name');
            $table->enum('status', ['active', 'disable'])->default('active');
            $table->integer('added_by')->default(123456);
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('datapoint_categories');
    }
}
