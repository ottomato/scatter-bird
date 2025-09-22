<?php

namespace App\World;

use App\Character\Base;

class Location
{
    public string $name;
    public string $description;
    public array $accessWays = [];

    public function __construct(string $id, string $description, Base $owner)
    {
        $this->id = $id;
        $this->name = $owner->name . "'s " . $id;
        $this->description = $description;
        $this->owner = $owner; 
    }

    public function addAccessWay(string $locationName): void
    {
        $this->accessWays[] = $locationName;
    }
}