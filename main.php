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


interface Storage {

    public function addMilk(int $liters);

    public function addEggs(int $eggsCount);

    public function getFreeSpaceForMilk(): int;

    public function getFreeSpaceForEggs(): int;

    public function howMuchMilk(): int;

    public function howMuchEggs(): int;

}

class Barn implements Storage {

    private $milkLiters = 0;
    private $eggsCount = 0;
    private $milkLimit = 0;
    private $eggsLimit = 0;

    public function __construct(int $milkLimit, int $eggsLimit)
    {
        $this->milkLimit = $milkLimit;
        $this->eggsLimit = $eggsLimit;
    }

    public function addMilk(int $liters)
    {
        $freeSpace = $this->getFreeSpaceForMilk();

        if ($freeSpace === 0) {
          return;
        }

        if ($freeSpace < $liters) {
          $this->milkLiters = $this->milkLimit;
          return;
        }

        $this->milkLiters += $liters;
    }

    public function addEggs(int $eggsCount)
    {
        $freeSpace = $this->getFreeSpaceForEggs();

        if ($freeSpace === 0) {
            return;
        }

        if ($freeSpace < $eggsCount) {
          $this->eggsCount = $this->eggsLimit;
          return;
        }

        $this->eggsCount += $eggsCount;
    }

    public function getFreeSpaceForMilk(): int
    {
        return $this->milkLimit - $this->milkLiters;
    }

    public function getFreeSpaceForEggs(): int
    {
        return $this->eggsLimit - $this->eggsCount;
    }

    public function howMuchMilk(): int
    {
        return $this->milkLiters;
    }

    public function howMuchEggs(): int
    {
        return $this->eggsCount;
    }
}

class Farm {

    private $name;
    private $storage;
    private $animals = [];

    public function __construct(string $name, Storage $storage)
    {
        $this->name = $name;
        $this->storage = $storage;
    }

    public function returnMilk()
    {
        return $this->storage->howMuchMilk();

    }

    public function returnEggs()
    {
        return $this->storage->howMuchEggs();

    }

    public function addAnimal(Animal $animal)
    {
        $this->animals[] = $animal;
    }

    public function collectProducts()
    {
        foreach ($this->animals as $animal)
        {
            if ($animal instanceOf CanGiveMilk) {
                $milkLiters = $animal->getMilk();
                $this->storage->addMilk($milkLiters);
            }

            if ($animal instanceOf CanGiveEggs) {
                $eggsCount = $animal->getEggs();
                $this->storage->addEggs($eggsCount);
            }
        }
    }
}

$barn = new Barn($milkLimit = 200, $eggsLimit = 300);
$myFarm = new Farm('MyFarm', $barn);

for ($i=0;$i<30;$i++) {
    $myFarm->addAnimal(new Hen());
}

for ($i=0;$i<20;$i++) {
    $myFarm->addAnimal(new Cow());
}

$myFarm->collectProducts();

echo 'Количество молока: '.$myFarm->returnMilk().' литров <br>';
echo 'Количество яиц: '.$myFarm->returnEggs().' шт <br>';

