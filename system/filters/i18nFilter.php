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
 * i18nFilter: фильтр для определения дефолтного языка приложения
 *
 * @package system
 * @subpackage filters
 * @version 0.1.1
 */
class i18nFilter implements iFilter
{
    static public $sessionVarName = 'mzz_i18n_language';

    static public $timezoneVarName = 'mzz_i18n_timezone';

    static public $timezoneDefaultVarName = 'mzz_i18n_timezone_default';

    static public $skinVarName = 'mzz_skin';

    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $lastUserIdVarName = self::$sessionVarName . '_last_user_id';

        $session = systemToolkit::getInstance()->getSession();
        $smarty = systemToolkit::getInstance()->getSmarty();
        $me = systemToolkit::getInstance()->getUser();

        if ($me->getId() != $session->get($lastUserIdVarName)) {
            // если поменялся id пользователя - стираем значение в сессии
            $session->destroy(self::$sessionVarName);
            $session->destroy(self::$timezoneVarName);
            $session->destroy(self::$skinVarName);
            $session->set($lastUserIdVarName, $me->getId());
        }

        // если приложение мультиязычное
        if (systemConfig::$i18nEnable) {
            // смотрим в урле
            if (!($language = $request->getString('lang'))) {
                // смотрим в сессии
                if (!($language = $session->get(self::$sessionVarName))) {
                    // смотрим, есть ли в профиле пользователя
                    if ($language_id = $me->getLanguageId()) {
                        $locale = locale::searchAll($language_id);
                        $language = $locale ? $locale->getName() : null;
                    } else {
                        // смотрим в заголовках
                        $locales_names = array();
                        foreach (locale::searchAll() as $locale) {
                            $locales_names[] = $locale->getName();
                        }
                        preg_match_all('/[a-z]{2}/', $request->getServer('HTTP_ACCEPT_LANGUAGE'), $accept_langs);
                        $accept_langs = array_unique($accept_langs[0]);

                        foreach ($accept_langs as $accept_lang) {
                            if (in_array($accept_lang, $locales_names)) {
                                $language = $accept_lang;
                                break;
                            }
                        }
                    }
                }
            }
        }

        if (empty($language)) {
            $language = systemConfig::$i18n;
        }

        if (!$session->exists(self::$skinVarName)) {
            // если в сессии не установлен скин
            $session->set(self::$skinVarName, $me->getSkin()->getName());
        }

        if (!$session->exists(self::$sessionVarName)) {
            // если в сессии не установлен язык
            $session->set(self::$sessionVarName, $language);

            $tz = $me->getTimezone();

            $session->set(self::$timezoneVarName, $tz);

            if (!$me->isLoggedIn()) {
                $session->set(self::$timezoneDefaultVarName, true);
            }
        }

        if ($session->exists(self::$timezoneDefaultVarName)) {
            $smarty->assign('detect_users_timezone', true);
        }

        $locale = systemToolkit::getInstance()->getLocale();
        $smarty->assign('locale_rtl', $locale->isRtl());

        //systemConfig::$i18n = $language;
        systemToolkit::getInstance()->setLocale($language);

        $smarty->assign('CURRENT_LANG', $language);

        $filter_chain->next();
    }
}

?>