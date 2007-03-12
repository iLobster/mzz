<div id="ajaxGetForm">
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
                document.getElementById('ajaxGetForm').innerHTML = response;
                
                if (document.getElementsByClassName('jipTitle').length > 0) {
                    var jipTitle = document.getElementsByClassName('jipTitle').last();
                    var jipMoveDiv = document.createElement('div');
                    jipMoveDiv.id = 'jip-' + jipTitle.parentNode.id;
                    jipMoveDiv.setAttribute('title', 'Переместить');
                    Element.extend(jipMoveDiv);
                    jipMoveDiv.addClassName('jipMove');
                    jipMoveDiv.update('<img width="5" height="13" src="' + SITE_PATH + '/templates/images/jip/move.gif" alt="Переместить" title="Переместить" />');
                    jipTitle.insertBefore(jipMoveDiv, jipTitle.childNodes[0]);
                    this.drag = new Draggable('jip' + jipWindow.currentWindow, 'jip-' + jipTitle.parentNode.id);
                }
            },
        onFailure: 
            function(){ alert('Something went wrong...') }
    });
}
</script>
{/literal}
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