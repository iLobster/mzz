{include file="jipTitle.tpl" title="Менеджер файлов"}
{literal}
<script type="text/javascript">
cssLoader.load(SITE_PATH + '/templates/css/fileBrowse.css');
jipWindow.autoSize();
var mzzFileBrowse = {
    lastFile: false,

    makeSelected: function(elm)
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

    selectFile: function(elm, fileId)
    {
        if (!mzzRegistry.has('fileBrowseOptions')) {
            alert('Переменная "fileBrowseOptions", содержащая настройки менеджера файлов, не установлена в Registry.');
            return false;
        }
        var fileBrowseOptions = mzzRegistry.get('fileBrowseOptions');

        if (typeof(fileBrowseOptions.target) == 'undefined') {
            alert('Опция "target" для менеджера файлов, содержащая идентификатор списка для вставки, не установлена.');
            return false;
        }


        if (typeof(fileBrowseOptions.hiddenName) == 'undefined') {
            alert('Опция "hiddenName" для менеджера файлов, содержащая имя скрытого поля формы с выбранными файлами, не установлена.');
            return false;
        }
        if (!$(fileBrowseOptions.target)) {
            alert('Элемент с идентификатором "' + elmId + '" не найден.');
            return false;
        }

        var isMultiple = fileBrowseOptions.hiddenName.endsWith('[]');

        elm = $(elm);

        var fileThumb = (elm.getElementsBySelector('img') || [])[0];

        $(fileBrowseOptions.target).up('form').insert(new Element("input", { name: fileBrowseOptions.hiddenName, value: fileId, type: "hidden" }));

        var newThumb = '<div class="fmBrowseThumbWrap">'
        + '<div class="fmBrowseThumb"><img src="' + fileThumb.src + '" title="' + fileThumb.title + '" alt="' + fileThumb.alt + '" /></div>'
        + '<span><a href="#" onclick="if (confirm(\'Вы уверены что хотите удалить этот файл?\')) { var _elm = $(this).up(\'div.fmBrowseThumbWrap\'); new Effect.Fade(_elm, {afterFinish: function() { _elm.remove(); } }); } return false;">убрать</a></span></div>';

        isMultiple ? $(fileBrowseOptions.target).insert(newThumb) : $(fileBrowseOptions.target).update(newThumb);

        if (isMultiple) {
            new Effect.Highlight(elm);
        } else {
            jipWindow.close();
        }
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
<div id="fmBrowseDetailsWrap"><div class="helpMessage">Выберите файл из правой части</div></div>
</div>
<div class="fmBrowseMainInterface">

<div class="fmBrowse">

{if empty($files)}
<div class="noticeMessage">Папка пуста. Выбирать нечего.</div>
{/if}
{foreach from=$files item="file"}
    {if $file->extra() instanceof fmImageFile}
    <div class="fmBrowseThumbWrap" id="file-{$file->getId()}" ondblclick="mzzFileBrowse.selectFile(this, {$file->getId()});" onmousedown="mzzFileBrowse.makeSelected(this);">
        <div class="fmBrowseThumb"><img src="{url route="fmFolder" name=$file->extra()->getThumbnail()->getFullPath()}" title="{$file->getName()|htmlspecialchars}" alt="{$file->getName()}" /></div>
        <div class="fileDetails" style="display: none;">
        <strong>Имя:</strong><span>{$file->getName()}</span>
        <strong>Размер:</strong><span>{$file->getSize()|filesize}</span>
        <strong>Изменено:</strong><span>{$file->getModified()|date_format:"%e/%m/%Y %T"}</span>
        </div>
        <span title="{$file->getName()}">{$file->getName()|substr:0:14}{if strlen($file->getName()) > 14}...{/if}</span>
     </div>
    {/if}
{/foreach}


</div>
</div>





