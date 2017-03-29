<?php

require_once "functions.php";

abstract class Container
{
  protected $attributes = [];

  protected $hidden = [];

  protected $appends = [];

  // provjeriti dali postoji funkcija za dohvacanje vrijednosti varijable
  // te dali postoji funkcija za postavljanje vrijednosti varijable
  // te ako postoji izvrsiti ju
  public function __set($name, $value)
  {
      $functionName = str_cammel_case("set_{$name}_attr");
      if(method_exists($this, $functionName))
      {
          // if method exists execute it
          $this->$functionName($value);
      }
      else
      {
          $this->attributes[$name] = $value;
      }

  }

  public function __get($name)
  {
      //echo "Getting $name\n";
      $functionName = str_cammel_case("get_{$name}_attr");
      if(method_exists($this, $functionName))
      {
          return $this->$functionName($name);
      }
      else if(isset($this->attributes[$name]))
      {
          return $this->attributes[$name];
      }

      return null;
  }

  public function __toString()
  {
    return $this->toJson($this->toArray());
  }

  public function toJson($array)
  {
    return json_encode($array);
  }

  /**
   * toArray returns asociative array of all atributes that are not in array hidden
   * @return asociative array
   */
  public function toArray()
  {
    return array_filter($this->attributes, function($key) {
        return !in_array($key, $this->hidden);
    }, ARRAY_FILTER_USE_KEY);
  }

}
