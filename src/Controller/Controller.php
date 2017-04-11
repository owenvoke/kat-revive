<?php

namespace pxgamer\KatRevive\Controller;

class Controller
{
    public function __construct()
    {
        foreach (\System\Request::instance() as $item => $value) {
            $this->$item = $value;
        }
    }

    public function index()
    {

    }

    public function error()
    {

    }
}