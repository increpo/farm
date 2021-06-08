<?php

class Animal{
    private $name;
    public $id;

    public function __construct($name)
    {
    		$this->id = substr(md5(rand()), 0, 6);
        $this->name = $name;
    }

    public function getProduct($minProduct, $maxProduct): int
    {
        return rand($minProduct, $maxProduct);
    }
}

interface CanGiveMilk {
    public function getMilk(): int;
}

interface CanGiveEggs {
    public function getEggs(): int;
}

class Cow extends Animal implements CanGiveMilk{

    public function __construct()
    {
    		parent::__construct('cow');
    }

    public function getMilk(): int
    {
        return $this->getProduct(8, 12);
    }
}

class Hen extends Animal implements CanGiveEggs{

    public function __construct()
    {
        parent::__construct('hen');
    }

    public function getEggs(): int
    {
        return $this->getProduct(0, 1);
    }
}

