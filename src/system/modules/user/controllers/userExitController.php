<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * userExitController: контроллер для метода exit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.2
 */
class userExitController extends simpleController
{
    protected function getView()
    {
        $backUrl = $this->request->getString('url', SC_GET);
        if (!$backUrl) {
            $url = new url('default');
            $backUrl = $url->get();
        }
        
        $validator = new formValidator();
        $validator->submit('csrf');
        $validator->disableCSRF();
        $validator->rule('csrf', 'csrf');
        
        if ($validator->validate()) {
            $user = $this->toolkit->getUser();
    
            $userMapper = $this->toolkit->getMapper('user', 'user');
            $userMapper->updateLastLoginTime($user);
    
            $userAuthMapper = $this->toolkit->getMapper('user', 'userAuth');
            $authHash = $this->request->getString(userAuthMapper::AUTH_COOKIE_NAME, SC_COOKIE);
    
            if ($authHash) {
                $ip = $this->request->getServer('REMOTE_ADDR');
                $userAuth = $userAuthMapper->getAuth($authHash, $ip);
                if ($userAuth) {
                    try {
                        $pam = pam::factory($userAuth->getPam());
                        $pam->logout($user, $backUrl);
                    } catch (mzzUnknownPamProviderException $e) {}
    
                    $userAuthMapper->delete($userAuth);
                }
    
                $this->response->setCookie(userAuthMapper::AUTH_COOKIE_NAME, '', 0, '/');
            }
    
            $userAuthMapper->clearExpired(strtotime('-1 month'));
    
            $this->toolkit->setUser($userMapper->getGuest());
        }
        
        $this->redirect($backUrl);
    }
}

?>