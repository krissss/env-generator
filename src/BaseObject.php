<?php

namespace kriss\envGenerator;

class BaseObject
{
    public function __construct($config = [])
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }
}