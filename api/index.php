<?php
require_once('app/includes.php');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config = array();
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['determineRouteBeforeAppMiddleware'] = true;
$config['db']['driver']   = 'mysql'; //your mysql server
$config['db']['host']   = getIniProp('db_host'); //your mysql server
$config['db']['user']   = getIniProp('db_user'); //your mysql server username
$config['db']['pass']   = getIniProp('db_pass'); //your mysql server password
$config['db']['dbname'] = getIniProp('db_name'); //the mysql database to use
$config['db']['charset'] = 'utf8';
$config['db']['collation'] = 'utf8_unicode_ci';
$config['db']['prefix'] = '';
 //asdf
$app = new \Slim\App(['settings' => $config]);
$app->group('/questions', function () {
  //Get all questions
  $this->get('', function ($request, $response, $args) {
    $questions = CyberChallenge\Question::with(['category', 'answers'])->get();
    $response = $response->withJson($questions);
    return $response;
  });
  //Add question
  $this->post('', function ($request, $response, $args) {
    $question_id = $args['question_id'];
    $formData = $request->getParsedBody();

    if(!isset($formData['category_id']) || $formData['category_id'] == '') {
      $responseArr = array('status'=>false, 'msg'=>'Category cannot be blank!');
      $response = $response->withJson($responseArr);
      return $response;
    }
    $category = $formData['category_id'];
    $cat = CyberChallenge\Category::find($category);
    if(is_null($cat)) {
      $responseArr = array('status'=>false, 'msg'=>'Invalid Category');
      $response = $response->withJson($responseArr);
      return $response;
    }
    if(!isset($formData['hint_1']) || $formData['hint_1'] == '') {
      $responseArr = array('status'=>false, 'msg'=>'Hint 1 cannot be blank');
      $response = $response->withJson($responseArr);
      return $response;
    }
    $answers = array();
    foreach($formData['answers'] as $i=>$answer) {
      if(!isset($answer['answer']) || $answer['answer'] == '') {
        $responseArr = array('status'=>false, 'msg'=>'Answer '.($i+1).' cannot be blank');
        $response = $response->withJson($responseArr);
        return $response;
      }
      $answers[] = new CyberChallenge\Answer(['answer'=>$answer['answer']]);
    }
    $quest = new CyberChallenge\Question([
      'hint_1'=>$formData['hint_1'],
      'hint_2'=>!isset($formData['hint_2']) ? '':$formData['hint_2'],
      'hint_3'=>!isset($formData['hint_3']) ? '':$formData['hint_3'],
    ]);
    $cat->questions()->save($quest);
    $quest->answers()->saveMany($answers);
    $quest->correct_answer_id = $answers[0]->answer_id;
    $quest->save();
    $response = $response->withJson(array('status'=>true, 'msg'=>'Question Added'));
    return $response;
  });
  //Update question
  $this->put('/{question_id:[a-z0-9]{13}}', function ($request, $response, $args) {
    $question_id = $args['question_id'];
    $formData = $request->getParsedBody();
    $question = CyberChallenge\Question::find($question_id);
    if(!isset($formData['category_id']) || $formData['category_id'] == '') {
      $responseArr = array('status'=>false, 'msg'=>'Category cannot be blank!');
      $response = $response->withJson($responseArr);
      return $response;
    }
    $category = $formData['category_id'];
    if($category != $question->category_id) {
      $cat = CyberChallenge\Category::find($category);
      if(is_null($cat)) {
        $responseArr = array('status'=>false, 'msg'=>'Invalid Category');
        $response = $response->withJson($responseArr);
        return $response;
      }
      $question->category_id = $cat->category_id;
    }
    if(!isset($formData['hint_1']) || $formData['hint_1'] == '') {
      $responseArr = array('status'=>false, 'msg'=>'Hint 1 cannot be blank');
      $response = $response->withJson($responseArr);
      return $response;
    }
    $question->hint_1 = $formData['hint_1'];
    $question->hint_2 = !isset($formData['hint_2']) ? '':$formData['hint_2'];
    $question->hint_3 = !isset($formData['hint_3']) ? '':$formData['hint_3'];

    $answers = array();
    foreach($formData['answers'] as $i=>$answer) {
      if(!isset($answer['answer']) || $answer['answer'] == '') {
        $responseArr = array('status'=>false, 'msg'=>'Answer '.($i+1).' cannot be blank');
        $response = $response->withJson($responseArr);
        return $response;
      }
      $answers[] = new CyberChallenge\Answer(['answer'=>$answer['answer']]);
    }
    $question->answers()->delete();
    $question->answers()->saveMany($answers);
    $question->correct_answer_id = $answers[0]->answer_id;
    $question->save();
    $response = $response->withJson(array('status'=>true, 'msg'=>'Question Updated'));
    return $response;

  });
  //Delete question
  $this->delete('/{question_id:[a-z0-9]{13}}', function ($request, $response, $args) {
    $question_id = $args['question_id'];
    $question = CyberChallenge\Question::destroy($question_id);
    if($question) {
      $responseArr = array('status'=>true, 'msg'=>'Question Deleted', 'data' => $question);
    } else {
      $responseArr = array('status'=>false, 'msg'=>'Something went wrong', 'data' => $question);
    }
    $response = $response->withJson($responseArr);
    return $response;
  });
});
$app->group('/categories', function () {
  //Get all questions
  $this->get('', function ($request, $response, $args) {
    $categories = CyberChallenge\Category::orderBy('name','ASC')->get();
    $response = $response->withJson($categories);
    return $response;
  });
});
$app->group('/quiz', function () {
  //Get questions for quiz
  $this->get('/questions', function ($request, $response, $args) {
    $count = $request->getParam('count') !== null &&  $request->getParam('count') > 0 ? $request->getParam('count'):5;
    $categories = $request->getParam('categories') !== null && $request->getParam('categories') !== '' ? $request->getParam('categories'):null;
    $questions = CyberChallenge\Question::with(['category', 'answers' => function ($q) {
      $q->inRandomOrder();
    }])->inRandomOrder()->limit($count);
    if(!is_null($categories)) {
      $cats = is_array($categories) ? $categories : explode(',',$categories);
      $questions->whereIn('category_id',$cats);
    }
    $questions = $questions->get()->makeHidden('correct_answer_id');
    $response = $response->withJson($questions);
    return $response;
  });
  //Submit Answers
  $this->post('/answers', function ($request, $response, $args) {
    $formData = $request->getParsedBody();
    if(!isset($formData['answers']) || !is_array($formData['answers']) || $formData['answers'] == '') {

    }
    $answersData = array(
      'answers' => array_fill_keys(array_keys($formData['answers']), false),
      'correct_answers' => 0,
      'incorrect_answers' => 0,
      'total' =>count($formData['answers'])
    );
    foreach($formData['answers'] as $question_id=>$answer_id) {
      $question = CyberChallenge\Question::find($question_id);
      if($question->correct_answer_id == $answer_id) {
        $answersData['answers'][$question_id] = true;
        $answersData['correct_answers']++;
      } else {
        $answersData['incorrect_answers']++;
      }
    }

    $response = $response->withJson($answersData);
    return $response;
  });
});
$app->run();

?>
