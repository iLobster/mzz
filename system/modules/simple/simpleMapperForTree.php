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

fileLoader::load('db/dbTreeNS');
fileLoader::load('simple/simpleForTree');

/**
 * simpleMapperForTree: маппер для работы с древовидными структурами
 *
 * @package system
 * @version 0.2.3
 */

abstract class simpleMapperForTree extends simpleMapper
{
	/**
     * Массив для хранения временных данных о дереве (до добавления их в объект)
     *
     * @var array
     */
	protected $treeTmp = array();

	/**
     * Параметры дерева (имя таблицы, имя поле по которому происходит связывание, имя поля для указания пути, имя узла)
     *
     * @var array
     */
	protected $treeParams = array();

	/**
     * Конструктор
     *
     * @param string $section имя раздела
     */
	public function __construct($section)
	{
		parent::__construct($section);
		$this->treeParams = array_merge(self::getTreeParams(), $this->getTreeParams());
		$this->tree = new dbTreeNS($this->treeParams, $this);
	}

	/**
     * Установка id дерева (в случае если в таблицах хранится несколько древовидных структур одновременно)
     *
     * @param integer $tree_id
     */
	public function setTree($tree_id)
	{
		$this->tree->setTree($tree_id);
	}

	/**
     * Получение параметров дерева
     *
     * @return array
     */
	protected function getTreeParams()
	{
		return array('nameField' => 'name', 'pathField' => 'path', 'joinField' => 'parent', 'tableName' => $this->table . '_tree', 'treeIdField' => 'tree_id');
	}

	/**
     * Получение корневого элемента дерева
     *
     * @return simpleForTree
     */
	public function getRoot()
	{
		$criteria = new criteria();
		$criteria->add('tree.lkey', 1);
		return $this->searchOneByCriteria($criteria);
	}

	/**
     * Поиск узла по пути
     *
     * @param string $path
     * @return simpleForTree
     */
	public function searchByPath($path)
	{
		if (strpos($path, '/') === 0) {
			$path = substr($path, 1);
		}

		$root = $this->getRoot();
		$accessor = $this->map[$this->treeParams['nameField']]['accessor'];
		$rootName = $root->$accessor();

		if (strpos($path, $rootName) !== 0) {
			$path = $rootName . '/' . $path;
		}

		if (substr($path, -1) == '/') {
			$path = substr($path, 0, -1);
		}

		return $this->searchOneByField($this->treeParams['pathField'], $path);
	}

	/**
     * Поиск узла по критерию
     *
     * @param criteria $criteria
     * @return simpleForTree
     */
	protected function searchByCriteria(criteria $criteria)
	{
		$this->tree->addSelect($criteria);
		$this->tree->addJoin($criteria);

		return parent::searchByCriteria($criteria);
	}

	/**
     * Получение наследников
     *
     * @param simpleForTree $id испомый узел
     * @param integer $level глубина выборки
     * @return array
     */
	public function getFolders(simpleForTree $id, $level = 1)
	{
		return $this->getBranch($id, $level);
	}

	/**
     * Получение ветки дерева, начиная с искомого узла
     *
     * @param simpleForTree $target искомый узел дерева
     * @param integer $level число выбираемых уровней
     * @return array массив найденных элементов
     */
	public function getBranch(simpleForTree $target, $level = 0)
	{
		$criteria = new criteria();
		$this->tree->addSelect($criteria);
		$this->tree->addJoin($criteria);
		$this->tree->getBranch($criteria, $target, $level);

		$stmt = parent::searchByCriteria($criteria);

		$result = array();

		while ($row = $stmt->fetch()) {
			$data = $this->fillArray($row);
			$result[$data[$this->tableKey]] = $this->createItemFromRow($data);
		}

		return $result;
	}

	/**
     * Получение всех предков искомого узла
     *
     * @param simpleForTree $node
     * @return array
     */
	public function getParentBranch(simpleForTree $node)
	{
		$criteria = new criteria();
		$this->tree->addSelect($criteria);
		$this->tree->addJoin($criteria);
		$this->tree->getParentBranch($criteria, $node);

		$stmt = parent::searchByCriteria($criteria);

		$result = array();

		while ($row = $stmt->fetch()) {
			$data = $this->fillArray($row);
			$result[$data[$this->tableKey]] = $this->createItemFromRow($data);
		}

		return $result;
	}

	/**
     * Получение предка искомого узла
     *
     * @param simpleForTree $child
     * @return simpleForTree
     */
	public function getTreeParent(simpleForTree $child)
	{
		$criteria = new criteria();
		$this->tree->addSelect($criteria);
		$this->tree->addJoin($criteria);
		$this->tree->getParentNode($criteria, $child);

		$stmt = parent::searchByCriteria($criteria);

		if ($row = $stmt->fetch()) {

			$row = $this->fillArray($row);
			$parent = $this->createItemFromRow($row);

			return $parent;
		}

		return null;
	}

	/**
     * Сохранение корневого узла
     *
     * @param simpleForTree $object
     * @param user $user
     */
	public function insertRoot(simpleForTree $object, $user = null)
	{
		// получаем сохраняемую инфу
		$data = $object->export();

		$mutator = $this->map[$this->treeParams['joinField']]['mutator'];
		$accessor = $this->map[$this->treeParams['joinField']]['accessor'];


		$id = $this->tree->insertRoot();
		$object->$mutator($id);

		$result = parent::save($object, $user);

		// получаем информацию об узле из дерева
		$node = $this->tree->getNodeInfo($object->$accessor());

		// импортируем эту информацию
		$object->importTreeFields($node);

		// если поле, являющееся именем узла, было изменено - модифицируем пути этого узла и всех вложенных в него
		if (isset($data[$this->treeParams['nameField']])) {
			// получаем всех предков данного узла, вложенность 1 уровень
			$branch = $this->getBranch($object, 1);

			$pathAccessor = $this->map[$this->treeParams['pathField']]['accessor'];
			$pathMutator = $this->map[$this->treeParams['pathField']]['mutator'];
			$nameAccessor = $this->map[$this->treeParams['nameField']]['accessor'];
			$nameMutator = $this->map[$this->treeParams['nameField']]['mutator'];

			// модифицируем путь текущего узла
			$baseName = $object->$nameAccessor();
			$object->$pathMutator($baseName);
			// сохраняем текущий объект
			$this->save($object);

			// удаляем текущий объект из массива
			array_shift($branch);
			// обходим всех предков
			foreach ($branch as $key => $val) {
				// рекурсивно вызываем функцию модификации путей и для всех предков
				$val->$nameMutator($val->$nameAccessor());
				$this->save($val);
			}
		}
	}

	/**
     * Сохранение объекта
     *
     * @param simpleForTree $object
     * @param simpleForTree $target узел, в который сохраняется объект (в случае - если происходит создание)
     * @param user $user
     */
	public function save(simpleForTree $object, $target = null, $user = null)
	{
		// получаем сохраняемую инфу
		$data = $object->export();

		$mutator = $this->map[$this->treeParams['joinField']]['mutator'];
		$accessor = $this->map[$this->treeParams['joinField']]['accessor'];

		// если объект создаётся - ищем узел, в который он будет вложен
		if (!$object->getId()) {
			//$node = $this->tree->getNodeInfo($target);
			$id = $this->tree->insert($target);
			$object->$mutator($id);
		} else {
			// иначе получаем родительский узел
			$target = $this->getTreeParent($object);
		}

		$result = parent::save($object, $user);

		// получаем информацию об узле из дерева
		$node = $this->tree->getNodeInfo($object->$accessor());

		// импортируем эту информацию
		$object->importTreeFields($node);

		// если поле, являющееся именем узла, было изменено - модифицируем пути этого узла и всех вложенных в него
		if (isset($data[$this->treeParams['nameField']])) {
			// получаем всех предков данного узла, вложенность 1 уровень
			$branch = $this->getBranch($object, 1);

			$pathAccessor = $this->map[$this->treeParams['pathField']]['accessor'];
			$pathMutator = $this->map[$this->treeParams['pathField']]['mutator'];
			$nameAccessor = $this->map[$this->treeParams['nameField']]['accessor'];
			$nameMutator = $this->map[$this->treeParams['nameField']]['mutator'];

			// модифицируем путь текущего узла
			$baseName = ($object->getTreeLevel() > 1 ? $target->$pathAccessor(false) . '/' : '') . $object->$nameAccessor();
			$object->$pathMutator($baseName);
			// сохраняем текущий объект
			$this->save($object);

			// удаляем текущий объект из массива
			array_shift($branch);
			// обходим всех предков
			foreach ($branch as $key => $val) {
				// рекурсивно вызываем функцию модификации путей и для всех предков
				$val->$nameMutator($val->$nameAccessor());
				$this->save($val);
			}
		}
	}

	/**
     * Перемещение узла
     *
     * @param simpleForTree $node переносимый узел
     * @param simpleForTree $target узел, в который переносим
     * @return boolean
     */
	public function move(simpleForTree $node, simpleForTree $target)
	{
		$result = $this->tree->move($node, $target);

		if ($result) {
			$nameAccessor = $this->map[$this->treeParams['nameField']]['accessor'];
			$nameMutator = $this->map[$this->treeParams['nameField']]['mutator'];
			$node->$nameMutator($node->$nameAccessor());

			$this->save($node);
		}

		return $result;
	}

	/**
     * Удаление узла
     *
     * @param simpleForTree $id
     */
	public function delete(simpleForTree $id)
	{
		// получаем всех предков узла
		$branch = $this->getBranch($id);

		$mapper = systemToolkit::getInstance()->getMapper($this->name, $this->itemName);

		foreach ($branch as $do) {
			// получаем всех элементы, содержащиеся в узле дерева
			$items = (array) $do->getItems();
			foreach ($items as $item) {
				// удаляем их
				$mapper->delete($item);
			}
			parent::delete($do);
		}
		$this->tree->delete($id);
	}

	/**
     * Получение дерева, исключая искомый узел и всех его наследников
     *
     * @param simpleForTree $folder
     * @return array
     */
	public function getTreeExceptNode(simpleForTree $folder)
	{
		$tree = $this->searchAll();

		$subfolders = $this->getBranch($folder);

		foreach (array_keys($subfolders) as $val) {
			unset($tree[$val]);
		}

		return $tree;
	}

	/**
     * Получение дерева с наследниками текущего узла следующего уровня вложенности, предками и всем первым уровнем дерева
     *
     * @param simpleForTree $id искомый узел
     * @return array
     */
	public function getTreeForMenu(simpleForTree $node)
	{
		$node = $this->tree->getNodeInfo($node);

		$criterion = new criterion('tree2.lkey', 'tree.lkey', criteria::GREATER, true);
		$criterion->addAnd(new criterion('tree2.rkey', 'tree.rkey', criteria::LESS, true));
		$criterion->addAnd(new criterion('tree2.level', new sqlOperator('+', array('tree.level', 1)), criteria::LESS_EQUAL));

		$criteria = new criteria();
		$criteria->clearSelectFields();//->addSelectField('data2.*');

		foreach (array_keys($this->getMap()) as $field) {
			if (in_array($field, $this->getLangFields())) {
				$criteria->addSelectField('lang2.' . $field);
			} else {
				$criteria->addSelectField('data2.' . $field);
			}
		}

		$this->tree->addSelect($criteria, 'tree2');
		$this->tree->addJoin($criteria);
		$criteria->addJoin($this->treeParams['tableName'], $criterion, 'tree2', criteria::JOIN_INNER);
		$criteria->addJoin($this->table, new criterion('data2.' . $this->treeParams['joinField'], 'tree2.id', criteria::EQUAL, true), 'data2', criteria::JOIN_INNER);

		if ($this->getLangFields()) {
			// добавляем объединение для выборки языкозависимых данных
			$lang_criterion = new criterion('data2.' . $this->tableKey, 'lang2.' . $this->tableKey, criteria::EQUAL, true);
			$lang_criterion->addAnd(new criterion('lang2.' . $this->langIdField, $this->getLangId()));
			$criteria->addJoin($this->table . $this->langTablePostfix, $lang_criterion, 'lang2', criteria::JOIN_INNER);
		}

		$criteria->add('tree.lkey', $node['lkey'], criteria::LESS_EQUAL);
		$criteria->add('tree.rkey', $node['rkey'], criteria::GREATER_EQUAL);
		$criteria->setOrderByFieldAsc('tree2.lkey');
		$criteria->addGroupBy('tree2.id');

		$stmt = parent::searchByCriteria($criteria);

		$result = array();
		while ($row = $stmt->fetch()) {
			$this->setTreeTmp($row, 'tree2');
			$result[$row[$this->tableKey]] = $this->createItemFromRow($row);
		}

		return $result;
	}

	/**
     * Загрузка данных об узле в объект
     *
     * @param simpleForTree $object
     */
	public function loadTreeData(simpleForTree $object)
	{
		$accessor = $this->map[$this->treeParams['joinField']]['accessor'];
		$id = $object->$accessor();

		$node = $this->tree->getNodeInfo($id);
		$object->importTreeFields($node);
	}

	/**
     * Заполняет данными из массива доменный объект
     *
     * @param array $row массив с данными
     * @return object
     */
	public function createItemFromRow($row)
	{
		$object = $this->create();
		$object->import($row);
		$object->importTreeFields($this->treeTmp);
		$this->treeTmp = array();
		return $object;
	}

	/**
     * Метод парсинга исходного массива в форму, удобную для заполнения объекта данными
     *
     * @param array $array искомый массив
     * @param string $name имя получаемого вложенного массива
     * @return array
     */
	public function fillArray(&$array, $name = null)
	{
		$this->setTreeTmp($array);
		return parent::fillArray($array, $name);
	}

	/**
     * Установка во временный массив данных из дерева о текущем узле
     *
     * @param array $array
     * @param string $name
     */
	protected function setTreeTmp(&$array, $name = 'tree')
	{
		$this->treeTmp = parent::fillArray($array, $name);
	}
}

?>