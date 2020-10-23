<?php

namespace App\Shared;

class Uuid
{

    public static function random(): self
    {
        return new self();
    }

}