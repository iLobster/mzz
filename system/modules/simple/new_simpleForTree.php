<?php


class new_simpleForTree extends simple
{
    /**
     * Поля со значениями полей из дерева
     *
     * @var arrayDataspace
     */
    protected $treeFields;

    /**
     * Конструктор.
     *
     * @param array $map массив, содержащий информацию о полях
     */
    public function __construct($mapper, Array $map)
    {
        parent::__construct($mapper, $map);
        $this->treeFields = new arrayDataspace();
    }

    /**
     * Метод получения уровня, на котором находится элемент.
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

    /**
     * Возвращает children-папки
     *
     * @return array
     */
    public function getFolders($level = 1)
    {
        // @todo: реализовать
        /*        if (!$this->fields->exists('folders')) {
        $folders = $this->mapper->getFolders($this->getParent(), $level);
        array_shift($folders);
        $this->fields->set('folders', $folders);
        }
        return $this->fields->get('folders');*/
    }
}

?>