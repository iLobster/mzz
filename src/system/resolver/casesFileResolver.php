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

require_once systemConfig::$pathToSystem  . '/resolver/partialFileResolver.php';

/**
 * casesFileResolver: резолвит файлы с тестами
 * Примеры:
 * (запрос -> результат)
 * sometest.case -> cases/sometest.case.php
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class casesFileResolver extends partialFileResolver
{
    /**
     * конструктор
     *
     * @param object $resolver базовый резолвер
     */
    public function __construct(iResolver $resolver)
    {
        parent::__construct($resolver);
    }

    /**
     * проверка на соответствие запроса некоторому шаблону
     * определяем что файл действительно тот, который требуется
     *
     * @param string $request строка запроса
     * @return string|null переписанный запрос, если запрос совпадает с шаблоном, либо null
     */
    protected function partialResolve($request)
    {
        if (strpos($request, '.case') !== false) {
            return 'cases/' . $request . '.php';
        }
        return null;
    }
}

?>