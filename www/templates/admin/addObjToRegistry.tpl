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
{foreach name=section_loop key=section_name item=sections from=$classes}
'{$section_name}' : {literal}{{/literal}
    {foreach item=classes from=$sections name=class_loop}
        {$classes.id}:  '{$classes.class}' {if $smarty.foreach.class_loop.last eq false},{/if}
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
   $H(classes[$F(select)]).each(function(pair) {
       addobjClass.options[i++] = new Option(pair.value, pair.key);
   });
   (i > 0) ? addobjClass.enable() : addobjClass.disable();
   addobjClass.selectedIndex = 0;
   addobjClass.activate();

}
{/literal}
</script>
<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.section.label}</td>
            <td>{$form.section.html}{$form.section.error}</td>
            <td>{$form.class.label}</td>
            <td>{$form.class.html}</td>
        </tr>
        <tr>
            <td colspan="4">{$form.class.error}</td>
        </tr>
        <tr>
            <td colspan=4 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>