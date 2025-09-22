<?php

namespace App\Actions;

class Navigator
{
    public function __construct(
        private array $locations,
    )
    {}   

    public function moveTo(string $destination): string
    {
        if (in_array($destination, $this->locations)) {
            return $this->locations[$destination];
        }

        return $this->destination;
    }
}