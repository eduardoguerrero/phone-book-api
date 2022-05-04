<?php

namespace App\Repository;

/**
 * Interface ContactInterface
 * @package App\Repository
 */
interface ContactInterface
{
    public function getByName(string $firstname, string $lastname): array;
}
