{include file='jipTitle.tpl' title='Создание модуля'}
{foreach from=$log item="item"}
    {$item}<br />
{/foreach}
<br />
<div class="generatorSuccessResult">
Модуль "{$name}" успешно создан в каталоге {$dest}
</div>

<script type="text/javascript">
addElementToList('{$name}', $A([
{ldelim}url: "{url route="withId" section="admin" id=$id action="deleteModule"}", img: "delete.gif", alt: "Удалить модуль"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="addClass"}", img: "add.gif", alt: "Добавить класс"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="listCfg"}", img: "config.gif", alt: "Параметры конфигурации"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="editModule"}", img: "edit.gif", alt: "Редактировать модуль"{rdelim}
]), 'modulesAndClasses', 'module-{$name}-classes');
</script>