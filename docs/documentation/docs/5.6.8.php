<p>В первую очередь давайте создадим действие list, которое будет выводить список комментариев к данному объекту. Программировать будем для модуля news (однако не будем забывать, что полученный модуль должен быть универсален и быть возможным подключенным к любому объекту).</p>
<p>Открываем файл <code>news.view.tpl</code>, который располагается в каталоге <code>www/templates/news</code> и добавляем в него следующую строку:</p>
<<code>>{load module="comments" section="comments" action="list" parent_id=$news->getObjId() owner=$news->getEditor()->getId()}<</code>>
<p>Последний аргумент указывает - кто будет владельцем только что созданного <code>commentsFolder'а</code>. Затем попытаемся открыть какую-либо новость. Ссылка для определённой новости будет выглядеть приблизительно так:</p>
<<code>>http://mzz/news/4/view<</code>>
<p>Естественно по этому запросу мы увидим исключительную ситуацию (Exception).</p>
<<code>>System Exception. Thrown in file D:\server\sites\mzz\system\action\action.php (Line: 182) with message:<br />
Действие "list" не найдено для модуля "comments"<</code>>
<p>Из этого описания мы видим, что не было создано действие list. Давайте его создадим. В командной строке, находясь в корневом каталоге модуля <code>comments</code> выполним команду:</p>
<<code>>generateAction.bat commentsFolder list<</code>>
<p>Результатом успешного выполнения будет:</p>
<<code>>
File edited successfully:<br />
- actions/commentsFolder.ini<br />
<br />
File created successfully:<br />
- controllers/commentsFolderListController.php<br />
- views/commentsFolderListView.php<br />
<br />
ALL OPERATIONS COMPLETED SUCCESSFULLY
<</code>>
<p>Теперь обновим страницу http://mzz/news/4/view. Сообщение об ошибке изменилось:</p>
<<code>>Invalid Parameter. Thrown in file D:\server\sites\mzz\system\acl\acl.php (Line: 803) with message:<br />
Свойство obj_id должно быть целочисленного типа и иметь значение > 0 (0)<</code>>
<p>И это логично, т.к. <code>commentsFolder</code> должен возвращать <code>obj_id</code> текущего <code>commentsFolder'а</code>, а мы этот метод ещё не написали. Но перед этим - давайте добавим в таблицу <code>`comments_commentsFolder`</code> одну запись, с которой мы и будем сейчас работать (в конце написания модуля <code>commentsFolder'ы</code> будут создаваться автоматически). В нашем случае <code>obj_id</code> будет равно 76 (это значение посмотрите в таблице <code>`sys_obj_id`</code>, вручную добавив ещё одну запись), а <code>`parent_id`</code> = 66 (это значение можно посмотреть либо в поле <code>`obj_id`</code> таблицы <code>`news_news`</code>, либо дописав <code>{$news->getObjId()}</code> в шаблон, с которым мы сейчас работаем, и обновив его). Также зарегистрируем новый объект в ACL. Для этого в таблицу <code>`sys_access_registry`</code> добавим запись со значениями <code>obj_id</code> = 76 и <code>class_section_id</code> = 11.</p>
<p>Теперь открываем файл <code>commentsFolderMapper.php</code>, расположенный в каталоге <code>mappers</code> модуля comments. Нас интересует метод <code>convertArgsToId()</code>. В массиве <code>$args</code> передаётся <code>parent_id</code>, по которому мы можем найти необходимый нам <code>commentsFolder</code>. Чтобы в этом убедиться в теле метода напишите <code>var_dump($args);</code> и обновите страницу. Если всё было проделано правильно, то <code>$args['parent_id']</code> будет равно 66 (в вашем случае - возможно иное). Теперь по значению <code>parent_id</code> нам нужно найти соответствующую запись и вернуть <code>obj_id</code>, который соответствует этой записи. Это делается следующим кодом:</p>
<!-- code 1 -->
<p>Обновите страницу. Если всё выполнено верно - то на том месте, где должны располагаться комментарии, вы увидите надпись "доступ запрещён". Давайте дадим доступ текущему пользователю для списка комментариев. В таблицу <code>`sys_access`</code> добавим запись со значениями: `action_id` = 9 (editACL), `class_section_id` = 11, `obj_id` = 76, `uid` = 2 (admin), `allow` = 1. Поле gid оставим со значением <code>null</code>. Теперь чтобы дать полный доступ на этот объект воспользуемся графическим интерфейсом для изменения прав. Он доступен по ссылке: http://mzz/access/76/editACL. В этом окне кликнем на пользователя admin и выделим действие list, после чего нажмём кнопку "Установить права". Закроем это окно и обновим окно с новостью. Увидим сообщение:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\template\mzzFileSmarty.php (Line: 50) with message:
Шаблон 'D:\server\sites\mzz\www/templates/comments/comments.list.tpl' отсутствует.<</code>>
<p>Это потому, что мы не создали необходимые шаблоны. Перейдём в каталог с шаблонами (<code>www/templates</code>) и создадим каталог <code>comments</code>, в котором создадим файл <code>comments.list.tpl</code>. В этот файл запишем произвольный текст для проверки - например 'hello world'. И снова обновим страницу. Теперь нашему взору должна предстать новость, после которой появилась наша надпись hello world. Однако если мы попробуем открыть другую новость, мы увидим следующую ошибку:</p>
<<code>>Fatal error: Call to a member function getObjId() on a non-object in D:\server\sites\mzz\system\modules\comments\mappers\commentsFolderMapper.php on line 49
<</code>>
<p>Её причина в том, что для этой другой новости не создана <code>commentsFolder</code>. Естественно, это добавляться она будет автоматически. Давайте напишем код, который будет добавлять к текущему объекту <code>commentsFolder</code> если такового не существует.</p>
<!-- code 2 -->
<p>Теперь обновим страницу. Увидим сообщение, что к только что добавленному <code>commentsFolder'у</code> у нас нет доступа. Это логично - ведь права доступа для этого модуля comments пока ещё не были установлены нами. Но вначале, перед установкой прав, убедимся, что запись в таблице <code>`comments_commentsFolder`</code> создалась. Для установки прав по умолчанию откроем страницу</p>
<<code>>http://mzz/access/comments/commentsFolder/editDefault<</code>>
<p>На просмотр этой страницы у нас пока также нет прав. Установим их. В таблице <code>`sys_obj_id_named`</code> посмотрим id у записи со значением поля `name` = access_comments_commentsFolder. В моём случае это 78. Затем в таблице <code>`sys_access_registry`</code> найдём этот объект, и увидим что у него поле `class_section_id` = 7. Теперь в таблицу <code>`sys_access`</code> добавляем запись со следующими значениями: `action_id` = 9 (editACL), `class_section_id` = 7, `obj_id` = 78, `uid` = 2 (admin), `allow` = 1. Поле `gid` оставим со значением null. Теперь откроем страницу</p>
<<code>>http://mzz/access/78/editACL<</code>>
<p>И уже средствами интерфейса добавим право на <code>editDefault</code> для пользователя admin. Теперь вернёмся к странице</p>
<<code>>http://mzz/access/comments/commentsFolder/editDefault<</code>>
<p>В этом интерфейсе добавим обе группы: auth и unauth. Для обоих выставим право на list, а для auth - ещё и право на editACL. Однако естественно для уже созданного <code>commentsFolder'а</code> эти права применены не будут. Так что давайте удалим из системы все упоминания об втором созданном <code>commentsFolder'е</code> и обновим страницу. Удалять нужно: вторую запись в таблице <code>`comments_commentsFolder`</code> и запись из <code>`sys_access_registry`</code>. Теперь обновим страницу со второй новостью. Если всё сделано верно - тогда тут тоже появится надпись 'hello world' и в таблицы будет добавлен новый commentsFolder и права на него.</p>
<p>На этом отвлекёмся от программирования метода list и создадим второй метод - post. Процесс генерации кода совершенно аналогичен генерации кода для list. Разберёмся, что должен делать метод post: отрисовка формы и получение данных из $_POST-массива с последующим добавлением в БД. Ну что ж, откроем <code>comments.list.tpl</code>. Удалим в нём hello world и добавим запуск этого же модуля comments, но действия post.</p>
<<code>>{load module="comments" section="comments" action="post" parent_id=$news->getObjId()}<</code>>
<p>После обновления страницы увидим, что вновь нет доступа. Добавим его через уже знакомый интерфейс</p>
<<code>>http://mzz/access/79/editACL<</code>>
<p>Обновляем страницу и видим - что не найден шаблон <code>comments.post.tpl</code>. Естественно создаём его с уже знакомой нам фразой hello world. После очередного обновления страницы ошибок быть не должно, но должна появиться надпись hello world. На место этой надписи нам нужно добавить форму. Чтобы создать форму - создаём новый файл <code>commentsPostForm.php</code> в каталоге <code>views</code>:</p>
<!-- code 3 -->
<p>Отредактируем созданные генератором кода файлы <code>commentsFolderPostController.php</code> и <code>commentsFolderPostView.php</code></p>
<!-- code 4 -->
<!-- code 5 -->
<p>Ну и конечно же шаблон для отображения формы <code>comments.post.tpl</code></p>
<!-- html code 6 -->
<p>Теперь по обновлению страницы вы должны увидеть форму, состоящую из поля для ввода и кнопок "Отправить" и "Сброс". Эта форма снабжена примитивной проверкой на то, что в поле с комментарием ввели какую-либо информацию. Напишите что-либо и отправьте сообщение. Появится сообщение об ошибке:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\controller\sectionMapper.php (Line: 81) with message:<br />
Не найден активный шаблон для section = "comments", action = "post"<</code>>
<p>Перейдём в каталог <code>www/templates/act</code> и создадим в нём подкаталог <code>comments</code>. В нём будут располагаться активные шаблоны модуля comments. В этом каталоге создадим файл <code>post.tpl</code> со следующим содержанием:</p>
<<code>>{load module="comments" action="post"}<</code>>
<p>Снова обновим страницу. Увидим сообщение об ошибке:</p>
<<code>>PHP Error Exception. Thrown in file D:\server\sites\mzz\system\exceptions\errorDispatcher.php (Line: 49) with message:<br />
Notice in file D:\server\sites\mzz\system\modules\comments\mappers\commentsFolderMapper.php:48: Undefined index: parent_id<</code>>
<p>Оно появилось потому, что правило <code>requestRouter-а</code> по умолчанию аргумент в ссылке именует как id, а мы обращаемся к элементу массива parent_id. Давайте добавим и обработку id также в <code>commentsFolderMapper</code>:</p>
<!-- code 7 -->
<p>Обновим страницу. И увидим форму с введённым значением. Это потому, что метод post пока не умеет обрабатывать post-запросы. Давайте научим его делать это ;). Модифицируем соответствующим образом файл <code>commentsFolderPostController.php</code></p>
<!-- code 8 -->
<p>А также создадим новый класс <code>commentsPostSuccessView</code>, который будет перенаправлять нас после удачного добавления комментария на исходную страницу, и поместим его в каталог <code>views</code>:</p>
<!-- code 9 -->
<p>Если сейчас посмотреть в БД, то можно увидеть, что поле `time` не заполняется для создаваемых комментариев. Чтобы поправить это, добавим в <code>commentsMapper</code> следующий метод:</p>
<!-- code 10 -->
<p>После этого изменения у всех вновь добавляемых комментариев поле `time` будет устанавливаться автоматически.</p>
<p>Теперь давайте приступим к экшну `list` и выведем список комментариев. Для этого давайте вернёмся к схеме БД в файле <code>commentsFolder.map.ini</code> и отношением 1:N свяжем сущности "комментарий" и "папка с комментариями". В <code>commentsFolder.map.ini</code> добавим ещё одно поле, теперь этот файл будет выглядеть так:</p>
<!-- code 11 -->
<p>Также подправим контроллер, отображение и шаблон для метода list соответственно:</p>
<!-- code 12 -->
<!-- code 13 -->
<!-- code 14 -->
<p>Как видите - заодно мы вывели <code>jip</code> для <code>commentsFolder</code>. Теперь по обновлению страницы вы должны увидеть список комментариев. Однако, как видно из шаблона и непосредственно в списке комментариев, вместо логина автора комментария у нас выводится его id. Свяжем соотношением 1:1 комментарий и пользователей, а также комментарий и "папку с комментариями". <code>сomments.map.ini</code> и шаблон соответственно изменятся:</p>
<!-- code 15 -->
<!-- code 16 -->
<p>Также для удобства можно немного изменить класс <code>commentsFolderPostController</code>:</p>
<!-- code 27 -->
<p>Теперь выводятся логины авторов сообщений. Осталось реализовать методы delete и edit. Продолжим. Новый метод edit создаём как обычно, но доменный объект укажем не <code>commentsFolder</code>, а <code>comments</code>. Затем добавим это действие в <code>jip</code> для объекта comments:</p>
<<code>>
[edit]<br />
controller = "edit"<br />
jip = "1"<br />
icon = "/templates/images/edit.gif"<br />
title = "Редактировать"
<</code>>
<p>Также модифицируем шаблон списка комментариев, добавив <code>{$comment->getJip()}</code>, что выведет в указанном месте иконку с выпадающим меню jip, в котором будут 2 пункта: "Редактирование" и "Права доступа". Если попробовать изменить права доступа к любому из комментариев - мы увидим сообщение о том, что нет доступа. Это потому, что для <code>comments</code> мы ещё не сделали создание прав по умолчанию. Делается это по известной уже схеме: в таблицах `sys_obj_id_named` и `sys_access_registry` мы смотрим obj_id и class_section_id добавляем запись в `sys_access` запись со значениями: `action_id` = 18 (editDefault), `class_section_id` = 7, `obj_id` = 86, `uid` = 2, `allow` = 1. Теперь открываем урл</p>
<<code>>http://mzz/access/comments/comments/editDefault<</code>>
<p>И в правах по умолчанию для автора прописываем действия edit и editACL. Добавьте новый комментарий и попробуйте изменить для него права доступа. Если всё сделано верно - то ошибок быть не должно. Теперь открываем в новом окне урл</p>
<<code>>http://mzz/comments/7/edit<</code>>
<p>где 7 - id только что созданного комментария. На экране должна появиться ошибка:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\controller\sectionMapper.php (Line: 81) with message:<br />
Не найден активный шаблон для section = "comments", action = "edit"<</code>>
<p>По уже известной методике создадим новый активный шаблон <code>comments/edit.tpl</code>.</p>
<!-- code 17 -->
<p>После создания активного шаблона увидим:</p>
<<code>>Invalid Parameter. Thrown in file D:\server\sites\mzz\system\acl\acl.php (Line: 803) with message:<br />
Свойство obj_id должно быть целочисленного типа и иметь значение > 0 (0)<</code>>
<p>Открываем <code>commentsMapper</code> и модифицируем его:</p>
<!-- code 18 -->
<p>Обновляем страницу. Видим:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\template\mzzFileSmarty.php (Line: 50) with message:<br />
Шаблон 'D:\server\sites\mzz\www/templates/comments/comments.edit.tpl' отсутствует.<</code>>
<p>Замечу также, что файл <code>commentsEditView.php</code> нам не нужен (мы будем использовать класс <code>commentsPostForm</code> вместо него). Так что его можно удалить. Затем модифицируем файлы <code>commentsEditController.php</code>, <code>commentsPostForm.php</code>, <code>comments/edit.tpl</code>, <code>commentsMapper.php</code>, <code>commentsFolderPostView</code>, <code>comments.post.tpl</code>. Теперь они будут выглядеть так (в том же порядке):</p>
<!-- code 19 -->
<!-- code 20 -->
<!-- code 21 -->
<!-- code 22 -->
<!-- code 25 -->
<!-- code 26 -->
<p>Если всё выполнено верно - то теперь метод edit должен работать. Остася финальный рывок - метод delete. Он не составит больших проблем для вас. Создаём очередной экшн для сущности <code>comments</code>. Также добавляем его в <code>jip</code>:</p>
<!-- code 23 -->
<p>Добавляем активный шаблон <code>comments/delete.tpl</code>:</p>
<!-- code 24 -->
<p>Теперь даём администратору права на удаление какого-либо комментария и пробуем его удалить. Если всё сделано верно - то выбранный комментарий должен быть удалён.</p>
<p>Ну и напоследок - забытый в начале, но несомненно важный функционал - удаление комментариев при удалении комментируемого объекта. В реализации конечно же нет ничего сложного. Создаём новый экшн - deleteFolder. В отличие от всех остальных экшнов этот не будет доступен извне. Другими словами этот метод может быть только вызван в другом шаблоне. Поэтому создавать новый активный шаблон, а также прописывать новое действие в таблицу `sys_actions` и ассоциировать его с этим классом - не нужно. Также нужно прописать для этого экшна inACL = 0 в commentsFolder.ini, для того чтобы ACL действительно его не включил в список доступных методов. Вызов метода будет выглядеть вот так:</p>
<<code>>{load module="comments" section="comments" action="deleteFolder" 403handle="manual"}<</code>>
<p>Последний аргумент 403handle="manual" здесь добавлен для потому, что acl для этого метода всегда будет возвращать false, потому что этого метода у этого класса для acl не существует (мы его не прописали). Контроллер для удаления будет выглядеть следующим образом:</p>
<!-- code 28 -->
<p>Т.е. вначале мы ищем все commentsFolder'ы, которые ссылаются на уже не существующие объекты, и затем в цикле удаляем эти объекты. Как можно заметить - удаление производится не методом simpleMapper::delete(), а remove. Приведём код этого метода:</p>
<!-- code 29 -->
<p>Также не нужно забывать, что вызов этого же экшна нужно добавить и в активный шаблон news/deleteFolder.tpl.</p>