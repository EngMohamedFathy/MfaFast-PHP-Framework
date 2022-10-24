<?php

namespace MfaFast;

use MfaFast\Http\Route;
use MfaFast\Database\DB;
use MfaFast\Http\Request;
use MfaFast\Http\Response;
use MfaFast\Support\Config;
use MfaFast\Support\Session;
use MfaFast\Database\Managers\MySQLManager;
use MfaFast\Database\Managers\SQLiteManager;

class Application
{
    protected $route;
    protected $request;
    protected $response;
    protected $db;
    protected $config;
    protected $session;

    public function __construct()
    {
        $this->request  = new Request();
        $this->response = new Response();
        $this->route    = new Route($this->request, $this->response);
        $this->config   = new Config($this->loadConfigurations());
        $this->db       = new DB($this->getDatabaseDriver());
        $this->session  = new Session();
    }

    /**
     * @return MySQLManager|SQLiteManager
     */
    protected function getDatabaseDriver()
    {
        switch(env('DB_DRIVER')){
            case 'mysql':
                return new MySQLManager;
            default:
                return new SQLiteManager;
        }
    }

    /**
     * @return \Generator
     */
    protected function loadConfigurations()
    {
        foreach(scandir(config_path()) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $filename = explode('.', $file)[0];

            yield $filename => require config_path() . $file;
        }
    }

    public function run()
    {
        $this->db->init();

        $this->route->resolve();
    }

    public function __get($name)
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
    }
}
