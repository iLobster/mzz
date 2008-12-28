{if $isEdit}
{include file='jipTitle.tpl' title='Редактирование класса'}
{else}
{include file='jipTitle.tpl' title='Добавление класса'}
{/if}

{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="name" value="Название"}</td>
            <td style='width: 80%;'>{form->text name="name" value=$data.name size="60"}{$errors->get('name')}</td>
        </tr>
        <tr id="gen_row">
        {*if !$isEdit*}
            <td style='width: 20%;'>{form->caption name="dest" value="Каталог генерации"}</td>
            <td style='width: 80%;'>{form->select name="dest" options=$data.dest one_item_freeze=1}{$errors->get('dest')}</td>
        {*/if*}
        </tr>
        <tr id="tpl_row">
            <td>{form->caption name="template" value="Шаблон"}</td>
            <td>{form->select name="template" emptyFirst="default (обычный)" options=$templates}</td>
        </tr>
        <tr>
            <td colspan="2">{form->checkbox id="bd_only" name="bd_only" text="Вносить изменения только в базу"  values="no|yes" value="no" size="60"}{$errors->get('bd_only')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
<script type="text/javascript">
{literal}
$('bd_only').observe('change', function(){
    $('gen_row').toggle();
    $('tpl_row').toggle();
})
{/literal}
</script>