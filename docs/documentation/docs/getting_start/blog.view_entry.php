<p>Если создание записи прошло успешно (для примера, мы создали запись с именем "welcome"), то после добавления мы увидим исключение <tt>Unknown action view in module blog</tt>. Создадим в devToolbar действие <tt>view</tt> для класса <tt>post</tt выбрав CRUD: view. </p>

<p>По адресу <tt>http://framy.blog/ru/blog/welcome</tt> мы увидим 404 ошибку. Произошло это из-за того, что по умолчанию контроллер <tt>blogViewController</tt> сгенерировался для работы с числовым идентификатором (id):</p>
<<code php>>
$id = $this->request->getInteger('id');
$post = $postMapper->searchByKey($id);
<</code>>

<p>В нашем же случае используется строковое имя для идентификации объекта (name). Исправим это:</p>
<<code php>>
$name = $this->request->getString('name');
$post = $postMapper->searchByKey($name);
<</code>>
