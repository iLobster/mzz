<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/orm/system/entity.php $
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: entity.php 2928 2009-01-14 05:53:47Z zerkms $
 */

/**
 * lazy: the class incapsulates information for lazy loading
 *
 * @package system
 * @subpackage orm
 * @version 0.1
 */
class lazy
{
    private $type;

    private $mapper;
    private $key;
    private $value;

    private $ref_foreign_key;
    private $foreign_key;
    private $reference;

    private $callback;

    public function getValue()
    {
        return ($this->type == "mapperOne" || $this->type == "mapperManyToMany") ? $this->value : null;
    }

    public function __construct(array $data)
    {
        if ($data[0] instanceof mapper) {
            if (count($data) == 3 || count($data) == 4) {
                $this->type = empty($data[3]) ? 'mapperCollection' : 'mapperOne';

                $this->mapper = $data[0];
                $this->key = $data[1];
                $this->value = $data[2];
            } elseif (count($data) == 6) {
                $this->type = 'mapperManyToMany';

                $this->mapper = $data[0];
                $this->key = $data[1];
                $this->value = $data[2];
                $this->ref_foreign_key = $data[3];
                $this->foreign_key = $data[4];
                $this->reference = $data[5];
            }
        } else {
            $this->type = 'callback';

            $this->callback = array(
                $data[0],
                $data[1]);
            $this->value = $data[2];
        }
    }

    public function load($args = array())
    {
        $method = 'load' . ucfirst($this->type);
        return $this->$method($args);
    }

    private function loadMapperCollection()
    {
        $collection = $this->mapper->searchAllByField($this->key, $this->value);
        $collection->setParams($this->key, $this->value);
        return $collection;
    }

    private function loadMapperOne()
    {
        return $this->mapper->searchOneByField($this->key, $this->value);
    }

    private function loadMapperManyToMany()
    {
        $criterion = new criterion('reference.' . $this->ref_foreign_key, $this->mapper->table() . '.' . $this->foreign_key, criteria::EQUAL, true);
        $criterion->addAnd(new criterion('reference.' . $this->key, $this->value));

        $criteria = new criteria();
        $criteria->addJoin($this->reference, $criterion, 'reference', criteria::JOIN_INNER);

        $collection = $this->mapper->searchAllByCriteria($criteria);

        $modifyCriteria = new criteria($this->reference);
        $collection->setMtoMParams($this->value, $this->key, $this->ref_foreign_key, $modifyCriteria);

        return $collection;
    }

    private function loadCallback($args)
    {
        return call_user_func_array($this->callback, array_merge($this->value, $args));
    }
}

?>