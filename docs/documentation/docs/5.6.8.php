<p>В первую очередь давайте создадим действие list, которое будет выводить список комментариев к данному объекту. Программировать будем для модуля news (однако не будем забывать, что полученный модуль должен быть универсален и быть возможным подключенным к любому объекту).</p>
<p>Открываем файл news.view.tpl, который располагается в каталоге www/templates/news и добавляем в него следующую строку:</p>
<<code>>{load module="comments" section="comments" action="list" parent_id=$news->getObjId()}<</code>>
<p>Затем попытаемся открыть какую-либо новость. Урл для определённой новости будет выглядеть приблизительно так:</p>
<<code>>http://mzz/news/4/view<</code>>
<p>Естественно по этому запросу мы увидим исключительную ситуацию.</p>
<<code>>System Exception. Thrown in file D:\server\sites\mzz\system\action\action.php (Line: 182) with message:<br />
Действие "list" не найдено для модуля "comments"<</code>>
<p>Из этого описания мы видим, что не было создано действия list. Давайте его создадим. В командной строке, находясь в корневом каталоге модуля comments выполним команду:</p>
<<code>>generateAction.bat commentsFolder list<</code>>
<p>Результатом выполнения будет:</p>
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
<p>Теперь обновим страницу http://mzz/news/4/view. Теперь сообщение об ошибке изменилось:</p>
<<code>>Invalid Parameter. Thrown in file D:\server\sites\mzz\system\acl\acl.php (Line: 803) with message:<br />
Свойство obj_id должно быть целочисленного типа и иметь значение > 0 (0)<</code>>
<p>И это логично, т.к. commentsFolder должен возвращать obj_id текущего commentsFolder'а, а мы этот метод ещё не написали. Но перед этим - давайте добавим в таблицу `comments_commentsFolder` одну запись, с которой мы и будем сейчас работать (в результате написания модуля commentsFolder'ы конечно же будут создаваться автоматически). В моём случае obj_id будет равно 76 (это значение посмотрите в таблице `sys_obj_id`, вручную добавив ещё одну запись), а `parent_id` = 66 (это значение можно посмотреть либо в поле `obj_id` таблицы `news_news`, либо дописав {$news->getObjId()} в шаблон, с которым мы сейчас работаем, и обновив его). Также зарегистрируем новый объект в ACL. Для этого в таблицу `sys_access_registry` добавим запись со значениями obj_id = 76 и class_section_id = 11.</p>
<p>Теперь открываем файл commentsFolderMapper.php, расположенный в каталоге mappers в каталоге с модулем comments. Сейчас нас интересует метод convertArgsToId(). В массиве $args передаётся parent_id, по которому мы можем найти необходимый нам commentsFolder. Чтобы в этом убедиться в теле метода напишите var_dump($args); и обновите страницу. Если всё было проделано правильно, то $args['parent_id'] будет равно 66 (в вашем случае - возможно иное). Теперь по значению parent_id нам нужно найти соответствующую запись и вернуть obj_id, который соответствует этой записи. Это делается следующим кодом:</p>
<!-- code 1 -->
<p>Теперь обновите страницу. Если всё выполнено верно - то вы на том месте где должны располагаться комментарии увидите надпись "доступ запрещён". Давайте дадим доступ текущему пользователю для списка комментариев. В таблицу `sys_access` добавим запись со значениями: `action_id` = 9 (editACL), `class_section_id` = 11, `obj_id` = 76, `uid` = 2 (admin), `allow` = 1. Поле gid оставим со значением null. Теперь чтобы дать полный доступ на этот объект воспользуемся графическим интерфейсом для изменения прав. Он доступен по урлу: http://mzz/access/76/editACL. В этом окне кликнем на пользователя admin и выделим действие list, после чего нажмём кнопку "Установить права". Закроем это окно и обновим окно с новостью. Теперь видим сообщение:</p>
<<code>>Runtime Exception. Thrown in file D:\server\sites\mzz\system\template\mzzFileSmarty.php (Line: 50) with message:
Шаблон 'D:\server\sites\mzz\www/templates/commentsFolder/commentsFolder.list.tpl' отсутствует.<</code>>
<p>Это потому, что мы не создали необходимые шаблоны. Перейдём в каталог с шаблонами (www/templates) и создадим каталог comments, в котором создадим файл comments.list.tpl. В этот файл запишем произвольный текст для проверки - например 'hello world'. И снова обновим страницу. Теперь нашему взору должна предстать новость, после которой появилась наша надпись hello world.</p>