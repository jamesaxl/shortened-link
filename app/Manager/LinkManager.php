<?php

namespace App\Manager;

use App\Models\Link;
use App\Utils\Generator;

class LinkManager implements LinkManagerInterface
{
    /**
     * @return string
     */
    public function generateToken(): string
    {
        return Generator::string();
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isTokenExist(string $token): bool
    {
        $link = Link::where('token', $token)->first();

        return null !== $link;
    }
}
