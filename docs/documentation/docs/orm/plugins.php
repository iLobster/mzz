<p>Плагины предназначены для расширения функциональности мапперов без непосредственно их модификации. Функционал плагинов базируется на системе событий (на которой также построены хуки). Устройство плагинов рассмотрим на примере:</p>

<<code php>>
class obj_idPlugin extends observer
{
    protected $options = array(
        'obj_id_field' => 'obj_id'
    );

    protected function updateMap(& $map)
    {
        $map[$this->options['obj_id_field']] = array(
            'accessor' => 'getObjId',
            'mutator' => 'setObjId',
            'options' => array('once', 'plugin')
        );
    }

    public function postCreate(entity $object)
    {
        if (!$object->getObjId()) {
            $obj_id = systemToolkit::getInstance()->getObjectId();
            $map = $this->mapper->map();
            $object->{$map[$this->options['obj_id_field']]['mutator']}($obj_id);
            $this->mapper->save($object);
        }
    }

    public function preInsert(array & $data)
    {
        $data[$this->options['obj_id_field']] = systemToolkit::getInstance()->getObjectId();
    }

    public function setObjId(entity $object, $id)
    {
        $object->merge(array($this->options['obj_id_field'] => $id));
        return $object;
    }

    public function getObjIdField()
    {
        return $this->options['obj_id_field'];
    }
}
<</code>>

<p>Этот плагин добавляет в маппер возможность работать с полем <code>obj_id</code> (оно активно используется в задачах, когда нужно уникально в пределах приложения определить объект). В этом плагине определено свойство <code>$options</code>, в котором хранится имя поля, в котором будет собственно сам уникальный счётчик. Метод <code>updateMap</code> будет автоматически вызван классом-предком <code>observer</code> и в качестве аргумента будет передана схема объекта, в которую, как видно из кода, будет добавлен новый метод.</p>

<p>Событие <code>postCreate</code> вызывается сразу после создания объекта. В обработчике проверяется, есть ли уже какое-то значение <code>obj_id</code> для данного объекта. Если нет - генерируется новое значение, передаётся объекту, после чего объект сохраняется. Таким образом это событие используется в случае, когда плагин подключен для уже имеющегося набора данных, для которого ещё не определены <code>obj_id</code>. Событие <code>preInsert</code> предназначено для объектов, которые только создаются - в этом случае уникальный номер генерируется и сразу передаётся в массив данных объекта.</p>

<p>Подключение плагинов происходит с помощью двух методов маппера:</p>
<<code php>>
    mapper::plugins($name, array $options = array(), $newName = null);
<</code>>
<p>или</p>
<<code php>>
    mapper::attach(observer $observer, $name = null)
<</code>>

<p>Общесистемные плагины располагаются в директории <code>system/orm/plugins</code>. Местоположение плагинов модулей жёстко не декларируется, но предпочтительно их размещать в поддиректории plugins директории с модулями.</p>

<p>В настоящее время вместе с mzz поставляются следующие плагины:</p>
<ul>
    <li><code>identityMap</code>
    <li><code>obj_id</code> — плагин, позволяющий добавить в объекты поле obj_id для уникальной идентификации в приложении;
    <li><code>tree_mp</code> — плагин для работы с древовидными структурами. Иерархическая структура хранится в виде Materialized Path;
    <li><code>tree_al</code> — плагин для работы с древовидными структурами. Иерархическая структура хранится в виде Adjacency List;
    <li><code>pager</code> — плагин для постраничного вывода коллекций объектов. Вручную подключать его в маппер вам вряд ли понадобиться. Ознакомиться с этим плагином Вы можете в соответствующем разделе документации.
</ul>
