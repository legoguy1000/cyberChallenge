<?php
require_once(__DIR__.'/includes.php');

use Illuminate\Database\Capsule\Manager as Capsule;
Capsule::schema()->create('questions', function ($table) {
  $table->char('question_id',13)->primary();
  $table->char('category_id',13)->default(null)->nullable();
  $table->text('hint_1')->default('');
  $table->text('hint_2')->default('');
  $table->text('hint_3')->default('');
  $table->string('answer_a')->default('');
  $table->string('answer_b')->default('');
  $table->string('answer_c')->default('');
  $table->string('answer_d')->default('');
  $table->string('correct_answer')->default('');
  $table->timestamps();
});

Capsule::schema()->create('question_categories', function ($table) {
  $table->char('catagory_id',13)->primary();
  $table->string('name')->default('');
  $table->timestamps();
});

?>
