<p>Во framy встроен механизм скаффолдинга, который позволяет генерировать готовый к использованию код для стандартных действией над объектом (CRUD - Create, Retrive, Update, Delete). Действия Create и Update чаще всего очень похожи, поэтому мы их объединили в одно Save действие.</p>

<p>Первое действие которое мы создадим будет создание записи в блоге (<tt>create</tt>). Как было написано ранее, действие должно принадлежать существующему объекту, поэтому оно будет принадлежать классу <tt>postFolder</tt>. Создаем это действие в devToolbar указав CRUD: save и CRUD class: post (т.к. на самом деле это действие для создания объекта типа <tt>post</tt>)</p>

<p>По адресу <tt>http://framy.blog/blog/create</tt> находится автоматически сгенерированная форма для добавления записи. Отредактируем ее чуть-чуть.</p>

<p>Откроем файл шаблона <tt>modules/blog/templates/create.tpl</tt> и приведем нашу формочку в более приятный вид. Во framy есть генератор форм, который генерирует HTML-код для различных элементов форм, выставляет дефолтные значение и восстанавливает введеные пользоваталем данные в форме в случае ошибки заполнения формы и отображает ее:</p>

<!-- smarty code 1 -->


<p>Сделаем пару изменений в контроллере <tt>modules/blog/controllers/blogCreateController.php</tt>. Здесь мы можем изменить валидаторы для нашей формы. Сейчас они выглядит так:</p>
<<code php>>
$validator->rule('required', 'post[title]', 'Field title is required');
$validator->rule('length', 'post[title]', 'Field title is out of length', array(0, 255));
$validator->rule('required', 'post[content]', 'Field content is required');
$validator->rule('required', 'post[created_at]', 'Field created_at is required');
<</code>>

<p>Нам они не очень походят, поэтому заменим их на:</p>
<<code php>>
$validator->rule('required', 'post[title]', 'Field title is required');
$validator->rule('required', 'post[name]', 'Field name is required');
$validator->rule('required', 'post[content]', 'Field content is required');
$validator->rule('required', 'post[created_at]', 'Field created_at is required');
$validator->rule('regex', 'post[name]', 'Field name has illegal characters', '#^[a-z\d-_]+$#i');
$validator->rule('length', 'post[name]', 'Field name is out of length', array(0, 255));
$validator->rule('length', 'post[title]', 'Field title is out of length', array(0, 255));
$validator->rule('date', 'post[created_at]', 'Invalid creation date', array('regex' => 'time_date'));
<</code>>

<p>Перечисляя по порядку, валидаторы определяют следующее: поля <tt>title</tt>, <tt>name</tt>, <tt>content</tt> и <tt>created_at</tt> обязательны для заполнения, <tt>name</tt> может содержать только символы a-z, A-Z, 0-9, - и _ (так как это идентификатор), <tt>name</tt> и <tt>title</tt> имеют длину не более чем 255 символов, <tt>created_at</tt> имеет формат вида 14:43:32 20/12/2009 (вместо значения <tt>time_date</tt> может быть любое указано регулярное выражение для валидации формата даты, мы будем использовать стандарный вид даты для русской локали).</p>