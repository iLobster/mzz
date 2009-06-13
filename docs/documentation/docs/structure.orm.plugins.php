<p>Плагины предназначены для расширения функциональности мапперов без непосредственно их модификации. Функционал плагинов базируется на системе событий (на которой также построены хуки). Устройство плагинов рассмотрим на примере:</p>

<!-- php code 1 -->

<p>Этот плагин добавляет в маппер возможность работать с полем obj_id (оно активно используется в <a href="structure.acl.html#structure.acl.obj_id">acl</a> и некоторых других задачах, когда нужно уникально в пределах приложения определить объект). В этом плагине определено свойство <code>$options</code>, в котором хранится имя поля, в котором будет собственно сам уникальный счётчик. Метод <code>updateMap</code> будет автоматически вызван классом-предком <code>observer</code> и в качестве аргумента будет передана схема объекта, в которую, как видно из кода, будет добавлен новый метод.</p>
<p>Событие <code>postCreate</code> вызывается сразу после создания объекта. В обработчике проверяется, есть ли уже какое-то значение <code>obj_id</code> для данного объекта. Если нет - генерируется новое значение, передаётся объекту, после чего объект сохраняется. Таким образом это событие используется в случае, когда плагин подключен для уже имеющегося набора данных, для которого ещё не определены <code>obj_id</code>. Событие <code>preInsert</code> предназначено для объектов, которые только создаются - в этом случае уникальный номер генерируется и сразу передаётся в массив данных объекта.</p>

<p>Подключение плагинов происходит с помощью двух методов маппера:</p>
<<code php>>
    $this->plugins('obj_id');
<</code>>
<p>Это простой метод подключения, в котором невозможно задать различные настройки плагину (если он их подразумевает). Второй метод:</p>
<<code php>>
    $this->attach(new tree_mpPlugin(array('path_name' => 'id')));
<</code>>
<p>В этом случае аргументом является объект плагина.</p>

<p>Общесистемные плагины располагаются в директории <code>system/orm/plugins</code>. Местоположение плагинов модулей жёстко не декларируется, но предпочтительно их размещать в поддиректории <code>plugins</code> директории с модулями.</p>

<p>В настоящее время вместе с mzz поставляются следующие плагины:</p>
<ul>
    <li><code>obj_id</code> — плагин, позволяющий добавить в объекты поле obj_id для уникальной идентификации в приложении;</li>
    <li><code>acl_ext</code> — плагин acl, расширенная версия. Позволяет разграничивать права в приложении с точностью до объекта;</li>
    <li><code>acl_simple</code> — плагин acl, упрощённая версия. Позволяет разграничивать права в приложении с точностью до типа объекта;</li>
    <li><code>tree_mp</code> — плагин для работы с древовидными структурами. Иерархическая структура хранится в виде Materialized Path;</li>
    <li><code>pager</code> — плагин для постраничного вывода коллекций объектов. Вручную подключать его в маппер Вам врядли понадобиться. Ознакомиться с этим плагином Вы можете в <a href="modules.pager.html">соответствующем разделе</a> документации.</li>
</ul>