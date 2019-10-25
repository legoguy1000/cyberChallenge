<?php
require_once(__DIR__.'/includes.php');

//Correct Answer needs to be the first answer listed, index 0
$data = array(
  'Name the Hack' => array(),
  'General Questions' => array(),
  'Industry Best Practices' => array(
    array(
      'hints' => array(
        'hint_1'=>'Who is responsible for protecting Private Identifying Information PII',
        'hint_2'=>'',
        'hint_3'=>'',
      ),
      'answers' => array(
        'Everyone',
        'You Are',
        'Security Managers',
        'ISSO',
      )
    ),
  ),
  'Identify the Spy' => array(
    array(
      'hints' => array(
        'hint_1'=>'Assigned in 2009 to Army unit in Iraq as intelligence analyst, had access to classified databases',
        'hint_2'=>'In 2010, leaked classified information to Wiki Leaks and confided this an online acquaintance',
        'hint_3'=>'In 2010, leaked classified information to Wiki Leaks and confided this an online acquaintance',
      ),
      'answers' => array(
        'Edward Snowden',
        'Monica Montez',
        'Edward Manning',
        'John Anthony Walker',
      )
    ),
    array(
      'hints' => array(
        'hint_1'=>'Providing information about highly classified US intelligence collection projects targeting the USSR between 1980-1983',
        'hint_2'=>'Never passed hard copy documents, used photographic memory to reconstruct information provided to Russia',
        'hint_3'=>'Admitted contacting the Soviets in 1980 because he was having serious financial difficulties, a year after he had left the NSA',
      ),
      'answers' => array(
        'Ronald William Pelton',
        'Jonathan J. Pollard',
        'Aldrich Hazen Ames',
        'Edward Lee Howard',
      )
    ),
  ),
  'Are You A Hacker?' => array(
    array(
      'hints' => array(
        'hint_1'=>'Type of computer security vulnerability typically found in web applications',
        'hint_2'=>'Enables attackers to inject client-side scripts into web pages viewed by other users',
        'hint_3'=>'Vulnerability often used by attackers to bypass access controls such as the same-origin policy',
      ),
      'answers' => array(
        'Cross-Site Scripting',
        'SQL Injection',
        'Man in the Middle',
        'Fuzzing',
      )
    ),
  ),
  'Cyber Patriot Questions' => array(
    array(
      'hints' => array(
        'hint_1'=>'Knowing any information information contained in an encrypted message makes cracking the cipher easier',
        'hint_2'=>'',
        'hint_3'=>'',
      ),
      'answers' => array(
        'True',
        'False',
        'Not Enough Information',
        'All of the Above',
      )
    ),
    array(
      'hints' => array(
        'hint_1'=>'What command in Linux displays a detailed list of the current directory?',
        'hint_2'=>'',
        'hint_3'=>'',
      ),
      'answers' => array(
        'ls -la',
        'ls',
        'df',
        'df -h',
      )
    ),
    array(
      'hints' => array(
        'hint_1'=>'What Linux command changes a user group to the wheel group?',
        'hint_2'=>'',
        'hint_3'=>'',
      ),
      'answers' => array(
        'usermod -aG wheel username',
        'useradd username -G wheel',
        'wheel -G username',
        'addusr -aG username',
      )
    ),
  ),
);


foreach($data as $category=>$questions) {
  $cat = new CyberChallenge\Category(['name'=>$category]);
  $cat->save();
  if(count($questions) > 0) {
    foreach($questions as $question) {
      $hints = $question['hints'];
      $answers = $question['answers'];
      $quest = new CyberChallenge\Question([
        'hint_1'=>$hints['hint_1'],
        'hint_2'=>$hints['hint_2'],
        'hint_3'=>$hints['hint_3'],
      ]);
      $cat->questions()->save($quest);
      $answers = array(
        new CyberChallenge\Answer(['answer'=>$answers[0]]),
        new CyberChallenge\Answer(['answer'=>$answers[1]]),
        new CyberChallenge\Answer(['answer'=>$answers[2]]),
        new CyberChallenge\Answer(['answer'=>$answers[3]]),
      );
      $quest->answers()->saveMany($answers);
      $quest->correct_answer_id = $answers[0]->answer_id;
      $quest->save();
    }
  }
}
?>
