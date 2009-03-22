<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('faq');
fileLoader::load('orm/plugins/jipPlugin');
fileLoader::load('orm/plugins/acl_extPlugin');

/**
 * faqMapper: маппер
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'faq';
    protected $table = 'faq_faq';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once')),
        'question' => array(
            'accessor' => 'getQuestion',
            'mutator' => 'setQuestion'),
        'answer' => array(
            'accessor' => 'getAnswer',
            'mutator' => 'setAnswer'),
        'category_id' => array(
            'accessor' => 'getCategory',
            'mutator' => 'setCategory',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'faq/faqCategoryMapper',
            'options' => array(
                'once')),
    );

    public function __construct()
    {
        parent::__construct();
        $this->attach(new jipPlugin(), 'jip');
        $this->attach(new acl_extPlugin(), 'acl');
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        $do = $this->searchById($args['id']);

        if ($do) {
            return $do;
        }

        throw new mzzDONotFoundException();
    }
}

?>