<div class="jipTitle">Добавление нового элемента - выбор типа создаваемого элемента</div>
{literal}
<script>
function loadForm(id)
{
    new Ajax.Request('/catalogue/' + id + '/save',
    {
    method:'post',
    parameters: { 
    {/literal}
        folderId:{$folder}, 
    {literal}
        typeId: id 
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

<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
{$form.hidden}
{$form.javascript}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td><strong>{$form.type.label}</strong></td>
            <td>{$form.type.html}</td>
        </tr>
        <tr>
            <td><strong>{$form.submit.label}</strong></td>
        </tr>
    </table>
</form>
<div id="testform"></div>