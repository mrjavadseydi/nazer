<?php

namespace App\Contracts;

interface IParser{
    public function __construct($text);

    public function run();
}
