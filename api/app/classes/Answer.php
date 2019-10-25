<?php
namespace CyberChallenge;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Answer extends Eloquent {
  //table name
  protected $table = 'answers';
  //Use Custom Primary Key
  protected $primaryKey = 'answer_id'; // or null
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
    'answer_id', 'question_id', 'answer'
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
    if(is_null($this->answer_id)) {
      $this->answer_id = uniqid();
    }
    return parent::save();
  }

  public function question() {
    return $this->belongsTo('CyberChallenge\Question', 'question_id', 'question_id');
  }

}
