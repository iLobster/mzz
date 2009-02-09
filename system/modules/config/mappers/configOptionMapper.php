<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('config/configOption');

/**
 * configOptionMapper: маппер
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

class configOptionMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'config';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'configOption';

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $this->table = 'sys_config';
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchAllByModuleName($moduleName)
    {
        return $this->searchAllByField('module_name', $moduleName);
    }

    public function getTypes()
    {
        return array(
            configOption::TYPE_INT => 'число',
            configOption::TYPE_STRING => 'строка',
            configOption::TYPE_BOOL => 'bool',
            configOption::TYPE_LIST => 'варианты',
        );
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        if (isset($args['id'])) {
            $do = $this->searchById($args['id']);
            if ($do) {
                return $do;
            }
        }
        throw new mzzDONotFoundException();
    }
}

?>