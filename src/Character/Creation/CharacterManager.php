<?php

namespace App\Character\Creation;

use App\Character\Base;

class CharacterManager
{
    private array $characters;

    public function add(Base $character): void
    {
        $this->characters[$character->name] = $character;
    }

    public function getCharacter(Base $character): Base
    {
        if (!isset($this->characters[$character->name])) {
            // fix
            return null;
        }

        return $this->characters[$character->name];
    }
}   