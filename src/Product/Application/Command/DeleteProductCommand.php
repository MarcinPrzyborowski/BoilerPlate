<?php

namespace App\Product\Application\Command;



class DeleteProductCommand
{

    private string $uuid;

    /**
     * DeleteProductCommand constructor.
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }


}