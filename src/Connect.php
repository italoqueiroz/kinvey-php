<?php

namespace Izie\Kinvey;

class Connect
{
    protected $_curl;
    protected $_authorization;
    protected $_kinveyUrl = 'https://baas.kinvey.com';
    protected $_curlHttpHead = array(
        'X-Kinvey-API-Version: 3',
        'Accept: application/json',
        'Content-Type: application/json',
        'X-Kinvey-ResponseWrapper true',
        'Content-Type: text/xml; charset=utf-8'
    );

    public function __construct()
    {
        $authorization = Kinvey::getAppId().':';
        if (Kinvey::getMasterSecret()) {
            $authorization .= Kinvey::getMasterSecret();
        } else {
            $authorization .= Kinvey::getAppSecret();
        }

        $this->setAuthorization(base64_encode($authorization));
    }

    /**
     * @return mixed
     */
    public function getCurl()
    {
        return $this->_curl;
    }

    /**
     * @param mixed $curl
     */
    public function setCurl($curl)
    {
        $this->_curl = $curl;
    }

    /**
     * @return mixed
     */
    public function getAuthorization()
    {
        return $this->_authorization;
    }

    /**
     * @param mixed $authorization
     */
    public function setAuthorization($authorization)
    {
        $this->_authorization = $authorization;
    }

    /**
     * @return array
     */
    public function getCurlHttpHead()
    {
        return $this->_curlHttpHead;
    }

    /**
     * @param array $curlHttpHead
     */
    public function setCurlHttpHead($curlHttpHead)
    {
        $this->_curlHttpHead = $curlHttpHead;
    }

    /**
     * @return string
     */
    public function getKinveyUrl()
    {
        return $this->_kinveyUrl;
    }

    /**
     * @param string $kinveyUrl
     */
    public function setKinveyUrl($kinveyUrl)
    {
        $this->_kinveyUrl = $kinveyUrl;
    }

    protected function _prepareCurl($console, $method, $collection, $id = null, $query = null)
    {
        $url = $this->getKinveyUrl()
            . $console
            . Kinvey::getAppId()
            . '/' . $collection;

        if (!empty($id)) {
            $url .= '/'.$id;
        }

        if (!empty($query)) {
            $url .= '?'.$query->getQuery();
        }

//        var_dump(urldecode($url), $method);
        $ch = curl_init($url);
        if (!empty($method)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, mb_strtoupper($method));
            if ($method == 'delete') {
                $curlHttpHead = $this->getCurlHttpHead();
                unset($curlHttpHead[2]);
                $this->setCurlHttpHead($curlHttpHead);
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$this->getAuthorization()) + $this->getCurlHttpHead());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $this->setCurl($ch);
        unset($ch);
    }

    protected function _setData($data)
    {
        if (isset($data)) {
            //var_dump(json_encode($data));
            curl_setopt($this->getCurl(), CURLOPT_POSTFIELDS, json_encode($data));
        }
    }

    public function send($console, $method, $collection, $id = null, $query = null, $data = null)
    {
        $this->_prepareCurl($console, $method, $collection, $id, $query);
        $this->_setData($data);

        $output = curl_exec($this->getCurl());

        if (curl_errno($this->getCurl())) {
            throw new \Exception('Curl error: ' . curl_error($this->getCurl()));
        } else {
            curl_close($this->getCurl());
            $result = json_decode($output);
            if (is_object($result) && property_exists($result, 'error')) {
                $exceptionMessage = $result->error;
                if(isset($result->description)){
                    $exceptionMessage .= ' - '.$result->description;
                }
                if(isset($result->debug)){
                    $exceptionMessage .= ': (DEBUG) - ' . $result->debug;
                }
                throw new \Exception($exceptionMessage);
            }
            return $result;
        }
    }
}