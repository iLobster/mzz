<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * compositeResolver: реализация паттерна composite для резолверов
 * содержит группу резолверов, которые по запросу начинает поочерёдно опрашивать
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

class compositeResolver implements iResolver
{
    /**
     * массив для хранения резолверов
     *
     * @var array
     */
    private $resolvers = array();

    /**
     * метод для добавления резолверов
     *
     * @param object $resolver
     */
    public function addResolver(iResolver $resolver)
    {
        $this->resolvers[] = $resolver;
    }

    /**
     * подача запроса, запуск поочерёдно резолверов
     * продолжается до тех пор, пока один из резолверов не вернёт строку с результатом
     *
     * @param string $request запрос
     * @return string|null путь к файлу, если запрос обработан одним из резолверов, либо null
     */
    public function resolve($request)
    {
        foreach ($this->resolvers as $resolver) {
            if (null !== ($filename = $resolver->resolve($request))) {
                return $filename;
            }
        }
        return null;
    }
}

?>