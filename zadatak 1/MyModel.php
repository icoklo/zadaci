<?php

require_once "functions.php";

abstract class MyModel
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
      //echo "get {$name}\n";
      $functionName = str_cammel_case("get_{$name}_attr");
      $value = isset($this->attributes[$name]) ? $this->attributes[$name] : null;

      // Provjera dali je property u appends listi
      // Ako jeste, onda mora imati implementiran Accessor
      if(in_array($name, $this->appends) AND !method_exists($this, $functionName)) {
          throw new \Exception(get_class($this)." has no implemented method $functionName", 1);
      }

      if(method_exists($this, $functionName))
      {
          return $this->$functionName($value);
      }

      return $value;
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
        /*
        $appends = [];
        foreach($this->appends AS $key) {
            $appends[$key] = $this->$key;
        }*/

        $appends = array_reduce($this->appends, function($prev, $key) {
            $prev[$key] = $this->$key;
            return $prev;
        }, []);

        $attributes = array_filter($this->attributes, function($key) {
            return !in_array($key, $this->hidden);
        }, ARRAY_FILTER_USE_KEY);

        return array_merge($attributes, $appends);
  }

}
