<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoiceAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voice_audits', function (Blueprint $table) {
            $table->id();
            $table->integer('associate_id');
            $table->integer('team_lead_id');
            $table->integer('manager_id');
            $table->integer('campaign_id');
            $table->integer('project_id');
            $table->integer('user_id');
            $table->integer('percentage');
            $table->date('call_date')->nullable();
            $table->string('customer_name')->nullable();
            $table->bigInteger('customer_phone')->nullable();
            $table->integer('record_id')->nullable();
            $table->string('recording_link')->nullable();
            $table->time('recording_duration')->nullable();
            $table->enum('client_outcome', ['accepted', 'rejected', 'not applicable'])->default('not applicable');
            $table->enum('agent_outcome', ['accepted', 'rejected', 'not applicable'])->default('not applicable');
            $table->longText('notes')->nullable();
            $table->enum('critical_alert', ['0', '1'])->default('0');
            $table->enum('status', ['evaluated', 'appeal requested', 'appeal accepted', 'appeal rejected', 'action taken', 'assigned to team lead', 'no recording found'])->default('evaluated');
            $table->enum('call_type', ['general', 'sales', 'not applicable'])->default('not applicable');
            $table->time('evaluation_time');
            $table->date('audit_date')->nullable();
            $table->date('chat_date')->nullable();
            $table->longText('customer_feedback')->nullable();
            $table->time('start_time')->nullable();
            $table->string('queue')->nullable();
            $table->string('agent_group')->nullable();
            $table->string('caller_id')->nullable();
            $table->string('ast_clid')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('chat_id')->nullable();
            $table->string('call_detail')->nullable();
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
        Schema::dropIfExists('voice_audits');
    }
}
