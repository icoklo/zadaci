<?php
namespace App;

abstract class Model
{
  protected $appends = [];

  protected $hidden = [];

  private $attributes = [];

  public function test()
  {

  }

  // toJson
  // toString
  // get
  // set
  // napraviti privatnu varijablu u koju se trebaju spremati svi atributi klase

  public function toJson()
  {
    return json_encode($this->jsonSerialize());
  }

  /**
   * Convert the object into something JSON serializable.
   *
   * @return array
   */
  public function jsonSerialize()
  {
    return (array) $this;
  }

  /**
   * Convert the model to its string representation.
   *
   * @return string
   */
  public function __toString()
  {
    return $this->toJson();
  }
}


?>
