{add file="jip.css"}
{add file="jip.js"}
<div class="jipTitle">Добавление нового элемента - выбор типа создаваемого элемента</div>
{literal}
<script>
function loadForm(id)
{
{/literal}
    var folder = {$folder};
    var url = '{url route="withId" section="catalogue" id="' + id + '" action="save"}';
{literal}
    new Ajax.Request(url,
    {
    method:'post',
    parameters: { 
        folderId: folder, 
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
<select id="formSelector" onchange="javascript:loadForm(this.value);" onkeypress="this.onchange();">
{foreach from=$types item="type"}
    <option value="{$type.id}">{$type.title}</option>
{/foreach}
</select>
<div id="testform"></div>
<script>
    loadForm(document.getElementById('formSelector').value);
</script>