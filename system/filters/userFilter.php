<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage filters
 * @version $Id$
 */
fileLoader::load('user/pam/pam');

/**
 * userFilter: filter for getting current user
 *
 * @package system
 * @subpackage filters
 * @version 0.1.2
 */
class userFilter implements iFilter
{

    /**
     * runs filter
     *
     * @param filterChain $filter_chain
     * @param httpResponse $response
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $toolkit = systemToolkit::getInstance();

        $userMapper = $toolkit->getMapper('user', 'user');
        $user_id = $toolkit->getSession()->get('user_id');

        $user = null;

        if (is_null($user_id)) {
            $userAuthMapper = $toolkit->getMapper('user', 'userAuth');
            $auth_hash = $request->getString(userAuthMapper::AUTH_COOKIE_NAME, SC_COOKIE);

            $userAuth = null;
            if ($auth_hash) {
                $ip = $request->getServer('REMOTE_ADDR');
                $userAuth = $userAuthMapper->getAuth($auth_hash, $ip);

                if (is_null($userAuth)) {
                    $response->setCookie(userAuthMapper::AUTH_COOKIE_NAME, '', -1);
                }
            }

            // if user stored Auth, then restore it
            if (!is_null($userAuth)) {
                $user = $userAuth->getUser();
                $valideAuth = false;
                if ($user &&  $user->getHash() === $userAuth->getUserHash() && $user->isConfirmed()) {
                    try {
                        $pam = pam::factory($userAuth->getPam());
                        if ($pam->checkAuth($user)) {
                            $valideAuth = true;
                        }
                    } catch (mzzUnknownPamProviderException $e) {}
                }

                if (!$valideAuth) {
                    $user = null;
                    $userAuthMapper->delete($userAuth);
                }
            }

            if ($user) {
                $userMapper->updateLastLoginTime($user);
            }
        } else {
            $user = $userMapper->searchByKey($user_id);
            $user_hash = $toolkit->getSession()->get('user_hash');
            if (!$user || $user->getHash() !== $user_hash || !$user->isConfirmed()) {
                $user = null;
            }
        }

        $toolkit->setUser($user);

        $filter_chain->next();
    }

}
?>