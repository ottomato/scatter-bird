<?php

namespace App\World;

use App\Character\Base;

class WorldBuilder
{
    public Base $player;
    public array $locations = [];

    public function build(string $name): Void
    {
        $player = new Base();
        $player->name = $name;

        $bedroom = new Location('bedroom', 'messy bedroom', $player);
        $hallway = new Location('hallway', 'narrow hallway', $player);

        $bedroom->addAccessWay($hallway->id);
        $hallway->addAccessWay($bedroom->id);

        $this->locations['bedroom'] = $bedroom;
        $this->locations['hallway'] = $hallway;
    }
}   
