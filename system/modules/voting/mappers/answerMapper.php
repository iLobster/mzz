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

fileLoader::load('voting/answer');

/**
 * answerMapper: ������
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class answerMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'voting';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'answer';

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function getAnswersTypes()
    {
        return array(
            0 => 'radio',
            1 => 'checkbox',
            2 => 'text'
        );
    }

    public function delete($id)
    {
        $voteMapper = systemToolkit::getInstance()->getMapper('voting', 'vote');
        $voteMapper->deleteByAnswer($id);
        parent::delete($id);
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        return 1;
    }
}

?>