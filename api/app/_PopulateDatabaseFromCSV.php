<?php
require_once(__DIR__.'/includes.php');


$file = $argv[1];
if(!is_file($file)) {
  die('Not a file');
}
if(substr($file, -4)  != '.csv') {
  die('Not a CSV file');
}
if (($handle = fopen($file, "r")) !== FALSE) {
  $headers = fgetcsv($handle, 1000, ",");
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $row = array_combine($headers,$data);
    $cat = CyberChallenge\Category::where('name', $row['category'])->first();
    if(is_null($cat)) {
      $cat = new CyberChallenge\Category(['name'=>$row['category']]);
      $cat->save();
    }
    if($row['hint_1'] != '' && $row['answer_1'] != '') {
      $quest = new CyberChallenge\Question([
        'hint_1'=>$row['hint_1'],
        'hint_2'=>$row['hint_2'],
        'hint_3'=>$row['hint_3'],
        'difficulty'=>$row['difficulty'],
      ]);
      $cat->questions()->save($quest);
      $answers = array(
        new CyberChallenge\Answer(['answer'=>$row['answer_1']]), //Correct Answer
        new CyberChallenge\Answer(['answer'=>$row['answer_2']]),
        new CyberChallenge\Answer(['answer'=>$row['answer_3']]),
        new CyberChallenge\Answer(['answer'=>$row['answer_4']]),
      );
      $quest->answers()->saveMany($answers);
      $quest->correct_answer_id = $answers[0]->answer_id;
      $quest->save();
    }
  }
  fclose($handle);
}
?>
