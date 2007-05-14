<?php
class stubMapperForTreeNonIdTest extends simpleMapper
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
        $this->table = 'simple_stubSimple3';
    }
    
    /**
     * ��������� ������� �� ������� �������� ������
     *
     * @param array $row ������ � �������
     * @return object
     */
    public function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        return $object;
    }    


    public function convertArgsToId($args)
    {
    }
}
?>