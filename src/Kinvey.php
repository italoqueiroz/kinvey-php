<?php

namespace Izie\Kinvey;

class Kinvey
{
    /**
     * @var string
     */
    protected static $_appId;
    /**
     * @var string
     */
    protected static $_appSecret;
    /**
     * @var string
     */
    protected static $_masterSecret;

    /**
     * Create a new Kinvey Instance
     *
     * @param null $appId
     * @param null $appSecret
     * @param null $masterSecret
     * @throws \Exception
     */
    public static function initialize($appId = null, $appSecret = null, $masterSecret = null)
    {
        if (empty($appId) || empty($appSecret)) {
            throw new \Exception('APP (ID OR SECRET) NOT FOUND');
        }

        self::setAppId($appId);
        self::setAppSecret($appSecret);

        if (!empty($masterSecret)) {
            self::setMasterSecret($masterSecret);
        }
    }

    /**
     * @return string
     */
    public static function getAppId()
    {
        return self::$_appId;
    }

    /**
     * @param string $appId
     */
    public static function setAppId($appId)
    {
        self::$_appId = $appId;
    }

    /**
     * @return string
     */
    public static function getAppSecret()
    {
        return self::$_appSecret;
    }

    /**
     * @param string $appSecret
     */
    public static function setAppSecret($appSecret)
    {
        self::$_appSecret = $appSecret;
    }

    /**
     * @return string
     */
    public static function getMasterSecret()
    {
        return self::$_masterSecret;
    }

    /**
     * @param string $masterSecret
     */
    public static function setMasterSecret($masterSecret)
    {
        self::$_masterSecret = $masterSecret;
    }
}
