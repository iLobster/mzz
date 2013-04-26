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
fileLoader::load('user/libs/facebook');

/**
 * facebookPamProvider: for default login method
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class facebookPamProvider extends aPamProvider
{

    protected $facebook = null;
    protected $facebookAppID = null;
    protected $facebookSecret = null;
    protected $facebookPerms = '';

    public function __construct()
    {
        parent::__construct();
        $config = $this->toolkit->getConfig('user');
        $this->facebookAppID = $config->get('facebook_AppID');
        $this->facebookSecret = $config->get('facebook_Secret');
        $this->facebookPerms = $config->get('facebook_Perms');

        if (empty($this->facebookAppID) || empty($this->facebookSecret)) {
            throw new mzzInvalidParameterException('check facebookAppID and facebookSecret params');
        }

        $this->facebook = new Facebook(array('appId' => $this->facebookAppID, 'secret' => $this->facebookSecret, 'cookie' => true));
    }

    public function login()
    {
        $user = null;
        if ($this->facebook->getSession()) { //session found!
            $user = $this->getUser();
            if ($user && $user->isConfirmed()) { //we got a user inside database
                pam::rememberUser($user, 'facebook');
            } else { //no user found, need registration
                var_dump($this->facebook->getUser());
                die();
            }
        }

        return $user;
    }

    public function logout(user $user = null, & $backUrl = null)
    {
        $backUrl = $this->facebook->getLogoutUrl(array('next' => $backUrl));
    }

    /**
     * If no facebook session's found, than redirects to facebook login page.
     *
     * @param validator $validator
     * @return boolean
     */
    public function validate(validator &$validator)
    {
        if ($this->facebook->getSession()) {
            try {
                $me = $this->facebook->api('/me');
                return true;
            } catch (Exception $e) {
                $this->facebook->setSession();
            }
        }

        $loginUrl = $this->facebook->getLoginUrl(array('rec_perms' => $this->facebookPerms, 'fbconnect' => 1));
        $this->response->redirect($loginUrl);
    }

    public function checkAuth(user $user)
    {
        if ($user && $this->facebook->getSession()) {
            try {
                $me = $this->facebook->api('/me');
            } catch (Exception $e) {
                $this->facebook->setSession(); //clearing session
                return false;
            }
            if ($this->facebook->getSession()) {
                $facebookUser = $this->getUser();
                if ($facebookUser) {
                    return ($facebookUser->getId() === $user->getId());
                }
            }
        }
        return false;
    }

    protected function getUser()
    {
        $user = null;

        $module = $this->toolkit->getModule('user');
        $mapper = $module->getMapper('pamFacebook');

        $rel = $mapper->searchByKey($this->facebook->getUser());

        if ($rel) {
            $user = $rel->getUser();
        }

        return $user;
    }

}
?>