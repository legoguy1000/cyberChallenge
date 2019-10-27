<?php
namespace CyberChallenge;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Quiz extends Eloquent {
  //table name
  protected $table = 'quiz';
  //Use Custom Primary Key
  protected $primaryKey = 'quiz_id'; // or null
  /**
 * The "type" of the primary key ID.
 *
 * @var string
 */
  protected $keyType = 'string';
  public $incrementing = false;
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'quiz_id', 'name', 'categories', 'question_count', 'time'
  ];

  protected $appends = [];
  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = [];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'categories' => 'array'
  ];

  public function save($options = array()) {
    if(is_null($this->quiz_id)) {
      $this->quiz_id = uniqid();
    }
    return parent::save();
  }

  public function getQuestions() {
    $questions = Question::with(['category', 'answers' => function ($q) {
      $q->inRandomOrder();
    }])->inRandomOrder()->limit($this->question_count);
    if(!empty($this->categories)) {
      $questions->whereIn('category_id',$this->categories);
    }
    $questions = $questions->get()->makeHidden('correct_answer_id');
    $this->questions = $questions;
  }

}
