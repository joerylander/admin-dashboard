<?php

namespace App\Helpers;

class StringHelper
{
    public static function formatTitle(string $title): string
    {
        return ucfirst(strtolower(trim($title)));
    }
}