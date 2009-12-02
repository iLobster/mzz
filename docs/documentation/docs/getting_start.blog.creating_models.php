
<p>
Теперь нам необходимо создать модуль блог, структуру его директорий и, собственно, сами модели. Для этих целей во framy реализован web-интерфейс для управления модулями. Зайти в него можно по адресу <tt>http://framy.blog/admin/devToolbar</tt> используя стандартый логин и пароль (<tt>admin</tt> / <tt>test</tt>). В дальнейшем под словом devToolbar мы будем подразумевать именно этот интерфейс.
</p>

<p>Для создания модуля надо нажать на иконку рядом с &quot;Модули и классы&quot;. Имя для нового модуля: blog. Каталог генерации: каталог проекта (по умолчанию). Сохраним изменения и, если все успешно, мы увидим текст &quot;Модуль blog успешно создан&quot;. Перейдем к моделям.</p>

<p>
Модель Post будет содержать 5 свойств: идентификатор (<tt>name</tt>), заголовок (<tt>title</tt>), содержимое (<tt>content</tt>) и дату создания (<tt>created_at</tt>).
Выполним запрос в mysql для создания таблицы:
</p>

<<code mysql>>
CREATE TABLE `framy_blog`.`blog_post` (
    `name` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`name`)
) ENGINE = MyISAM;
<</code>>
<!-- В редактировании map ответим &quot;да&quot; на предложение обновить $map класса. -->
<p>В devToolbar, в секции модуля <tt>blog</tt>, создадим класс <tt>post</tt>. Имя таблицы <tt>blog_post</tt>.</p>

<p>Во Framy, действие (action) должно принадлежать какому-либо определенному объекту. Но что делать с действиями <tt>list</tt> и <tt>create</tt>? Для этого мы создаем фейковый объект и называем его, как правило, Folder. Создавать таблицу в базе данных необходимости нет, поэтому просто создадим класс <tt>postFolder</tt> для <tt>blog</tt> и укажем несуществующую таблицу <tt>blog_postFolder</tt>.</p>

<p>Для комментариев создадим только один объект <tt>postComment</tt>. Они тоже имеют действия, не связанные с конкретным комментарием, это <tt>comments</tt> и <tt>comment</tt>, но мы можем вместо фейкового использовать объект <tt>post</tt>. Начем с создания таблицы в базе данных:</p>
<<code mysql>>
CREATE TABLE `framy_blog`.`postComment` (
    `id` INT NOT NULL ,
    `post_id` INT NOT NULL ,
    `author_name` VARCHAR( 255 ) NOT NULL ,
    `content` TEXT NOT NULL ,
    `created_at` INT NOT NULL ,
    PRIMARY KEY ( `id` ) ,
    INDEX ( `post_id` )
) ENGINE = MYISAM ;
<</code>>
<p>Создаем класс <tt>postComment</tt> для модуля blog в devToolbar указав имя таблицы <tt>blog_postComment</tt>.</p>