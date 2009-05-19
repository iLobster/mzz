{include file='jipTitle.tpl' title='admin/module.adding'|i18n}
<div class="generatorSuccessResult">
{_ module.create_successfully $name $dest}
</div>

<script type="text/javascript">
devToolbar.addModule('{$name}', [
{ldelim}url: "{url route="withId" section="admin" id=$id action="deleteModule"}", img: "delete.gif", alt: "Удалить модуль"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="addClass"}", img: "add.gif", alt: "Добавить класс"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="listCfg"}", img: "config.gif", alt: "Параметры конфигурации"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="editModule"}", img: "edit.gif", alt: "Редактировать модуль"{rdelim}
]);
</script>