<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoiceAuditPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voice_audit_points', function (Blueprint $table) {
            $table->id();
            $table->integer('datapoint_category_id');
            $table->integer('datapoint_id');
            $table->integer('voice_audit_id');
            $table->integer('custom_field_id');
            $table->integer('answer');
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
        Schema::dropIfExists('voice_audit_points');
    }
}
