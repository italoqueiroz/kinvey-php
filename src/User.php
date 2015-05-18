<?php

namespace League\Kinvey;

class User
{
    /**
     * @var string
     */
    protected $_console = '/user/';

    /**
     * @var Connect
     */
    protected $_connect;

    public function __construct()
    {
        $this->setConnect(new Connect());
    }

    /**
     * @return mixed
     */
    public function getConnect()
    {
        return $this->_connect;
    }

    /**
     * @param mixed $connect
     */
    public function setConnect($connect)
    {
        $this->_connect = $connect;
    }

    /**
     * @return string
     */
    public function getConsole()
    {
        return $this->_console;
    }

    /**
     * @param string $console
     */
    public function setConsole($console)
    {
        $this->_console = $console;
    }

    public function get($collection, $id)
    {

    }

    public function find($query = null)
    {
        return $this->getConnect()->send($this->getConsole(), null, null, null, $query);
    }

    public function save($collection, $data)
    {

    }

    public function update($collection, $data)
    {

    }

    public function destroy($collection, $id)
    {

    }
}