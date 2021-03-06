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
        $view = $toolkit->getView('smarty');
        $me = $toolkit->getUser();
        $preferences = $toolkit->getUserPreferences();

        $lastUserIdVarName = 'mzz_preferences_last_user_id';
        if ($me->getId() != $session->get($lastUserIdVarName)) {
            // если поменялся id пользователя - стираем значение в сессии
            $preferences->clear();
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
                        $locale = fLocale::searchAll($language_id);
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

        if (!$preferences->getSkin()) {
            // если в сессии не установлен скин
            $preferences->setSkin($me->getSkin()->getName());
        }

        $toolkit->setLocale($language);
        $locale = $toolkit->getLocale();

        $langPreference = $preferences->getLang();
        if (!$langPreference || $langPreference != $language) {
            // если в сессии не установлен язык
            $preferences->setLang($language);

            if ($me->isLoggedIn()) {
                if ($me->getLanguageId() != $locale->getId()) {
                    $me->setLanguageId($locale->getId());
                    $userMapper = $toolkit->getMapper('user', 'user');
                    $userMapper->save($me);
                }
            }

            $tz = $me->getTimezone();

            $preferences->setTimezone($tz);

            if (!$me->isLoggedIn()) {
                $preferences->setDefaultTimezone(true);
            }
        }

        if ($preferences->getDefaultTimezone()) {
            $view->assign('detect_users_timezone', true);
        }

        $view->assign('locale_rtl', $locale->isRtl());

        //systemConfig::$i18n = $language;

        $view->assign('CURRENT_LANG', $language);

        $filter_chain->next();
    }

    protected function chooseFirstLangMatch(array $accept)
    {
        $locales_names = array();
        foreach (fLocale::searchAll() as $locale) {
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