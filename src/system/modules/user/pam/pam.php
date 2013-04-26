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

            $providers = explode(',', systemToolkit::getInstance()->getConfig('user')->get('pamProviders'));

           if (empty($providers) || !in_array($provider, $providers)) {
                 throw new mzzUnknownPamProviderException($provider);
           }

            $className = $provider . 'PamProvider';
            try {
                $notFound = false;
                if (!class_exists($className)) {
                    fileLoader::load('user/pam/providers/' . $className);
                    $notFound = !class_exists($className);
                }
            } catch (mzzIoException $e) {
                $notFound = true;
            }

            if ($notFound) {
                throw new mzzUnknownPamProviderException($className);
            }
            self::$instances[$provider] = new pam(new $className());
        }

        return self::$instances[$provider];
    }

    public static function rememberUser(user $user, $pamProvider)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        $userAuthMapper = $toolkit->getMapper('user', 'userAuth');
        $hash = $request->getString(userAuthMapper::AUTH_COOKIE_NAME, SC_COOKIE);
        $ip = $request->getServer('REMOTE_ADDR');
        $userAuth = $userAuthMapper->saveAuth($user, $hash, $ip, $pamProvider);

        $toolkit->getResponse()->setCookie(userAuthMapper::AUTH_COOKIE_NAME, $userAuth->getHash(), time() + 10 * 365 * 86400, '/');
    }

    public function  __construct(iPamProvider $provider)
    {
        $this->provider = $provider;
    }

    public function validate(validator $validator)
    {
        return $this->provider->validate($validator);
    }

    public function login()
    {
        return $this->provider->login();
    }

    public function logout(user $user = null, & $backUrl = null)
    {
        return $this->provider->logout($user, $backUrl);
    }

    public function checkAuth(user $user)
    {
        return $this->provider->checkAuth($user);
    }
}