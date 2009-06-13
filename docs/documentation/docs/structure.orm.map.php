<p>Свойство маппера $map представляет собой набор правил наложения данных БД на объектную модель. Вот несколько упрощенный пример map:</p>
<<code php>>
protected $map = array(
    'id' => array(
        'accessor' => 'getId',
        'mutator' => 'setId',
        'options' => array(
            'pk', 'once',
        )
    ),
    'title' => array(
        'accessor' => 'getTitle',
        'mutator' => 'setTitle'
    )
)
<</code>>

<p>Ключами массива $map являются имена полей таблицы БД (которая задается в параметре $table маппера, ссылка).
В общем случае у каждого поля должно быть описано имена двух методов — accessor и mutator.</p>
<p>Имя accessor'а имеет префикс "get" и используется для получения данных, которые хранятся в данном поле.</p>
<p>Mutator, соответственно, имеет префикс "set" и используется для сохранения данных в DO</p>
<p>У каждого поля может содержаться любое количество дополнительных параметров в ключе 'options'. Приведем примеры нескольких опций:</p>
<ul>
    <li><em>pk</em> — присутствие такой опции будет говорить о том, что данное поле является Первичным Ключом (Primary Key) для таблицы.</li>
    <li><em>once</em> — поля с этой опцией будут доступны для сохранения только один раз при создании объекта. При попытке задать такое поле вторично, будет сгенерировано исключение</li>
    <li><em>ro</em> — поле доступно только для чтения. При попытке задать значения через соответствующий мутатор, будет сгенерировано исключение.</li>
</ul>
<p>&nbsp;</p>
<p>Рассмотрим основные методы для работы с мапперами:</p>
<ul>
        <li><p>
                <em>create()</em> - создание объекта.</p>
        </li>
        <li><p>
                <em>save($object)</em> - сохранение объекта $object.</p>
        </li>
        <li><p>
                <em>delete($id)</em> - удаление объекта, в качестве идентификатора используется первичный ключ $id.</p>
        </li>
</ul>
<p>Также для удобства имеется ряд методов для получения записей:</p>
<ul>
        <li><p>
                <em>searchByKey($id)</em> - поиск объекта по первичному ключу.</p>
        </li>
        <li><p>
                <em>searchByKeys($id)</em> - поиск объектов по первичным ключам. В качестве аргумента передаётся массив.</p>
        </li>
        <li><p>
                <em>searchOneByField($field, $value)</em> - поиск объекта по полю $field со значением $value.</p>
        </li>
        <li><p>
                <em>searchAllByField($field, $value)</em> - поиск объектов по полю $field со значение $value.</p>
        </li>
        <li><p>
                <em>searchOneByCriteria(criteria $criteria)</em> - поиск объекта по критерию.</p>
        </li>
        <li><p>
                <em>searchAllByCriteria(criteria $criteria)</em> - поиск объектов по критерию.</p>
        </li>
        <li><p>
                <em>searchAll($orderCriteria = null)</em> - выборка всех объектов. В качестве аргумента может быть передан критерий для сортировки.</p>
        </li>
</ul>
<p>Естественно, что в ваших мапперах Вы можете расширить данный список методов для поиска. Так например метод searchByLogin (метод для поиска пользователя по его логину) будет выглядеть следующим образом:</p>
<!-- php code 4 -->
<<note>>Экранировать значения, передаваемые в аргументах, не нужно. За вас это сделает генератор запросов.<</note>>
<<note>>О работе с критериями можно узнать в <a href="db.queries.html#db.queries">соответствующем разделе</a>.<</note>>