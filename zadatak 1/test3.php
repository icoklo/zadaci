<?php
// error_reporting( E_ALL );
// ini_set('display_errors', 1);

// ZAD 3:
// npr korisnik zeli pristupati atributu firstname kao $a->firstname te
// ako postoji funkcija izvrsi funkciju a ako ne
// onda vrati atribut koji je korisnik trazio

require_once "./Container.php";

class User extends Container
{
    protected $hidden = ['password'];

    protected $appends = ['full_name'];

    public function getFirstNameAttr()
    {
        return $this->attributes['first_name'];
    }

    public function setFirstNameAttr($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    public function getLastNameAttr($value)
    {
        return $this->attributes['last_name'];
    }

    public function setLastNameAttr($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }

    public function first_name()
    {
        return 'funkcija';
    }

    public function getFullNameAttr()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function setStatusAttr($value)
    {
        $this->attributes['status'] = strtoupper($value);
    }

}

$a = new User();

$a->first_name = "igor";
$a->status = 'active';
$a->last_name = "coklo";
$a->password = "123456";

echo "WIN:" . $a->getFullNameAttr() . "\n\n";

$polje = $a->toArray();
var_dump($polje);

if($a->status != "ACTIVE") {
    throw new \Exception("Error #0", 1);
}

if($a->first_name != "Igor") {
    throw new \Exception("Error #1", 1);
}

if($a->last_name != "Coklo") {
    throw new \Exception("Error #2", 1);
}

if($a->full_name != "Igor Coklo") {
    throw new \Exception("Error #3", 1);
}

if($a->first_name() != "funkcija") {
    throw new \Exception("Error #4", 1);
}

echo "\nAll is OK!";
