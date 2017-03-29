<?php
error_reporting( E_ALL );
ini_set('display_errors', 1);
// ZAD 1:
// napraviti privatnu varijablu u koju se trebaju spremati svi atributi klase
// get_object_vars - vraca sve atribute objekta kojima se moze pristupiti i koji nisu
// staticni, znaci vraca samo javne atribute

// Zad 2:
// napraviti metodu toArray koja vraca asocijativni array od svih atributa
// napraviti polje protected hidden koje sadrzi listu sakrivenih atributa koji nisu dostupni izvan klase
// koristiti array filter kako se skrivena polja koja su definirana u hidden nebi vidjela izvan klase
// tj ako je atribut naveden u polju hidden nemoj ga prikazivati u listi atributa
// RJESENJE MOZE BITI I S METODOM array_flip - kljucevi postaju vrijednosti i obratno
// CALLABLE (nesto sto se moze pozvati) MOZE BITI STRING (NAZIV FUNKCIJE), ALI ISTO MOZE BITI I ARRAY koji sadrzi ime klase te naziv metode koja se poziva,
// npr. [$c, 'd'] pri cemu je $c objekt neke klase

class Container
{
  protected $attributes = [];

  protected $hidden = [];

  protected $appends = [];

  public function __construct()
  {
  }

  public function __set($name, $value)
  {
      $this->attributes[$name] = $value;
  }

  public function __get($name)
  {
      if(array_key_exists($name, $this->attributes))
      {
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
    // array filter se ovdje koristi sa zastavicom ARRAY_FILTER_USE_KEY koja oznacava
    // da se callback funkciji predaje samo jedan atribut i to kljuc polja
    // te ako callback funkcija vrati true u polje se vraca trenutna vrijednosti
    // a ako vrati false tada se trenutna vrijednost uklanja iz polja
    // rezultat funkcije array_filter je novi filtrirani array
    // $c = new User();
    // $c->d(); // ovo prolazi jer se protected metodama može pristupati kod nasljedenih klasa
    // $c->a(); // to ne prolazi jer se poziva privatna metoda klase User iz klase Container
    // $c->m(); to prolazi jer se metoda poziva iz klase Container
    // die();
    // return array_filter($this->attributes, [$c, 'd']);
    // return $this->attributes; // attributes jos uvijek sadrzi sve atribute klase, i javne i protected
    // die();

    return array_filter($this->attributes, function($key) {
        return !in_array($key, $this->hidden);
    }, ARRAY_FILTER_USE_KEY);
  }

  private function m()
  {
    echo "string";
  }

}

class A
{
  private function b()
  {
    throw new Exception("Error Processing Request  BBBBBBBBBBBBBBBBBBBBBB", 1);
  }
}

class User extends Container
{
    protected $hidden = ['password'];

    private function a()
    {
      throw new Exception("Error Processing Request AAAAAAAAAAAAAAAAAAAAA", 1);
    }

    protected function d()
    {
      throw new Exception("Error Processing Request DDDDDDDDDDDDDDDDDDDD", 1);
    }
}

$a = new User();

$a->ime = "Igor";
$a->prezime = "Coklo";
$a->password = "123456";

$polje = $a->toArray();
var_dump($polje);
die();
