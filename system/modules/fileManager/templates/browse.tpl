{include file="jipTitle.tpl" title="Браузер"}
{literal}
<script type="text/javascript">
jipWindow.autoSize();
var mzzFileBrowse = {
    lastFile: false,

    selectFile: function(elm)
    {
        if (this.lastFile == elm.id) {
            return;
        }
        if (this.lastFile) {
            $(this.lastFile).removeClassName('selectedFile');
        }
        $(elm).addClassName('selectedFile');
        this.lastFile = elm.id;
        this.showDetails(elm);
    },

    showDetails: function(elm)
    {
        new Effect.Opacity('fmBrowseDetailsWrap', {duration:0.2, from:1.0, to:0.01,
        afterFinish: function() {
            elm = $(elm);
            var fileThumb = (elm.getElementsBySelector('img') || [])[0];
            var details = '<div class="fmBrowseDetails">';
            if (fileThumb) {
                details += '<img src="' + fileThumb.src + '" title="' + fileThumb.title + '" />';
            }
            details += '<div class="fmBrowseDetailsText">' + ((elm.getElementsByClassName('fileDetails') || [])[0].innerHTML) + '</div></div>';

            $('fmBrowseDetailsWrap').update(details);
            new Effect.Opacity('fmBrowseDetailsWrap', {duration: 0.2, from: 0.01, to: 1.0});
        }

        });

    }
}
</script>
{/literal}



<div class="fmBrowseInterfaceDetails">
<div id="fmBrowseDetailsWrap">Выберите файл из правой части</div>
</div>
<div class="fmBrowseMainInterface">

<div class="fmBrowse">

{if empty($files)}
<div class="noticeMessage">Папка пуста. Выбирать нечего.</div>
{/if}
{foreach from=$files item="file"}
    {if $file->extra() instanceof fmImageFile}
    <div class="fmBrowseThumbWrap" id="file-{$file->getId()}" onclick="mzzFileBrowse.selectFile(this);">
        <div class="fmBrowseThumb"><img src="{url route="fmFolder" name=$file->extra()->getThumbnail()->getFullPath()}" title="{$file->getName()}" alt="{$file->getName()}" /></div>
        <div class="fileDetails" style="display: none;">
        <strong>Имя:</strong><span>{$file->getName()}</span>
        <strong>Размер:</strong><span>{$file->getSize()}</span>
        <strong>Изменено:</strong><span>Today</span>
        </div>
        <span>{$file->getName()|substr:0:14}{if strlen($file->getName()) > 14}...{/if}</span>
     </div>
    {/if}
{/foreach}


</div>
</div>





