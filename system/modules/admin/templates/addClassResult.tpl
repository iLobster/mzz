{include file='jipTitle.tpl' title='admin/class.adding'|i18n}
<div class="generatorSuccessResult">
{_ class.create_successfully $name $module}
</div>

<script type="text/javascript">
devToolbar.addClass('{$name}', '{$module}', [
{ldelim}url: "{url route="withId" section="admin" id=$id action="listActions"}", ico: "cog-edit", alt: "Действия классас"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="editClass"}", ico: "script-edit", alt: "Редактировать класс"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="deleteClass"}", ico: "script-del", alt: "Удалить класс"{rdelim}
]);
</script>
