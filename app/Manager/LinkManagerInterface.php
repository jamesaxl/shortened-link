<?php

namespace App\Manager;

interface LinkManagerInterface
{
    public function generateToken(): string;
    public function isTokenExist(string $shortAddress): bool;
}
