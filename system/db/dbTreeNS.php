<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage db
 * @version $Id$
*/

/**
 * dbTreeNS: работа с деревьями Nested Sets
 *
 * @package system
 * @subpackage db
 * @version 0.9a
*/

fileLoader::load('db/sqlFunction');
fileLoader::load('db/simpleSelect');

//@toDo searchByCriteria

class dbTreeNS
{
    /**
     * DB
     *
     * @var object
     */
    protected $db;

    /**
     * Имя таблицы содержащей дерево
     *
     * @var string
     */
    private $table;

    /**
     * Имя таблицы содержащей данные
     *
     * @var string
     */
    private $dataTable;

    /**
     * Select часть запроса
     *
     * @var string
     */
    private $selectPart;

    /**
     * Inner часть запроса
     *
     * @var string
     */
    private $innerPart;

    /**
     * Связывающее поле
     *
     * @var string
     */
    private $innerField;

    /**
     * Имя поля содержащего ключ таблицы данных
     *
     * @var string
     */
    private $dataID;

    /**
     * Имя поля содержащего ключ таблицы с деревом
     *
     * @var string
     */
    private $treeID;

    /**
     * Если true, то используется режим корректировки пути при выборки ветки на его основе
     * Включение режима увеличивает количество запросов на 1
     *
     * @var bool
     */
    private $correctPathMode;

    /**
     * Маппер для работы с таблицей данных
     *
     * @var simpleMapper
     */
    private $mapper;

    /**
     * Конструктор
     *
     * @param array  $init        Данные о таблицах и связывающих полях array( data => mapper,  tree => array(table,id))
     * @param array  $innerField  Имя поля которое будет использоватся для построения пути, листья дерева
     */
    public function __construct($init, $innerField = 'name')
    {
        $this->db = DB::factory();
        $this->setInnerField($innerField);

        // Устанавливаем маппер
        if(!empty($init['mapper']) && $init['mapper'] instanceof simpleMapper) {
            $this->setMapper($init['mapper']);

        } else {
            throw new mzzInvalidParameterException('Переменная $init[mapper] не является маппером ', $init['mapper']);

        }

        if(isset($init['treeField'])) {
            $this->treeField = $init['treeField'];
        }

        // данные о таблице с деревом
        $this->table = strtolower($init['treeTable']); // as tree

        // @toDo либо жестко закреплять ключ дерева либо в запросах также использовать
        $this->treeID = 'id';

        // данные о связывающем поле в таблице с данными (данные <-> дерево)
        // если поле не указано в init массиве выставляем поле id
        $this->dataID = isset($init['joinField']) ? $init['joinField'] : 'id';

        $this->selectPart = '*';


        $this->innerPart = ' JOIN ' . $this->dataTable . ' `data` ON `data`.' . $this->dataID . ' = `tree`.' . $this->treeID . ' ';

    }

    /**
     * Установка нового маппера
     *
     * @return string
     */
    public function setMapper(simpleMapper $mapper)
    {
        $this->mapper = $mapper;

        // новые данные о таблице с данными
        $this->dataTable = $this->mapper->getTable(); //as data
    }

    /**
     * Получение используемого маппера
     *
     * @return simpleMapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * Установка имени поля по которому идет связывание таблицы данных и таблицы структуры дерева
     *
     * @return string
     */
    public function setInnerField($tableField)
    {
        if (!(is_string($tableField) && strlen($tableField))) {
            throw new mzzInvalidParameterException('Переменная $tableField не является строкой и не может являтся именем поля таблицы ', $tableField);
        }
        $this->innerField = $tableField;
    }

    /**
     * Установка идентификатора поддерева
     *
     * @param  integer     $id    Идентификатор(значение доп. поля) по которому выделяется дерево
     * @return string
     * @toDo имя метода придумать другое?
     */
    public function setTree($id)
    {
        $this->treeFieldID = $id;
    }

    /**
     * Получение имени поля по которому идет связывание таблицы данных и таблицы структуры дерева
     *
     * @return string
     */
    public function getInnerField()
    {
        return $this->innerField ;
    }

    /**
     * Смена режима выборки узлов на основе пути
     *
     * @param  bool     $mode          Режим работы, с коррекцией пути или без
     */
    public function setCorrectPathMode($mode = false)
    {
        $this->correctPathMode = $mode;
    }

    /**
     * Построение пути на основе id записи
     *
     * @param  int     $id  Идентификатор узла в структуре дерева
     * @return string
     */
    public function createPathFromTreeByID($id)
    {
        $parentBranch = $this->getParentBranch($id, 9999999);

        if (!is_array($parentBranch)) {
            return null;
        }

        $path = '';
        foreach ($parentBranch as $node) {
            $fieldAccessor = 'get' . ucfirst($this->getInnerField());
            $path .= $node->$fieldAccessor() . '/';
        }
        return substr($path, 0, -1);
    }
    /**
     * Обновление поля path в таблице данных
     *
     * @param  int     $id  Идентификатор узла в структуре дерева
     * @return string
     */
    public function  updatePath($dataID)
    {
        $path = $this->createPathFromTreeByID($dataID);
        $this->db->query(' UPDATE ' . $this->dataTable . ' SET `path` = "'  .$path . '"  WHERE ' . $this->dataID . ' = ' . $dataID);

        return $path;
    }


    /**
     * Создание массива объектов из сырой выборки
     *
     * @param array $stmt   Выполненный стэйтмент
     * @return array of simple object
     */
    protected function createBranchFromRow($stmt)
    {
        $branch = array();
        while ($row = $stmt->fetch()) {
            //echo "<pre>row "; var_dump($row); echo "</pre>";
            $branch[$row[$this->dataID]] = $this->createItemFromRow($row);
            //echo "<pre>row "; var_dump($this->createItemFromRow($row)); echo "</pre>";
        }

        if (!empty($branch)) {
            return $branch;
        } else {
            return null;
        }
    }

    /**
     * Создание объекта из сырой выборки
     *
     * @param array $row Массив с данными о полях и их значениях
     * @return object simple
     */
    protected function createItemFromRow($row)
    {
        $do = $this->mapper->createItemFromRow($row);
        $do->setLevel($row['level']);
        $do->setRightKey($row['rkey']);
        $do->setLeftKey($row['lkey']);

        return $do;

    }


    /**
     * Выборка узлов по критерию
     *
     * @param  criteria $criteria Критерий для поиска
     * @return array of simpleForTree objects
     */
    public function searchByCriteria(criteria $criteria)
    {
        $criteria->addJoin($this->table, new criterion($this->dataTable . '.' . $this->dataID, $this->table . '.' . $this->treeID, criteria::EQUAL, true));

        if($this->isMultipleTree()) {
            $criteria->add(new criterion($this->table . '.' . $this->treeField, $this->treeFieldID));
        }

        $select = new simpleSelect($criteria);
        $stmt = $this->db->query($select->toString());

        return $this->createBranchFromRow($stmt);
    }
    /**
     * Добавление условия в критерий выборки
     *
     * @param  criteria   $criteria
     * @return criteria   $criteria
     */

    private function addSubTreeCondition(criteria &$criteria)
    {
        if($this->isMultipleTree()) {
            $criteria->add(new criterion($this->treeField, $this->treeFieldID));
        }
    }

    private function getBasisCriteria()
    {
        // @toDo бага, фича, фишка php5? возвращается ссылка на критерий,
        // а так как в методах в врзвращаемое значение добавляются условия, они добавляются и в basisCriteria
        // сделал клонирование
        if(!isset($this->basisCriteria)) {
            $this->basisCriteria= new criteria();

            // ставим алиас на таблицу со структурой дерева
            $this->basisCriteria->setTable($this->table, 'tree');

            //джойним таблицу с данными как `data`
            $this->basisCriteria->addJoin($this->dataTable, new criterion('tree.' . $this->treeID, 'data.' . $this->dataID, criteria::EQUAL, true), 'data', criteria::JOIN_INNER);

        }
        // если деревьев несколько, то добавляем условие для их разделения
        if($this->isMultipleTree()) {
            $this->basisCriteria->add(new criterion('tree.' .$this->treeField, $this->treeFieldID, criteria::EQUAL));
        } else {
            //@toDo подумать, как избавится. Хак для того чтобы в обоих случаях было выражение WHERE
            $this->basisCriteria->add( new criterion('id', 'tree.id', criteria::EQUAL, true));

        }

        return clone $this->basisCriteria;
    }

    private function getBasisQuery()
    {
        $select = new simpleSelect($this->getBasisCriteria());
        return $select->toString();
    }

    /**
     * Проверка, работаем с несколькими деревьями или нет.
     *
     * @return bool
     */
    private function isMultipleTree()
    {
        return isset($this->treeField) && isset($this->treeFieldID) && $this->treeFieldID > 0;
    }

    /**
     * Выборка дерева по левому обходу
     *
     * @param  int     $level   Уровень выборки дерева, по умолчанию все дерево
     * @return array
     */
    public function getTree($level = 0)
    {
        $criteria = $this->getBasisCriteria();

        // сортируем по левому ключу
        $criteria->setOrderByFieldDesc('tree.lkey');

        // если задана глубина выборки, добавляем условие
        if($level > 0) {
            $criteria->add(new criterion('tree.level', array(1, $level), criteria::BETWEEN));
        }

        $select = new simpleSelect($criteria);
        $stmt = $this->db->query($select->toString());
        //echo "<pre>getTree "; var_dump($select->toString()); echo "</pre>";
        $stmt->execute();

        return $this->createBranchFromRow($stmt);
    }

    /**
     * Выборка информации о узле
     *
     * @param  int     $id       Идентификатор узла
     * @return array
     */
    public function getNodeInfo($id)
    {
        $query = ' SELECT * FROM `' . $this->table . '` `tree` WHERE `tree`.`id` = ' . $id.
        ($this->isMultipleTree() ? ' AND `tree`.`' . $this->treeField . '`= ' . $this->treeFieldID: '');

        //echo "<pre>getNodeInfo query "; var_dump($query); echo "</pre>";

        $stmt = $this->db->query($query);

        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * Подготовка запроса по выборке ветки
     *
     * @param  bool     $withRootNode Условие выборки с корнем ветки
     * @return array
     */
    protected function getBranchStmt($withRootNode = true)
    {
        if ($withRootNode) {
            $less = '<=';
            $more = '>=';
        } else {
            $less = '<';
            $more = '>';
        }

        $stmt = $this->db->prepare($q= $this->getBasisQuery() .
        ' AND lkey ' . $more . ' :lkey AND rkey ' . $less . ' :rkey' .
        ' AND (`tree`.`level` BETWEEN :high_level AND :level)' .
        ' ORDER BY `tree`.`lkey`');

        //echo "<pre>getBranchStmt "; var_dump($q); echo "</pre>";

        return $stmt;
    }

    /**
     * Выборка ветки начиная от заданного узла
     *
     * @param  int     $id            Идентификатор узла
     * @param  int     $level         Уровень глубины выборки
     * @return array|false
     */
    public function getBranch($id, $level = 999999999)
    {
        $rootBranch = $this->getNodeInfo($id);
        if (!$rootBranch) {
            return null;
        }

        $stmt = $this->getBranchStmt();
        $level = $rootBranch['level'] + $level;
        $stmt->bindParam(':lkey', $rootBranch['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $rootBranch['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':high_level', $rootBranch['level'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $level, PDO::PARAM_INT);
        //echo "<pre>getBranch "; var_dump($stmt); echo "</pre>";

        if ($stmt->execute()) {
            return $this->createBranchFromRow($stmt);
        }
        return false;
    }

    /**
     * Выборка родительской ветки начиная от заданного узла
     *
     * @param  int     $id           Идентификатор узла
     * @param  int     $level        Уровень глубины выборки
     * @return array
     */
    public function getParentBranch($id, $level = 1)
    {
        $lowerChild = $this->getNodeInfo($id);
        if (!$lowerChild) {
            return null;
        }
        $highLevel = $lowerChild['level'] - $level;

        $stmt = $this->db->prepare(' SELECT ' . $this->selectPart .
        ' FROM ' . $this->table . ' `tree` '. $this->innerPart .
        ' WHERE lkey <= :lkey AND rkey >= :rkey' .
        ' AND ( level BETWEEN :level AND :child_level ) ' .
        ($this->isMultipleTree() ? 'AND `tree`.`' . $this->treeField . '` = :treeFieldID ' : '') .
        '  ORDER BY lkey');

        $stmt->bindParam(':treeFieldID', $this->treeFieldID, PDO::PARAM_INT);

        $stmt->bindParam(':lkey', $lowerChild['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $lowerChild['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':child_level', $lowerChild['level'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $highLevel, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->createBranchFromRow($stmt);
        }
        return false;
    }

    /**
     * Выборка ветки в которой находится заданный узел
     *
     * @param  int     $id           Идентификатор узла
     * @return array
     */
    public function getBranchContainingNode($id)
    {
        $node = $this->getNodeInfo($id);
        if (!$node) {
            return null;
        }

        $stmt = $this->db->prepare(' SELECT ' . $this->selectPart .
        ' FROM ' . $this->table . ' `tree` '. $this->innerPart .
        ' WHERE `tree`.`rkey` >:lkey ' .
        ($this->isMultipleTree() ? 'AND `tree`.`' . $this->treeField . '` = :treeFieldID ' : '') .
        ' AND `tree`.`lkey` <:rkey ORDER BY `tree`.`lkey`');

        $stmt->bindParam(':treeFieldID', $this->treeFieldID, PDO::PARAM_INT);

        $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
        //echo "<pre>"; var_dump($stmt); echo "</pre>";

        if ($stmt->execute()) {
            return $this->createBranchFromRow($stmt);
        }
        return false;
    }

    /**
     * Выборка ветки(нижележащих узлов) на основе пути до верхнего узла ветки
     *
     * @param  string     $path          Путь
     * @param  string     $deep          Глубина выборки
     * @return array|false array with nodes or false
     */
    public function getBranchByPath($path, $deep = 1)
    {
        if ($this->correctPathMode) {
            // убираем части пути несуществующие в таблице
            $rewritedPath = $this->getPathVariants($path);

        } else {
            // простая проверка на правильность пути, убираем лишние слэши
            $pathParts = explode('/', trim($path));
            foreach ($pathParts as $key => $part) {
                if (strlen($part) == 0 ) {
                    unset($pathParts[$key]);
                }
            }
            $rewritedPath[] = implode('/', $pathParts);
        }

        // Выбираем все существующие пути
        $query = '';

        foreach ($rewritedPath as $pathVariant) {
            if (strlen($pathVariant) == 0) {
                continue;
            }
            $query .= $this->getBasisQuery() . " AND `data`.`path` = '" . $pathVariant . "' UNION ";
        }

        $query = substr($query, 0, -6) ;
        //echo "<pre>getBranchByPath query "; var_dump($query); echo "</pre>";

        $stmt = $this->db->query($query);
        $existNodes = $stmt->fetchAll();

        // берем самый длинный существующий путь
        $lastNode = array_pop($existNodes);

        // выборка без исходного узла
        $stmt = $this->getBranchStmt(false);

        //echo "<pre>stmt "; var_dump($stmt); echo "</pre>";
        //echo "<pre>lastNode "; var_dump($lastNode); echo "</pre>";

        //$stmt->bindParam(':treeFieldID', $this->treeFieldID, PDO::PARAM_INT);

        $stmt->bindParam(':lkey', $lastNode['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $lastNode['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':high_level', $lastNode['level'], PDO::PARAM_INT);
        $stmt->bindParam(':level', $level = $lastNode['level'] + $deep, PDO::PARAM_INT);

        if ($stmt->execute()) {
            //echo "<pre>getBranchByPath"; echo "</pre>";
            return $this->createBranchFromRow($stmt);
        }
        return false;
    }

    /**
     * Выборка информации о родительском узле
     *
     * @param  int  $id  Идентификатор узла
     * @return array|null
     */
    public function getParentNode($id)
    {
        $node = $this->getNodeInfo($id);
        if (!$node) {
            return null;
        }

        $query = $this->getBasisQuery() .
        ' AND `tree`.lkey <= ' . $node['lkey'] .
        ' AND `tree`.rkey >= ' . $node['rkey'] .
        ' AND `tree`.level = ' . ($node['level'] - 1).
        ' ORDER BY `tree`.lkey';

        $row = $this->db->getRow($query);
        //echo "<pre>row "; var_dump($row); echo "</pre>";

        if ($row) {
            return $this->createItemFromRow($row);
        } else {
            return null;
        }

    }

    /**
     * Вставка узла ниже заданного, узел будет являтся листом дерева
     *
     * @param  simple object $newNode Объект уже вставленный в таблицу данных
     * @return simple object с заполненными полями о месте в дереве
     */
    public function insertNode($id, simple $newNode)
    {
        // @toDo а что теперь с проверкой на вставку в корень?
        if ($id == 0) {
            return $this->insertRootNode();
        }

        $parentNode = $this->getNodeInfo($id);

        $stmt = $this->db->prepare(' UPDATE ' . $this->table.
        ' SET rkey = rkey + 2, lkey = IF(lkey > :PN_RKey, lkey + 2, lkey)' .
        ' WHERE rkey >= :PN_RKey' .
        ($this->isMultipleTree() ? ' AND ' . $this->treeField . ' = ' . $this->treeFieldID : ' ')  );

        $stmt->bindParam(':PN_RKey',  $parentNode['rkey'], PDO::PARAM_INT);
        $stmt->execute();

        $query = ' INSERT INTO ' . $this->table.
        ' SET id = ' . $newNode->getId() .
        ', lkey = ' . $parentNode['rkey'] .
        ', rkey = ' . ($parentNode['rkey'] + 1) .
        ', level = ' . ($parentNode['level'] + 1).
        ($this->isMultipleTree() ? ', ' . $this->treeField . ' = ' . $this->treeFieldID : ' ');

        $this->db->exec($query);

        $newNode->setLevel($parentNode['level'] + 1);
        $newNode->setRightKey($parentNode['rkey'] + 1);
        $newNode->setLeftKey((int)$parentNode['rkey']);

        // обновление путей в таблице данных и в объекте
        $newNode->import(array('path' => $this->updatePath($newNode->getId())));

        return $newNode;
    }

    /**
     * Вставка корневого узла
     *
     * @return array
     */
    public function insertRootNode(simple $newRootNode)
    {
        $maxRightKey = $this->getMaxRightKey();
        $stmt = $this->db->prepare(' UPDATE ' .$this->table.
        ' SET rkey = rkey + 1, lkey = lkey + 1, level = level + 1');
        $stmt->execute();

        $stmt = $this->db->prepare(' INSERT INTO ' .$this->table.
        ' SET lkey = 1, rkey = :new_max_right_key, level = 1');
        $stmt->bindParam(':new_max_right_key', $v = $maxRightKey + 2, PDO::PARAM_INT);
        $stmt->execute();

        $newRootNode->setLevel(1);
        $newRootNode->setRightKey($maxRightKey + 2);
        $newRootNode->setLeftKey(1);

        // обновление путей в таблице данных и в объекте
        $newRootNode->import(array('path' => $this->updatePath($newRootNode->getId())));

        // добавление всем элементам в путь
        $this->db->exec(' UPDATE ' . $this->dataTable .
        ' SET `path` = CONCAT_WS("/", "' . $newRootNode->getPath(). '", path) WHERE ' .
        $this->dataID . '<>' . $newRootNode->getId());

        return $newRootNode;

    }

    /**
     * Удаление узла вместе с потомками
     *
     * @param  int     $id           Идентификатор удаляемого узла
     * @return bool
     */
    public function removeNode($id)
    {
        //удаление данных из таблицы данных
        $deletedBranch = $this->getBranch($id);
        foreach($deletedBranch as $node) {
            $this->mapper->delete($node->getId());
        }

        $node = $this->getNodeInfo($id);
        // удаление записей из дерева

        $query = '  DELETE  tree FROM ' . $this->table . ' `tree` WHERE ' .
        ' tree.lkey >= ' . $node['lkey'] . ' AND tree.rkey <= ' . $node['rkey'] .
        ($this->isMultipleTree() ? ' AND `tree`.`' . $this->treeField . '` = ' . $this->treeFieldID : ' ');
        $this->db->exec($query);

        // обновление дерева
        $stmt = $this->db->prepare(' UPDATE ' .$this->table.
        ' SET lkey = IF(lkey > :lkey, lkey - :val, lkey), rkey = rkey - :val'.
        ' WHERE rkey >= :rkey' .
        ($this->isMultipleTree() ? ' AND `' . $this->treeField . '` = ' . $this->treeFieldID : ' ')  );

        $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
        $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
        $stmt->bindParam(':val', $v = $node['rkey'] - $node['lkey'] + 1, PDO::PARAM_INT);

        return !$stmt->execute();
    }

    /**
     * Меняет узлы местами
     *
     * @param  int     $id1           Идентификатор первого перемещаемого узла
     * @param  int     $id2           Идентификатор второго перемещаемого узла
     * @return bool
     */
    public function swapNode($id1, $id2)
    {
        $node1 = $this->getNodeInfo($id1);
        $node2 = $this->getNodeInfo($id2);

        if (!$node1 || !$node2 || $node1 == $node2) {
            return false;
        }

        $stmt = $this->db->prepare(' UPDATE ' .$this->table.
        ' SET lkey = :lkey, rkey = :rkey, level = :level' .
        ' WHERE id = :id');

        foreach (array($id1 => $node2, $id2 => $node1) as $id => $node) {
            $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
            $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
            $stmt->bindParam(':level',$node['level'],PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        return !(bool)$stmt->errorCode();
    }

    /**
     * Перемещение узла вместе с потомками
     *
     * @param  int     $id           Идентификатор перемещаемого узла
     * @param  int     $parentId     Идентификатор нового родительского узла
     * @return bool
     */
    public function moveNode($id, $parentId)
    {
        $node = $this->getNodeInfo($id);
        $parentNode = $this->getNodeInfo($parentId);

        if ($id == $parentId || (!$node || !$parentNode)) {
            return false;
        }

        if ($parentNode['lkey'] >= $node['lkey'] && $parentNode['lkey'] <= $node['rkey']) {
            return false;
        }

        $level_up = ($notRoot = $parentNode['level'] != 1 ) ? $parentNode['level'] : 0;

        $query = ($notRoot) ?
        "SELECT (rkey - 1) AS rkey FROM " . $this->table . " WHERE id = " . $parentId :
        "SELECT MAX(rkey) as rkey FROM " . $this->table;

        if ($row = $this->db->getRow($query)) {
            $rkey = $row['rkey'];
            $right_key_near = $rkey;
            $skew_level = $level_up - $node['level'] + 1;
            $skew_tree = $node['rkey'] - $node['lkey'] + 1;

            $query = 'SELECT id FROM ' . $this->table . ' WHERE lkey >= :lkey AND rkey <= :rkey';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
            $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
            $stmt->execute();

            $id_edit = '';
            while ($row = $stmt->fetch()) {
                $id_edit .= ($id_edit != '') ? ', ' : '';
                $id_edit .= $row['id'];
            }

            if ( $node['rkey'] > $right_key_near ) {
                $skew_edit = $right_key_near - $node['lkey'] + 1;

                $query = "UPDATE " . $this->table . ' SET rkey = rkey + :skew_tree WHERE rkey < :lkey AND rkey > :right_key_near';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':skew_tree', $skew_tree, PDO::PARAM_INT);
                $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
                $stmt->bindParam(':right_key_near', $right_key_near, PDO::PARAM_INT);
                $stmt->execute();

                $query = 'UPDATE ' . $this->table . ' SET lkey = lkey + :skew_tree WHERE lkey < :lkey AND lkey > :right_key_near';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':skew_tree', $skew_tree, PDO::PARAM_INT);
                $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
                $stmt->bindParam(':right_key_near', $right_key_near, PDO::PARAM_INT);
                $stmt->execute();

                $query = 'UPDATE ' . $this->table . ' SET lkey = lkey + :skew_edit , rkey = rkey + :skew_edit , level = level + :skew_level WHERE id IN ( :id_edit )';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':skew_edit', $skew_edit, PDO::PARAM_INT);
                $stmt->bindParam(':skew_level', $skew_level, PDO::PARAM_INT);
                $stmt->bindParam(':id_edit', $id_edit, PDO::PARAM_STR);
                $stmt->execute();
                /*
                @todo отладить запрос, он является суммой предыдущих трех. Навроде все правильно, но только навроде.

                $query = 'UPDATE ' . $this->table .
                ' SET lkey = IF(rkey <=' . $node['rkey'] . ', lkey + ' . $skew_edit . ', IF(lkey > ' . $node['rkey'] . ', lkey - ' . $skew_tree . ', lkey)),'.
                ' level = IF(rkey <= ' . $node['rkey'] . ', level + ' . $skew_level . ', level),' .
                ' rkey = IF(rkey <= ' . $node['rkey'] . ', rkey + ' . $skew_edit . ', IF(rkey <= ' . $right_key_near . ', rkey - ' . $skew_tree . ' , rkey))' .
                ' WHERE rkey > ' . $node['lkey'] . ' AND lkey <= ' . $right_key_near ;
                */
            } else {

                $skew_edit = $right_key_near - $node['lkey'] + 1 - $skew_tree;
                $query = 'UPDATE ' . $this->table .
                ' SET lkey = IF(rkey <= :rkey, lkey + :skew_edit, IF(lkey > :rkey , lkey - :skew_tree , lkey)),' .
                ' level = IF(rkey <= :rkey, level + :skew_level, level), rkey = IF(rkey <= :rkey, rkey + :skew_edit,' .
                ' IF(rkey <= :right_key_near , rkey - :skew_tree, rkey)) WHERE rkey > :lkey AND lkey <= :right_key_near';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':rkey', $node['rkey'], PDO::PARAM_INT);
                $stmt->bindParam(':lkey', $node['lkey'], PDO::PARAM_INT);
                $stmt->bindParam(':skew_tree', $skew_tree, PDO::PARAM_INT);
                $stmt->bindParam(':skew_edit', $skew_edit, PDO::PARAM_INT);
                $stmt->bindParam(':skew_level', $skew_level, PDO::PARAM_INT);
                $stmt->bindParam(':right_key_near', $right_key_near, PDO::PARAM_INT);
                $stmt->execute();
            }

            // обновление путей в таблице данных
            if ($this->dataTable) {
                $movedBranch = $this->getBranch($parentId);

                $oldPathToRootNodeOfBranch = $movedBranch[$id]->getPath();
                $newPathToRootNodeOfBranch = $this->updatePath($id);

                // если переместили один элемент под узел нижнего уровня, то обновлять пути не надо
                if(count($movedBranch) == 2 && isset($movedBranch[$parentId]) && isset($movedBranch[$id])) {
                    return true;

                }

                $idSet = '(';
                foreach ($movedBranch as $i => $node) {
                    if ($i == $parentId || $i == $id) {
                        continue;
                    }
                    $idSet .= $i . ',';
                }

                $idSet = substr($idSet, 0, -1) . ')';

                $this->db->exec(' UPDATE ' . $this->dataTable .
                ' SET path = REPLACE(path, "' . $oldPathToRootNodeOfBranch . '", "' . $newPathToRootNodeOfBranch . '") '.
                ' WHERE ' . $this->dataID . ' IN ' . $idSet);
            }
            return true;
        }
    }

    /**
     * Выборка максимального правого ключа
     *
     * @return int
     */
    public function getMaxRightKey()
    {
        return (int)$this->db->getOne(' SELECT MAX(rkey) FROM ' .$this->table);
    }

    /**
     * Выборка массива содержащего возможные существующие варианты пути
     *
     * @param  string     $path          Путь
     * @return array array with id
     */
    protected function getPathVariants($path)
    {
        $pathParts = explode('/', trim($path));

        $queryTemplate = ' SELECT *  FROM ' . $this->table . ' `tree` ' . $this->innerPart . ' WHERE ';
        $query = '';

        foreach ($pathParts as $pathPart) {
            if (strlen($pathPart) == 0) {
                continue;
            }
            $query .= $queryTemplate . '`' . $this->innerField . "` = '" . $pathPart . "' UNION ";
        }

        $query = substr($query, 0, -6);

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $existNodes = $stmt->fetchAll();

        $rewritedPath = array();
        foreach ($existNodes as $i => $node) {
            if ($i == 0) {
                $rewritedPath[$i] = $node[$this->innerField];
            } else {
                $rewritedPath[$i] = $rewritedPath[$i - 1] . '/' . $node[$this->innerField];
            }
        }

        return $rewritedPath;

    }

    /**
     * Создание поля для хранения путей
     *
     */
    public function createPathField()
    {
        if (isset($this->dataTable)) {
            $this->db->query('ALTER TABLE ' . $this->dataTable . ' ADD `path` char(255)');
        }
    }
}



?>
