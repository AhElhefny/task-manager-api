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
                ->comment('pending= ' . TaskStatusEnum::PENDING . ', in_progress= ' . TaskStatusEnum::IN_PROGRESS .
                    ', completed= ' . TaskStatusEnum::COMPLETED . ', overdue= ' . TaskStatusEnum::OVERDUE);
            $table->tinyInteger('priority')->default(1)->comment('low= ' . TaskPriorityEnum::LOW . ', medium= ' . TaskPriorityEnum::MEDIUM .
                ', high= ' . TaskPriorityEnum::HIGH);
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
