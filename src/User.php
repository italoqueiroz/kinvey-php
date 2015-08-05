<?php

namespace Izie\Kinvey;

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

    public function save($data)
    {
        return $this->update($data);
    }

    public function update($data)
    {
        return $this->getConnect()->send($this->getConsole(), 'put', $data['_id'], null, null, $data);
    }

    public function destroy($collection, $id)
    {

    }
}