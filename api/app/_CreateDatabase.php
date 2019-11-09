<?php
require_once(__DIR__.'/includes.php');

use Illuminate\Database\Capsule\Manager as Capsule;
if(!Capsule::schema()->hasTable('questions')) {
  Capsule::schema()->create('questions', function ($table) {
    $table->char('question_id',13)->primary();
    $table->char('category_id',13)->default(null)->nullable();
    $table->text('hint_1');
    $table->text('hint_2');
    $table->text('hint_3');
    $table->char('correct_answer_id',13)->default(null)->nullable();
    $table->integer('difficulty')->default(1);
    $table->timestamps();
  });
}
if(!Capsule::schema()->hasTable('answers')) {
  Capsule::schema()->create('answers', function ($table) {
    $table->char('answer_id',13)->primary();
    $table->char('question_id',13)->default(null)->nullable();
    $table->string('answer')->default('');
    $table->timestamps();
  });
}
if(!Capsule::schema()->hasTable('categories')) {
  Capsule::schema()->create('categories', function ($table) {
    $table->char('category_id',13)->primary();
    $table->string('name')->default('');
    $table->timestamps();
  });
}
if(!Capsule::schema()->hasTable('quiz')) {
  Capsule::schema()->create('quiz', function ($table) {
    $table->char('quiz_id',13)->primary();
    $table->string('name')->default('');
    $table->text('categories');
    $table->text('difficulty');
    $table->integer('question_count')->default(0);
    $table->integer('time')->default(0);
    $table->timestamps();
  });
}
?>
