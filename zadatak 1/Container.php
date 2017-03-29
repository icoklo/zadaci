<?php

require_once "functions.php";

abstract class Container
{
  protected $attributes = [];

  protected $hidden = [];

  protected $appends = [];

  public function __set($name, $value)
  {
      if(method_exists($this, $name)){
          // if method exists execute it
          $this->$name();
      }
      else if(strpos($name, '_') !== false){
          // ako se na kraju dodaju zagrade () tada se poziva funkcija ako ona postoji
          $functionName = str_cammel_case("set_{$name}_attr");
          echo "set:" . $functionName;
          $this->$functionName($value);
      }
      else{
          $this->attributes[$name] = $value;
      }

  }

  public function __get($name)
  {
      echo "Getting $name\n";

      if(method_exists($this, $name)){
          return $this->$name();
      }
      else if(isset($this->attributes[$name]))
      {
          if(strpos($name, '_') !== false)
          {
              // ako se na kraju dodaju zagrade () tada se poziva funkcija ako ona postoji
              $functionName = str_cammel_case("get_{$name}_attr");
              echo "get:" . $functionName . "\n";
              return $this->$functionName($name);
          }
          return $this->attributes[$name];
      }

      return null;
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

  // @TODO: __toString treba vraćati JSON
  // @TODO: napraviti toJson
}
