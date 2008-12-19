{include file='jipTitle.tpl' title='Создание секции'}
<div class="generatorSuccessResult">
Секция "{$name}" добавлена
</div>

<script type="text/javascript">
addElementToList('{$name}', $A([
{ldelim}url: "{url route="withId" section="admin" id=$id action="deleteSection"}", img: "delete.gif", alt: "Удалить раздел"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="addModuleToSection"}", img: "classes.gif", alt: "Редактировать список модулей"{rdelim},
{ldelim}url: "{url route="withId" section="admin" id=$id action="editSection"}", img: "edit.gif", alt: "редактировать раздел"{rdelim}
]), 'sectionsAndClasses');
</script>