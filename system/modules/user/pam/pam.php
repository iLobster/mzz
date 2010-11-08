<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/user/controllers/userLoginController.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userLoginController.php 4202 2010-04-12 13:48:43Z desperado $
 */

fileLoader::load('user/pam/iPamProvider');
fileLoader::load('user/pam/aPamProvider');

/**
 * pam: Pluggable Authentication Modules
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class pam
{
    const DEFAULT_PROVIDER = 'simple';
    
    /**
     * Cache backends instances
     *
     * @var array
     */
    protected static $instances = array();

    /**
     * @var iPamProvider
     */
    protected $provider;

    /**
     * Factory for getting pam object
     *
     * @param string $provider the name of the pam provider backend
     * @return pam
     */
    public static function factory($provider = self::DEFAULT_PROVIDER)
    {

        if (empty($provider)) {
            $provider = self::DEFAULT_PROVIDER;
        }

        if (!isset(self::$instances[$provider])) {
            $className = $provider . 'PamProvider';
            try {
                $notFound = false;
                if (!class_exists($className)) {
                    fileLoader::load('user/pam/providers/' . $className);
                    $notFound = !class_exists($className);
                }
            } catch (mzzIoException $e) {
                var_dump('user' . DIRECTORY_SEPARATOR . 'pam' . DIRECTORY_SEPARATOR . 'providers' . DIRECTORY_SEPARATOR . $className);
                $notFound = true;
            }

            if ($notFound) {
                throw new mzzRuntimeException($className);
            }
            self::$instances[$provider] = new pam(new $className());
        }

        return self::$instances[$provider];
    }

    public function  __construct(iPamProvider $provider)
    {
        $this->provider = $provider;
    }

    public function login()
    {
        return $this->provider->login();
    }

    public function logout(user $user = null)
    {
        return $this->provider->logout($user);
    }

    public function validate(validator &$validator)
    {
        return $this->provider->validate($validator);
    }
}
?>
