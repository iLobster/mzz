<?php


class new_simpleForTree extends simple
{
    /**
     * ���� �� ���������� ����� �� ������
     *
     * @var arrayDataspace
     */
    protected $treeFields;

    /**
     * �����������.
     *
     * @param array $map ������, ���������� ���������� � �����
     */
    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);
        $this->treeFields = new arrayDataspace();
    }

    /**
     * ����� ��������� ������, �� ������� ��������� �������.
     *
     * @return integer
     */
    public function getTreeLevel()
    {
        if (!$this->treeFields->exists('id')) {
            $this->mapper->loadTreeData($this);
        }
        return $this->treeFields->get('level');
    }

    public function getTreeKey()
    {
        if (!$this->treeFields->exists('id')) {
            $this->mapper->loadTreeData($this);
        }
        return $this->treeFields->get('id');
    }

    public function getTreeParent()
    {
        return $this->mapper->getTreeParent($this);
    }

    public function importTreeFields(Array $data)
    {
        $this->treeFields->import($data);
    }

    public function getPath($simple = true)
    {
        $path = $this->__call('getPath', array());

        if ($simple) {
            $rootName = substr($path, 0, strpos($path, '/'));

            if ($rootName && strpos($path, $rootName) === 0 && strlen($path) > strlen($rootName)) {
                $path = substr($path, strlen($rootName) + 1);
            }
        }

        return $path;
    }

    /**
     * ���������� �������, ����������� � ������ �����
     *
     * @return array
     */
    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getId()));
        }
        return $this->fields->get('items');
    }

    /**
     * ���������� children-�����
     *
     * @return array
     */
    public function getFolders($level = 1)
    {
        if (!$this->fields->exists('folders')) {
            $folders = $this->mapper->getFolders($this, $level);
            array_shift($folders);
            $this->fields->set('folders', $folders);
        }
        return $this->fields->get('folders');
    }
}

?>