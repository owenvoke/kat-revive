<?php

namespace pxgamer\KatRevive\Controller;

use pxgamer\KatRevive\Db;

/**
 * Class Controller
 * @package pxgamer\KatRevive\Controller
 */
class Controller
{
    /**
     * @var \mysqli
     */
    private $connection;
    /**
     * @var \Smarty
     */
    private $smarty;

    public function __construct()
    {
        foreach (\System\Request::instance() as $item => $value) {
            $this->$item = $value;
        }

        // Initialise the database connection (uses a singleton)
        $this->connection = Db::conn();

        // Initialise Smarty config
        $this->smarty_init();
    }

    public function index()
    {

    }

    public function error()
    {

    }

    private function smarty_init()
    {
        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir(ROOT_PATH . 'templates');
        $this->smarty->setCompileDir(ROOT_PATH . 'templates_c');
    }
}