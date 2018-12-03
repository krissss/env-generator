<?php

namespace kriss\fileGenerator;

class BaseObject
{
    public function __construct($config = [])
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }
}