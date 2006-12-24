<p>Маршрутизация (Routing) - это процесс разделения запрошенного URL на ассоциативный массив с помощью правила (route). Доступ к этому массиву возможен через объект <code>httpRequest</code> с третьим аргументом <code>SC_PATH</code>.</p>
<p>Для создания нового правила в файл configs/routes.php, который расположен в папке проекта, используется следующий минимальный код:</p>
<<code>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:action'));
<</code>>
<<note>>Проверка на совпадение с правилом выполняется в обратном порядке.<</note>>
Если запрашиваемый URL <code>example.com/foo/bar</code>, то он совпадет с шаблоном (в нашем примере шаблоном является <code>/:section/:action</code>, где <code>:section</code> и <code>:action</code> - placeholderы) и выполнится его декомпозиция. Ключи ассоциативного массива - имена placeholder-ов. Значения - <code>foo</code> и <code>bar</code> соответственно.</p>

<<note>>Имена placeholder-ов могут состоять только из латинских букв и знака подчеркивания ("_").<</note>>

<p>Таким образом результат будет следующий:
<<code>>
array([section] => foo, [action] = bar)
<</code>>
<p>В шаблоне, кроме placeholder-ов, могут быть указаны также константные значения, которые учитываются только при проверке на совпадение с ним. Например, шаблон <code>/:section/site/:action</code> совпадет с <code>example.com/foo/site/bar</code>, но результат не изменится.</p>

<p>Любой placeholder может иметь значение по умолчанию. Указывать этот placeholder в шаблоне необязательно (в примере ниже указано значение по умолчанию для параметра <code>id<code>). </p>
<<code>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:action', array('section' => 'news', 'action' => 'list', 'id' => 1)));
<</code>>
<p>Данное правило совпадет со следующими URL: <code>example.com/news/list</code>, <code>example.com/news</code>, <code>example.com</code>, <code>example.com/users</code>, <code>example.com/users/edit</code> и т.п.<br /> После декомпозиции будет получен следующий результат:</p>
<<code>>
// example.com/news/list<br />
array([section] => news, [action] => list, [id] => 1)<br /><br />

// example.com/news<br />
array([section] => news, [action] => list, [id] => 1)<br /><br />

// example.com<br />
array([section] => news, [action] => list, [id] => 1)<br /><br />

// example.com/users<br />
array([section] => users, [action] => list, [id] => 1)<br /><br />

// example.com/users/edit<br />
array([section] => users, [action] => edit, [id] => 1)
<</code>>

<p>По умолчанию placeholder совпадает со всей частью до "/". Вы можете это изменить, указав необходимое требование на языке perl-совместимых регулярных выражений (PCRE):</p>
<<code>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:id-:action'), array(), array('id' => '\d+'));
<</code>>
<p>Правило совпадет с URL <code>example.com/news/1-view</code> и результатом будет:</p>
<<code>>
array([section] => news, [id] => 1, [action] => view)
<</code>>
