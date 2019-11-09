<?php
namespace CyberChallenge;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Question extends Eloquent {
  //table name
  protected $table = 'questions';
  //Use Custom Primary Key
  protected $primaryKey = 'question_id'; // or null
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
    'question_id', 'category_id', 'hint_1', 'hint_2', 'hint_3', 'answer_a', 'answer_b', 'answer_c', 'answer_d', 'correct_answer', 'correct_answer_id', 'difficulty'
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
  protected $casts = [];

  public function save($options = array()) {
    if(is_null($this->question_id)) {
      $this->question_id = uniqid();
    }
    return parent::save();
  }

  public function category() {
    return $this->belongsTo('CyberChallenge\Category', 'category_id', 'category_id');
  }
  public function answers() {
    return $this->hasMany('CyberChallenge\Answer', 'question_id', 'question_id');
  }
  public function correct_answer() {
    return $this->hasOne('CyberChallenge\Answer', 'answer_id', 'correct_answer_id');
  }

}
