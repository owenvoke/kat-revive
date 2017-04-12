<?php

namespace pxgamer\KatRevive\Controller;

use pxgamer\KatRevive\Db;
use System\Request;

/**
 * Class Controller
 * @package pxgamer\KatRevive\Controller
 */
class Controller
{
    /**
     * @var \mysqli
     */
    protected $connection;
    /**
     * @var \Smarty
     */
    protected $smarty;

    public function __construct()
    {
        foreach (Request::instance() as $item => $value) {
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

    public function error_404()
    {
        $error_code = 'Error 404';
        $error_text = 'Page not found.';

        $this->smarty->display('error.tpl', ['error_code' => $error_code, 'error_text' => $error_text]);
    }

    private function smarty_init()
    {
        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir(ROOT_PATH . 'templates');
        $this->smarty->setCompileDir(ROOT_PATH . 'templates_c');
    }
}