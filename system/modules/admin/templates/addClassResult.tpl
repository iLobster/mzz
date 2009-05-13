{include file='jipTitle.tpl' title='admin/class.adding'|i18n}
<div class="generatorSuccessResult">
{_ class.create_successfully $name $module}
</div>

<script type="text/javascript">
addClassToModule('{$name}', '{$module}', ($A([
{ldelim}url: "{url route="withId" section="admin" id=$id action="listActions"}", img: "actions.gif", alt: "Действия классас"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="editClass"}", img: "edit.gif", alt: "Редактировать класс"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="deleteClass"}", img: "delete.gif", alt: "Удалить класс"{rdelim}
])).reverse());
</script>
