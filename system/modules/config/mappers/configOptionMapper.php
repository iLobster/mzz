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
 * @version 0.3
 */
class configOptionMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'configOption';
    protected $table = 'sys_config';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array('pk','once')
         ),
        'module_name' => array(
            'accessor' => 'getModuleName',
            'mutator' => 'setModuleName',
            'options' => array('once'),
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName'
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle'
        ),
        'type_id' => array(
            'accessor' => 'getType',
            'mutator' => 'setType'
        ),
        'value' => array(
            'accessor' => 'getValue',
            'mutator' => 'setValue'
        ),
        'args' => array(
            'accessor' => 'getArgs',
            'mutator' => 'setArgs'
        )
    );

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchOption($module, $name)
    {
        $criteria = new criteria;
        $criteria->add('module_name', $module)->add('name', $name);
        return $this->searchOneByCriteria($criteria);
    }

    public function searchAllByModuleName($moduleName)
    {
        return $this->searchAllByField('module_name', $moduleName);
    }

    public function getModuleOptions($moduleName)
    {
        $config = array();
        foreach ($this->searchAllByModuleName($moduleName) as $option) {
            switch ($option->getType()) {
                case configOption::TYPE_INT:
                    $config[$option->getName()] = (int)$option->getValue();
                    break;

                case configOption::TYPE_STRING:
                    $config[$option->getName()] = (string)$option->getValue();
                    break;

                case configOption::TYPE_BOOL:
                    $config[$option->getName()] = (bool)$option->getValue();
                    break;
            }
        }

        return new arrayDataspace($config);
    }

    public static function getTypes()
    {
        return array(
            configOption::TYPE_INT => 'число',
            configOption::TYPE_STRING => 'строка',
            configOption::TYPE_BOOL => 'bool',
            //configOption::TYPE_LIST => 'варианты',
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