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
 * {{$mapper_data.mapper_name}}: ������
 *
 * @package {{$mapper_data.module}}
 * @version 0.1
 */

class {{$mapper_data.doname}} extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = '{{$mapper_data.module}}';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = '{{$mapper_data.doname}}';

    /**
     * ������ ���������� �������
     *
     * @var array
     */
      protected $cacheable = array();

    /**
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section)
    {
        parent::__construct($section);
    }

    /**
     * ������� ������ ������ DO
     *
     * @return object
     */
    public function create()
    {
        return new {{$mapper_data.doname}}($this, $this->getMap());
    }
}


?>