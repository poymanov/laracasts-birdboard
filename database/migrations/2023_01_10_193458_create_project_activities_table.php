<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = [
            'create_project',
            'update_project_title',
            'update_project_description',
            'update_project_notes',
            'create_task',
            'update_task',
            'complete_task',
            'incomplete_task',
            'new_member',
            'delete_member',
        ];

        Schema::create('project_activities', function (Blueprint $table) use ($types) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('project_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type', $types);
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
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
        Schema::dropIfExists('project_activities');
    }
};
