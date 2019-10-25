<?php
require_once(__DIR__.'/includes.php');

use Illuminate\Database\Capsule\Manager as Capsule;
Capsule::schema()->create('questions', function ($table) {
  $table->char('question_id',13)->primary();
  $table->char('category_id',13)->default(null)->nullable();
  $table->text('hint_1');
  $table->text('hint_2');
  $table->text('hint_3');
  $table->char('correct_answer_id',13)->default(null)->nullable();
  $table->timestamps();
});

Capsule::schema()->create('answers', function ($table) {
  $table->char('answer_id',13)->primary();
  $table->char('question_id',13)->default(null)->nullable();
  $table->string('answer')->default('');
  $table->timestamps();
});

Capsule::schema()->create('categories', function ($table) {
  $table->char('category_id',13)->primary();
  $table->string('name')->default('');
  $table->timestamps();
});

?>
