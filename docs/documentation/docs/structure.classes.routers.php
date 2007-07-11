<p>Маршрутизация (Routing) - это процесс разделения запрошенного URL на ассоциативный массив с помощью правила (route) при совпадении пути из URL с ним. Правила маршрутизации хранятся в файле <code>&lt;project_folder&gt;/configs/routes.php</code>.</p>
Доступ к результату возможен через объект <code>httpRequest</code> с указанием в качестве третьего аргумента <code>SC_PATH</code>.</p>
<p>Пример простейшего правила:</p>
<<code php>>
$router->addRoute('nameOfRule', new requestRoute('/ru/:section/:action'));
<</code>>
<<note>>Перебор для поиска подходящего правил осуществляется в обратном порядке.<</note>>
<p>Где <code>nameOfRule</code> - уникальное имя для правила, <code>/ru/:section/:action</code> - шаблон. Шаблон может содержать разделитель <code>/</code> (прямой слэш), placeholder и raw-текст. В нашем примере <code>:section</code> и <code>:action</code> - placeholder, <code>ru</code> - raw-текст. Запрашиваемый URL <code>example.com/ru/foo/bar</code> совпадет с этим шаблоном и выполнится декомпозиция пути: в <code>httpRequest</code> будет помещен ассоциативный массив, где ключи - имена placeholder: <code>section</code> и <code>action</code>, значения - <code>foo</code> и <code>bar</code> соответственно. Raw-текст при этом сохранен не будет, он учитывается только в процессе проверки на совпадение.</p>

<<note>>Имя placeholder должно состоять только из латинских букв и знака подчеркивания ("_").<</note>>

<p>Таким образом в <code>httpRequest</code> будет помещен массив:
<<code php>>
array([section] => foo, [action] = bar)
<</code>>

<p>Любой placeholder может иметь значение по умолчанию, которые указываются во втором аргументе. Существовать этому placeholder в шаблоне необязательно (в примере ниже указано значение по умолчанию для placeholder-а <code>id</code>, но в самом шаблоне его нет). </p>
<<code php>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:action', array('section' => 'news', 'action' => 'list', 'id' => 1)));
<</code>>
<p>Данное правило совпадет со следующими URL: <code>example.com/news/list</code>, <code>example.com/news</code>, <code>example.com</code>, <code>example.com/users</code>, <code>example.com/users/edit</code> и т.п.<br /> После декомпозиции в <code>httpRequest</code> будет помещен массив:</p>
<<code php>>
// example.com/news/list
array([section] => news, [action] => list, [id] => 1)

// example.com/news
array([section] => news, [action] => list, [id] => 1)

// example.com
array([section] => news, [action] => list, [id] => 1)

// example.com/users
array([section] => users, [action] => list, [id] => 1)

// example.com/users/edit
array([section] => users, [action] => edit, [id] => 1)
<</code>>

<p>По умолчанию границами для placeholder является разделитель <code>/</code> (прямой слэш). Вы можете это изменить, указав необходимое требование на языке perl-совместимых регулярных выражений (PCRE) в третьем аргументе:</p>
<<code php>>
$router->addRoute('nameOfRule', new requestRoute('/:section/:id-:action'), array(), array('id' => '\d+'));
<</code>>
<p>Правило совпадет с URL <code>example.com/news/1-view</code> и в <code>httpRequest</code> будет помещено:</p>
<<code php>>
array([section] => news, [id] => 1, [action] => view)
<</code>>

<p>Пример получения результата:</p>
<<code php>>
$section = $this->request->get('section', 'string', SC_PATH);
$id = $this->request->get('id', 'integer', SC_PATH);
$action = $this->request->get('action', 'string', SC_PATH);
<</code>>
