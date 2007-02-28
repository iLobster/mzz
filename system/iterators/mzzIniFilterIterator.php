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

/**
 * mzzIniFilterIterator: ������� Iterator ��� "�������" ������ � ����������� 'ini'
 *
 * @package system
 * @version 0.1
 */
class mzzIniFilterIterator extends FilterIterator
{

    /**
     * ���������� true ���� ������� ������� ����� ���������� ini � �� ����
     *
     * @return boolean
     */
    public function accept()
    {
        return (substr($this->getFilename(), -4) == '.ini') && $this->isFile();
    }

}

?>