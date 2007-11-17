{include file="jipTitle.tpl" title="�������� ������"}
<script type="text/javascript">
jipWindow.autoSize();
{literal}
if (mzzFileBrowse.checkOptions()) {
    $(mzzFileBrowse.options.get('target')).up('form').select('input[type="hidden"][name="' + mzzFileBrowse.options.hiddenName + '"]').each(function(elm) {
        if ($('file-' + $F(elm))) {
            $('file-' + $F(elm)).addClassName('alreadySelectedFile');
        }
    });

}
{/literal}
</script>

<div class="fmBrowseInterfaceDetails">
<div id="fmBrowseDetailsWrap"><div class="helpMessage">�������� ���� �� ������ �����</div></div>
</div>
<div class="fmBrowseMainInterface">

<div class="fmBrowse">

{if empty($files)}
<div class="noticeMessage">����� �����. �������� ������.</div>
{/if}
{foreach from=$files item="file"}
    {if $file->extra() instanceof fmImageFile}
    <div class="fmBrowseThumbWrap" id="file-{$file->getId()}" ondblclick="mzzFileBrowse.selectFile(this, {$file->getId()});" onmousedown="mzzFileBrowse.makeSelected(this);">
        <div class="fmBrowseThumb"><img src="{$file->extra()->getThumbnail()}" title="{$file->getName()|htmlspecialchars}" alt="{$file->getName()}" /></div>
        <div class="fileDetails" style="display: none;">
        <strong>���:</strong><span>{$file->getName()}</span>
        <strong>������:</strong><span>{$file->getSize()|filesize}</span>
        <strong>��������:</strong><span>{$file->getModified()|date_format:"%e/%m/%Y %T"}</span>
        </div>
        <span title="{$file->getName()}">{$file->getName()|substr:0:14}{if strlen($file->getName()) > 14}...{/if}</span>
     </div>
    {/if}
{/foreach}


</div>
</div>