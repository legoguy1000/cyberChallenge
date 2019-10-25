<?php
namespace CyberChallenge;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent {
  //table name
  protected $table = 'categories';
  //Use Custom Primary Key
  protected $primaryKey = 'category_id'; // or null
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
    'category_id', 'name'
  ];


  protected $appends = [];

  protected $attributes = [];

  //$data['requirements'] = array();
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
    if(is_null($this->category_id)) {
      $this->category_id = uniqid();
    }
    return parent::save();
  }

  public function questions() {
    return $this->hasMany('CyberChallenge\Question', 'category_id', 'category_id');
  }
}
