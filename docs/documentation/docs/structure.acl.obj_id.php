<p><code>obj_id</code> это служебное поле, используемое в системе проверки прав доступа, а также в некоторых служебных целях в <a href="structure.orm.html#structure.orm">ORM</a>. Это поле должно присутствовать во всех таблицах, которые находятся под управлением ACL и ORM, и иметь тип integer. <code>obj_id</code> является уникальным в пределах проекта, т.е. не существует двух объектов с одинаковым значением этого параметра. Доступ к значению <code>obj_id</code> производится с помощью метода ДО getObjId(). Это достигается с помощью таблицы <a href="structure.acl.html#structure.acl.tables">sys_obj_id</a>.</p>
<p>Бывают ситуации, когда необходимо зарегистрировать объект в ACL и дать ему некоторое значение <code>obj_id</code>, но создавать целую сущность ради одной записи в таблице - не оправданно. Тогда следует прибегнуть к механизму так называемых "фейвовых" объектов. В терминологии мзз - это такие объекты, которые фактически не существуют в БД, однако зарегистрированы в ACL и имеют свои значения <code>obj_id</code>. Это реализуется с помощью метода <code>getObjectId()</code> <a href="structure.classes.html#structure.classes.toolkit">тулкита</a>. "Фейковые" объекты идентифицируются по имени. Пример получения <code>obj_id</code> для "фейкового" объекта:</p>
<<code php>>
$obj_id = $this->toolkit->getObjectId('sample_fake_object_name');
<</code>>
<p>В результате - если "фейковый" объект с именем <code>sample_fake_object_name</code> не существовал, то он будет создан и возвращено значение его <code>obj_id</code>, если уже существовал - тогда просто возвращён <code>obj_id</code>.</p>
<p>Также бывают ситуации, когда использование <code>obj_id</code> нецелесообразно. В число таких ситуаций можно отнести случаи, когда объекты не участвуют в ACL и когда использование лишнего поля - просто не имеет смысла. В число демо-приложения входят как минимум 2 класса, для которых <code>obj_id</code> не нужно - это <code>userAuth</code> и <code>userOnline</code>. Эти сущности предназначены для реализации "запоминания" аутентификации и хранения пользователей онлайн соответственно. "Отключение" использования <code>obj_id</code> для такого рода классов осуществляется следующим образом:</p>
<<code php>>
<?php
class userAuthMapper extends simpleMapper
{
        protected $obj_id_field = null;
        [...]
}
?>
<</code>>
<p>Т.е. достаточно защищённое свойство <code>$obj_id_field</code> установить в <code>null</code>.</p>