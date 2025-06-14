<?php

use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)
                ->comment('pending= ' . TaskStatusEnum::PENDING->value . ', in_progress= ' . TaskStatusEnum::IN_PROGRESS->value .
                    ', completed= ' . TaskStatusEnum::COMPLETED->value . ', overdue= ' . TaskStatusEnum::OVERDUE->value);
            $table->tinyInteger('priority')->default(TaskStatusEnum::PENDING->value)->comment('low= ' . TaskPriorityEnum::LOW->value . ', medium= ' . TaskPriorityEnum::MEDIUM->value .
                ', high= ' . TaskPriorityEnum::HIGH->value);
            $table->timestamp('due_date');
            $table->softDeletes();
            $table->timestamps();

            // create indexes for columns that will be frequently queried to speed up sorting/filtering
            $table->index('status');
            $table->index('priority');
            $table->index('due_date');

            // create full-text index for title and description
            $table->fullText(['title', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
