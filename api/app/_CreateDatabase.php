<?php
require_once(__DIR__.'/includes.php');

use Illuminate\Database\Capsule\Manager as Capsule;
Capsule::schema()->create('questions', function ($table) {
  $table->char('question_id',13)->primary();
  $table->char('category_id',13)->default(null)->nullable();
  $table->text('hint_1');
  $table->text('hint_2');
  $table->text('hint_3');
  $table->string('answer_a')->default('');
  $table->string('answer_b')->default('');
  $table->string('answer_c')->default('');
  $table->string('answer_d')->default('');
  $table->string('correct_answer')->default('');
  $table->timestamps();
});

Capsule::schema()->create('question_categories', function ($table) {
  $table->char('category_id',13)->primary();
  $table->string('name')->default('');
  $table->timestamps();
});

$cat = CyberChallenge\Category::insert(array(
  //array('category_id'=>uniqid(), 'name'=>'Identify the Spy'),
  array('category_id'=>uniqid(), 'name'=>'Name the Hack'),
  //array('category_id'=>uniqid(), 'name'=>'Are You A Hacker?'),
  //array('category_id'=>uniqid(), 'name'=>'Industry Best Practices'),
  //array('category_id'=>uniqid(), 'name'=>'Cyber Patriot Questions'),
  array('category_id'=>uniqid(), 'name'=>'General Questions'),
));

$cat = new CyberChallenge\Category(['name'=>'Industry Best Practices']);
$cat->save();
$question = new CyberChallenge\Question([
  'hint_1'=>'Who is responsible for protecting Private Identifying Information PII',
  'hint_2'=>'',
  'hint_3'=>'',
  'answer_a'=>'You Are',
  'answer_b'=>'Security Managers',
  'answer_c'=>'Everyone',
  'answer_d'=>'ISSO',
  'correct_answer'=>'c'
]);
$cat->questions()->save($question);

$cat = new CyberChallenge\Category(['name'=>'Identify the Spy']);
$cat->save();
$questions = array(
  new CyberChallenge\Question([
    'hint_1'=>'Assigned in 2009 to Army unit in Iraq as intelligence analyst, had access to classified databases',
    'hint_2'=>'In 2010, leaked classified information to Wiki Leaks and confided this an online acquaintance',
    'hint_3'=>'In 2010, leaked classified information to Wiki Leaks and confided this an online acquaintance',
    'answer_a'=>'Monica Montez',
    'answer_b'=>'Edward Manning',
    'answer_c'=>'Edward Snowden',
    'answer_d'=>'John Anthony Walker',
    'correct_answer'=>'b'
  ]),
  new CyberChallenge\Question([
    'hint_1'=>'Providing information about highly classified US intelligence collection projects targeting the USSR between 1980-1983',
    'hint_2'=>'Never passed hard copy documents, used photographic memory to reconstruct information provided to Russia',
    'hint_3'=>'Admitted contacting the Soviets in 1980 because he was having serious financial difficulties, a year after he had left the NSA',
    'answer_a'=>'Jonathan J. Pollard',
    'answer_b'=>'Aldrich Hazen Ames',
    'answer_c'=>'Ronald William Pelton',
    'answer_d'=>'Edward Lee Howard',
    'correct_answer'=>'c'
  ]),
);
$cat->questions()->saveMany($questions);

$cat = new CyberChallenge\Category(['name'=>'Are You A Hacker?']);
$cat->save();
$question = new CyberChallenge\Question([
  'hint_1'=>'Type of computer security vulnerability typically found in web applications',
  'hint_2'=>'Enables attackers to inject client-side scripts into web pages viewed by other users',
  'hint_3'=>'Vulnerability often used by attackers to bypass access controls such as the same-origin policy',
  'answer_a'=>'SQL Injection',
  'answer_b'=>'Cross-Site Scripting',
  'answer_c'=>'Man in the Middle',
  'answer_d'=>'Fuzzing',
  'correct_answer'=>'b'
]);
$cat->questions()->save($question);

$cat = new CyberChallenge\Category(['name'=>'Cyber Patriot Questions']);
$cat->save();
$questions = array(
  new CyberChallenge\Question([
    'hint_1'=>'Knowing any information information contained in an encrypted message makes cracking the cipher easier',
    'hint_2'=>'',
    'hint_3'=>'',
    'answer_a'=>'True',
    'answer_b'=>'False',
    'answer_c'=>'Not Enough Information',
    'answer_d'=>'All of the Above',
    'correct_answer'=>'a'
  ]),
  new CyberChallenge\Question([
    'hint_1'=>'What command in Linux displays a detailed list of the current directory?',
    'hint_2'=>'',
    'hint_3'=>'',
    'answer_a'=>'ls',
    'answer_b'=>'ls -la',
    'answer_c'=>'df',
    'answer_d'=>'df -h',
    'correct_answer'=>'b'
  ]),
  new CyberChallenge\Question([
    'hint_1'=>'What Linux command changes a user group to the wheel group?',
    'hint_2'=>'',
    'hint_3'=>'',
    'answer_a'=>'useradd username -G wheel',
    'answer_b'=>'usermod -aG wheel username',
    'answer_c'=>'wheel -G username',
    'answer_d'=>'addusr -aG username',
    'correct_answer'=>'b'
  ]),
);
$cat->questions()->saveMany($questions);

?>
