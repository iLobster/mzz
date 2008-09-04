<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/filters/i18nFilter.php $
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
 * @version $Id: i18nFilter.php 2547 2008-06-25 10:00:29Z mz $
*/

/**
 * userPreferencesFilter: фильтр для определения настроек приложения пользователем
 *
 * @package system
 * @subpackage filters
 * @version 0.2
 */
class userPreferencesFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $toolkit = systemToolkit::getInstance();
        $session = $toolkit->getSession();
        $smarty = $toolkit->getSmarty();
        $me = $toolkit->getUser();
        $preferences = $toolkit->getUserPreferences();

        $lastUserIdVarName = userPreferences::$langVarName . '_last_user_id';
        if ($me->getId() != $session->get($lastUserIdVarName)) {
            // если поменялся id пользователя - стираем значение в сессии
            $session->destroy(userPreferences::$langVarName);
            $session->destroy(userPreferences::$tzVarName);
            $session->destroy(userPreferences::$skinVarName);
            $session->set($lastUserIdVarName, $me->getId());
        }

        // если приложение мультиязычное
        if (systemConfig::$i18nEnable) {
            // смотрим в урле
            if (!($language = $request->getString('lang'))) {
                // смотрим в сессии
                if (!($language = $preferences->getLang())) {
                    // смотрим, есть ли в профиле пользователя
                    if ($language_id = $me->getLanguageId()) {
                        $locale = locale::searchAll($language_id);
                        $language = $locale ? $locale->getName() : null;
                    } else {
                        // смотрим в заголовках
                        $language = $this->chooseFirstLangMatch($request->getAcceptLanguages());
                    }
                }
            }
        }
        if (empty($language)) {
            $language = systemConfig::$i18n;
        }

        if (!$session->exists(userPreferences::$skinVarName)) {
            // если в сессии не установлен скин
            $session->set(userPreferences::$skinVarName, $me->getSkin()->getName());
        }

        systemToolkit::getInstance()->setLocale($language);
        $locale = systemToolkit::getInstance()->getLocale();

        if (!$session->exists(userPreferences::$langVarName) || $preferences->getLang() != $language) {
            // если в сессии не установлен язык
            $session->set(userPreferences::$langVarName, $language);

            if ($me->isLoggedIn()) {
                if ($me->getLanguageId() != $locale->getId()) {
                    $me->setLanguageId($locale->getId());
                    $me->getMapper()->save($me);
                }
            }

            $tz = $me->getTimezone();

            $session->set(userPreferences::$tzVarName, $tz);

            if (!$me->isLoggedIn()) {
                $session->set(userPreferences::$tzDefaultVarName, true);
            }
        }

        if ($session->exists(userPreferences::$tzDefaultVarName)) {
            $smarty->assign('detect_users_timezone', true);
        }

        $smarty->assign('locale_rtl', $locale->isRtl());

        //systemConfig::$i18n = $language;

        $smarty->assign('CURRENT_LANG', $language);

        $filter_chain->next();
    }

    protected function chooseFirstLangMatch(array $accept)
    {
        $locales_names = array();
        foreach (locale::searchAll() as $locale) {
            $locales_names[] = $locale->getName();
        }

        $language = null;

        foreach ($accept as $accept_lang) {
            if (in_array($accept_lang, $locales_names)) {
                $language = $accept_lang;
                break;
            }
        }
        return $language;
    }
}

?>