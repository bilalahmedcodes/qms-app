<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('datapoint_category_id');
            $table->integer('datapoint_id');
            $table->string('label');
            $table->string('placeholder')->nullable();
            $table->enum('type', ['text', 'dropdown', 'radio', 'checkbox', 'textarea']);
            $table->longText('options')->nullable();
            $table->longText('values')->nullable();
            $table->enum('required', ['yes', 'no'])->default('yes');
            $table->integer('added_by');
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
        Schema::dropIfExists('custom_fields');
    }
}
