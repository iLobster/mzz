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

require_once systemConfig::$pathToSystem . '/resolver/partialFileResolver.php';

/**
 * moduleResolver: резолвит файлы модулей
 *
 * @package system
 * @subpackage resolver
 * @version 0.1.1
 */
class moduleResolver extends partialFileResolver
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
        $result = null;

        // короткий вид nameFactory переписываем в name/nameFactory
        if (preg_match('/^([a-z0-9_]+)Factory$/i', $request, $matches)) {
            $request = $matches[1] . '/' . $request;
        }

        if (preg_match('/^[a-z0-9_]+$/i', $request)) {
            $result = 'modules/' . $request . '/' . $request;
        } elseif (preg_match('/^[a-z0-9_]+(\/[a-z0-9\._]+)+$/i', $request)) {
            $result = 'modules/' . $request;
        }

        $ext = substr(strrchr($request, '.'), 1);
        if ($ext != 'php' && $ext != 'ini' && $ext != 'xml') {
            $result .= '.php';
        }

        return $result;
    }
}

?>