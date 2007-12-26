{if $action eq 'addObjToRegistry'}
{include file='jipTitle.tpl' title='Добавление объекта в реестр доступа'}
{else}
{include file='jipTitle.tpl' title='Редактирование объекта в реестре доступа'}
{/if}

<script type="text/javascript">
{strip}
{literal}
var classes = $H({
{/literal}
{foreach name=section_loop key=section_name item=sectionInfo from=$classes}
'{$section_name}' : {literal}{{/literal}
    {foreach item=classInfo from=$sectionInfo name=class_loop}
        {$classInfo.id}:  '{$classInfo.class}' {if $smarty.foreach.class_loop.last eq false},{/if}
    {/foreach}{literal}}{/literal}
    {if $smarty.foreach.section_loop.last eq false},{/if}
{/foreach}
{literal}
});
{/literal}
{/strip}

{literal}
function addObjChangeClass(select) {
    var addobjClass = $('addobj_class');
    addobjClass.options.length = 0;

    var i = 0;
    $H(classes.get($F(select))).each(function(pair) {
        addobjClass.options[i++] = new Option(pair.value, pair.key);
    });

    i ? addobjClass.enable() : addobjClass.disable();

    addobjClass.selectedIndex = 0;
    addobjClass.activate();
}
{/literal}
</script>
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="section" value="Секция" onError="style=color: red;"}</td>
            <td>{form->select name="section" options=$sections emptyFirst=true id="addobj_section" onchange="addObjChangeClass(this)" onkeypress="this.onchange()"}</td>
            <td>{form->caption name="class" value="Класс" onError="style=color: red;"}</td>
            <td>{form->select name="class" emptyFirst=true id="addobj_class" style="width: 150px;" disabled="disabled"}</td>
        </tr>
        <tr>
            <td colspan="4">{$errors->get('section')}{if $errors->has('class')}<br />{$errors->get('class')}{/if}</td>
        </tr>
        <tr>
            <td colspan=4 style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>