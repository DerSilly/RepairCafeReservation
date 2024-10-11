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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('repair_id');
            $table->date('repair_date');
            $table->integer('repair_cafe_number')->nullable();
            $table->string('repair_cafe_name')->nullable();
            $table->string('country');
            $table->string('kind_of_product')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->string('model_type_number')->nullable();
            $table->integer('year_of_production')->nullable();
            $table->text('problem_description')->nullable();
            $table->text('defect_found')->nullable();
            $table->boolean('has_been_repaired')->nullable();
            $table->text('repair_action')->nullable();
            $table->text('half_repair_action')->nullable();
            $table->text('not_repaired_reason_list')->nullable();
            $table->text('not_repaired_reason_open')->nullable();
            $table->integer('reparability')->nullable();
            $table->string('used_repair_information')->nullable();
            $table->string('repair_information_source')->nullable();
            $table->string('repair_information_url')->nullable();
            $table->text('suggestions_for_other_repairers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repairs');
    }
};
