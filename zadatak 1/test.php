<?php

// napraviti privatnu varijablu u koju se trebaju spremati svi atributi klase
// get_object_vars - vraca sve atribute objekta kojima se moze pristupiti i koji nisu
// staticni, znaci vraca samo javne atribute

class Container
{
  private $attributes = array();
  // $attributes je na kraju array tipa
  // [
  //   key1 => value1,
  //   key2 => value2,
  // ] pri cemu su keyevi nazivi atributa klase a value su vrijednosti

  function __construct() {

  }

  public function __set($name, $value)
  {
      echo "Setting '$name' to '$value'\n";
      $this->attributes[$name] = $value;
  }

  public function __get($name)
  {
      echo "Getting $name\n";
      if(array_key_exists($name, $this->attributes))
      {
          return $this->attributes[$name];
      }
  }

}

$a = new Container();

$a->ime = "Igor";
$a->prezime = "Coklo";

//echo "1:";
// var_dump(get_object_vars($a));
//
// echo "to:" . json_encode($a). '\n';

if(json_encode($a) != "{}") {
  throw new Exception("Error  #1", 1);
}

if($a->ime != "Igor") {
  throw new Exception("Error #2", 1);
}

echo "Success!!!";
