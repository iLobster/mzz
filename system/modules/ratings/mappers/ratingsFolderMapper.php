<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('ratings/ratingsFolder');

/**
 * ratingsFolderMapper: маппер
 *
 * @package modules
 * @subpackage ratings
 * @version 0.1
 */

class ratingsFolderMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'ratings';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'ratingsFolder';

    /**
     * Количество звезд голосования
     *
     * @var integer
     */
    const STARS_COUNT = 5;

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        if (isset($args['id'])) {
            $folder = $this->searchOneByField('parent_id', $args['id']);

            if (is_null($folder)) {
                $toolkit = systemToolkit::getInstance();
                $request = $toolkit->getRequest();
                $ownerId = $request->getRaw('owner');

                $owner = null;
                if (is_a($ownerId, 'user')) {
                    $owner = $ownerId;
                } else {
                    $userMapper = $toolkit->getMapper('user', 'user', 'user');
                    $owner = $userMapper->searchById((int)$ownerId);
                }

                if ($owner) {
                    $folder = $this->create();
                    $folder->setParentId($args['id']);
                    $this->save($folder, $owner);
                }
            }

            if ($folder) {
                return $folder;
            }
        }

        throw new mzzDONotFoundException();
    }
}

?>