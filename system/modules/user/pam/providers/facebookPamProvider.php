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

    public function  __construct()
    {
        parent::__construct();
        $config = $this->toolkit->getConfig('user');
        $this->facebookAppID = $config->get('facebook_AppID');
        $this->facebookSecret = $config->get('facebook_Secret');
        $this->facebook = new Facebook(array('appId' => $this->facebookAppID, 'secret' => $this->facebookSecret, 'cookie' => true));
    }

    public function login()
    {
        $user = $this->getUser();
        if ($user &&  $user->isConfirmed()) {
                pam::rememberUser($user, 'facebook');
        } else {
            $user = null;
        }

        return $user;
    }

    public function logout(user $user = null)
    {
        $this->request->setParam('save', true);
    }

    public function validate(validator &$validator)
    {
	$uid = $this->facebook->getUser();
	return !empty($uid);
    }

    public function checkAuth(user $user)
    {
	$facebookUser = $this->getUser();
   //     var_dump($this->facebook->getUser()); die();
        if ($facebookUser && $user) {
        return ($facebookUser->getId() == $user->getId());
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
