Для хранения и работы с древовидными структурами используется класс dbTreeNS. Этот класс обеспечивает работу с деревьями по технологии Nested Sets. Причём в одной таблице со структурой дерева может храниться несколько деревьев.<br />
В работе используется 2 таблицы, назовем их условно - <strong>tree</strong> и <strong>data</strong>.<br />

<ul>
        <li>
                <code>data</code> - в таблице хранятся данные.
                Структура и описание таблицы:
                <<code>>
parent - идентификатор записи, связан с полем tree.id
foo - хранимое значение
path - путь до записи в дереве.
                <</code>>
<<note>>
Для связи с таблицей содержащей структуру, возможно заведение отдельного поля. <br />
Но учитывая 1:1 отношение между записями таблицы данных и структурной таблицей рациональнее использовать праймари ключи таблиц для связи.
<</note>>
        </li>
        <li>
                <code>tree</code> - таблица используется для хранения структуры <br />
                Структура и описание таблицы:
                <<code>>
id - идентификатор записи
lkey - левый ключ
rkey - правый ключ
level - уровень узла в дереве (root - первый уровень)
                <</code>>
        </li>
</ul>
<p>Вся работа с деревьями осуществляется через <code>simpleMapperForTree</code> и доменные объекты типа <code>simpleForTree</code>. <code>simpleMapperForTree</code> предоставляет следующие методы:</p>

<ul>
        <li><code>setTree($tree_id)</code> - метод установки id дерева. Используется, когда в вышеописанном наборе таблиц хранится несколько деревьев.</li>
        <li><code>searchByPath($path)</code> - поиск элемента по пути.</li>
        <li><code>getFolders(simpleForTree $id, $level = 1)</code> - является синонимом для метода <code>getBranch()</code>.</li>
        <li><code>getBranch(simpleForTree $id, $level = 1)</code> - выборка наследников. Первым аргументом передаётся искомый узел, а вторым - глубина выборки.</li>
        <li><code>getParentBranch(simpleForTree $node)</code> - выборка родительской ветки.</li>
        <li><code>getTreeParent(simpleForTree $child)</code> - выборка родительского элемента.</li>
</ul>

<p>Остальные методы этого класса наследуются от <a href="modules.simple.html#modules.simple.simpleMapper"><code>simpleMapper</code></a>'a.</p>

<p>У класса <code>simpleForTree</code> есть следующие методы для работы с деревьями:</p>

<ul>
        <li><code>getTreeLevel()</code> - уровень узла.</li>
        <li><code>getTreeKey()</code> - значение первичного ключа узла.</li>
        <li><code>getTreeId()</code> - id дерева, в случае когда в наборе таблиц хранятся несколько деревьев.</li>
        <li><code>getTreeParent()</code> - получение родительского элемента текущего узла.</li>
        <li><code>getPath($simple = true)</code> - получение пути до узла. Единственный аргумент принимает булево значение, в случае <code>true</code> - возвращается "простой" путь, у которого убирается имя корневого элемента, <code>false</code> - полный путь.</li>
</ul>

<p>В остальном работа с классом <code>simpleForTree</code> аналогична работе с любым наследником класса <a href="modules.simple.html#modules.simple.simple"><code>simple</code></a>.</p>

<p>Настройка дерева производится с помощью переопределения метода <code>simpleMapperForTree::getTreeParams()</code>, который по умолчанию возвращает массив следующего вида:</p>
<<code php>>
protected function getTreeParams()
{
        return array('nameField' => 'name', 'pathField' => 'path', 'joinField' => 'parent', 'tableName' => $this->table . '_tree', 'treeIdField' => 'tree_id');
}
<</code>>

<p>В наследнике данный метод может возвращать массив, содержащий лишь часть ключей, в этом случае недостающие значения будут использованы из массива по умолчанию. Ключи в этом массиве обозначают следующее:</p>

<ul>
        <li><code>nameField</code> - поле, содержащее в себе имя узла.</li>
        <li><code>pathField</code> - поле, содержащее в себе путь до узла. Путь строится и модифицируется автоматически, используя данные поля <code>nameField</code></li>
        <li><code>joinField</code> - поле, связывающее таблицу данных с таблицей структуры.</li>
        <li><code>tableName</code> - имя таблицы, хранящей структуру дерева.</li>
        <li><code>treeIdField</code> - имя поля, в котором будет храниться id дерева (в случае, когда деревьев несколько).</li>
</ul>
