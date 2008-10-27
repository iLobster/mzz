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
 * contentFilter: фильтр получения и отображения контента
 *
 * @package system
 * @subpackage filters
 * @version 0.2.8
 */
class contentFilter implements iFilter
{
    /**
     * Префикс имени активного шаблона
     *
     */
    const TPL_PRE = "act/";

    /**
     * Расширение активного шаблона
     *
     */
    const TPL_EXT = ".tpl";

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

        $tplPath = systemConfig::$pathToApplication . '/templates';

        try {
            $template = $this->getTemplateName($request, $tplPath);
        } catch (mzzRuntimeException $e) {
            if (DEBUG_MODE) {
                throw $e;
            }

            $output = $this->get404();
            if ($output === false) {
                $template = $this->getTemplateName($request, $tplPath);
            }
        }

        $smarty = $toolkit->getSmarty();
        // @todo подумать нужны ли в шаблоне теперь эти переменные
        //страйкер: конечно нужны. как без них? в большинстве {url используется section=$current_section. Но предлагаю просто передать объект $request в смарти.
        $smarty->assign('current_section', $request->getRequestedSection());
        $smarty->assign('current_action', $request->getRequestedAction());
        $smarty->assign('current_path', $request->getPath());
        $smarty->assign('current_lang', $toolkit->getLocale()->getName());
        $smarty->assign('available_langs', $toolkit->getLocale()->searchAll());

        // если вывода ещё не было (не 404 страница), или был (404, но вернувшая false - что значит что должен быть запущен стандартный запуск через активный шаблон)
        if (!isset($output) || $output === false) {
            $output = $smarty->fetch($template);
        }

        $response->append($output);

        $filter_chain->next();
    }

    /**
     * Вывод страницы 404
     *
     */
    private function get404()
    {
        fileLoader::load('simple/simple404Controller');
        $controller = new simple404Controller(true);
        return $controller->run();
    }

    /**
     * получение имени шаблона
     *
     * @param iRequest $request
     * @param string $path путь до папки с шаблонами
     * @return string имя шаблона в соответствии с запрошенной секцией и экшном
     */
    public function getTemplateName($request, $path)
    {
        $section = $request->getSection();
        $action = $request->getAction();

        $tpl_name = self::TPL_PRE . $section . '/' . $action . self::TPL_EXT;
        if (file_exists($path . '/' . $tpl_name)) {
            return $tpl_name;
        }
        throw new mzzRuntimeException('Не найден активный шаблон: <i>' . $path . '/' . $tpl_name . '</i>');
    }
}

?>