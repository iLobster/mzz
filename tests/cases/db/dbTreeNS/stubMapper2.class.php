<?php

class stubMapperForMultipleTree extends simpleMapper
{
    protected $name = 'simple';
    protected $className = 'stubSimpleForTree';

    /**
     * �����������
     *
     * @param string $section ������
     * @param string $alias �������� ���������� � ��
     */
    public function __construct($section, $alias = 'default')
    {
        parent::__construct($section, $alias);
        $this->table = 'simple_stubSimple2';
    }


    public function convertArgsToObj($args)
    {
    }
}

?>