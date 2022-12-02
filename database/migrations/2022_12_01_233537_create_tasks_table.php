<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->date('task_date');
            $table->string('vehicle_registration', 50);
            $table->string('trailer_registration', 50)->nullable();
            $table->integer('job_type_id');
            $table->integer('partner_id');
            $table->integer('product_id');
            $table->integer('department_id');
            $table->string('id_card', 15);
            $table->enum('prefix', ['MR','MS','MRS'])->default('MR');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->longText('qr_code')->nullable();
            $table->smallInteger('is_active')->default(1)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
