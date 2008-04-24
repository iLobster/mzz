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
        $me = systemToolkit::getInstance()->getUser();

        if ($me->getId() != $session->get($lastUserIdVarName)) {
            // если поменялся id пользователя - стираем значение в сессии
            $session->destroy(self::$sessionVarName);
            $session->destroy(self::$timezoneVarName);
            $session->set($lastUserIdVarName, $me->getId());
            $session->set(self::$skinVarName, $me->getSkin()->getName());
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
                        $language = $locale->getName();
                    } else {
                        // смотрим в куках
                        if (!($language = $request->getString(self::$sessionVarName, SC_COOKIE))) {
                            // смотрим в заголовках
                            // @todo: реализовать
                            $language = systemConfig::$i18n;
                        }
                    }
                }
            }
        } else {
            $language = systemConfig::$i18n;
        }

        if ($session->get(self::$sessionVarName) != $language) {
            // устанавливаем язык в куку
            $response->setCookie(self::$sessionVarName, $language, strtotime('+1 year'));

            // если текущее значение языка не совпадает с тем, которое в профиле - заменяем его
            $me = systemToolkit::getInstance()->getUser();
            if ($me->isLoggedIn()) {
                $locale = new locale($language);
                if ($me->getLanguageId() != $locale->getId()) {
                    $me->setLanguageId($locale->getId());
                    $me->getMapper()->save($me);
                }
            }

            $session->set(self::$sessionVarName, $language);

            $tz = $me->getTimezone();

            $session->set(self::$timezoneVarName, $tz);
        }

        //systemConfig::$i18n = $language;
        systemToolkit::getInstance()->setLocale($language);

        $filter_chain->next();
    }
}

?>