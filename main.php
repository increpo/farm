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

