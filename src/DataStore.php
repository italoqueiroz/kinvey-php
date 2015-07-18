<?php

namespace Izie\Kinvey;

class DataStore
{
    /**
     * @var string
     */
    protected $_console = '/appdata/';
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
        return $this->getConnect()->send($this->getConsole(), null, $collection, $id);
    }

    public function find($collection, $query = null)
    {
        return $this->getConnect()->send($this->getConsole(), null, $collection, null, $query);
    }

    public function save($collection, $data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }

        if (!is_array($data)) {
            throw new \Exception('Data must be of the type array');
        }

        if (!empty($data['_id'])) {
            return $this->update($collection, $data);
        }

        return $this->getConnect()->send($this->getConsole(), 'post', $collection, null, null, $data);
    }

    public function update($collection, $data)
    {
        return $this->getConnect()->send($this->getConsole(), 'put', $collection, $data['_id'], null, $data);
    }

    public function destroy($collection, $id = null, $query = null)
    {
        return $this->getConnect()->send($this->getConsole(), 'delete', $collection, $id, $query);
    }
}