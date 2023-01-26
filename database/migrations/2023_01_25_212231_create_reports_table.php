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
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('reportable');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_resolved')->default(false);
            $table->string('subject');
            $table->text('reason');
            $table->string('collection_name')->default('default');

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
        Schema::dropIfExists('reports');
    }
};
