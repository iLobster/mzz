{literal}
<script language="JavaScript">
function loadForm(id)
{
{/literal}
    var folderPath = '{$folder->getPath()}';
    var url = '{url route="withAnyParam" section="catalogue" name="' + folderPath + '" action="create"}';
{literal}
    new Ajax.Request(url,
    {
        method:'get',
            parameters: { 
            type: id 
        },
        onSuccess: 
            function(transport){
                var response = transport.responseText;
                document.getElementById('testform').innerHTML = response;
            },
        onFailure: 
            function(){ alert('Something went wrong...') }
    });
}
</script>
{/literal}

<div id="testform">
<div class="jipTitle">Добавление нового элемента - выбор типа создаваемого элемента</div>
<form onsubmit="return mzzAjax.sendForm(this);" {$form.attributes} >
{$form.javascript}
{$form.hidden}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td>{$form.type.label}</td> 
            <td>{$form.type.html}</td>
        <tr>
{foreach from=$fields item="element"}
        <tr>
            <td>{$form.$element.label}</td> 
            <td>{$form.$element.html}</td>
        <tr>
{/foreach}
        <tr>
            <td>{$form.submit.html}{$form.reset.html}</td>
        </tr>
    </table>
</form>
</div>
<script language="JavaScript">//loadForm(document.getElementById('type').value);</script>