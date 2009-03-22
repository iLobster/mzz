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

fileLoader::load('faq/faqCategory');
fileLoader::load('orm/plugins/jipPlugin');
fileLoader::load('orm/plugins/acl_extPlugin');

/**
 * faqCategoryMapper: маппер
 *
 * @package modules
 * @subpackage faq
 * @version 0.1
 */

class faqCategoryMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'faqCategory';
    protected $table = 'faq_faqCategory';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once')),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName'),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle'),
        'answers' => array(
            'accessor' => 'getAnswers',
            'mutator' => 'setAnswers',
            'relation' => 'many',
            'foreign_key' => 'category_id',
            'local_key' => 'id',
            'mapper' => 'faq/faqMapper'),
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

    public function getAnswers($id)
    {
        $faqMapper = systemToolkit::getInstance()->getMapper('faq', 'faq');
        return $faqMapper->searchAllByField('category_id', $id);
    }

    public function delete(faqCategory $do)
    {
        $faqMapper = systemToolkit::getInstance()->getMapper('faq', 'faq');
        foreach ($do->getAnswers() as $faq) {
            $faqMapper->delete($faq->getId());
        }
        parent::delete($do->getId());
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        $do = $this->searchByName($args['name']);

        if ($do) {
            return $do;
        }

        throw new mzzDONotFoundException();
    }
}

?>