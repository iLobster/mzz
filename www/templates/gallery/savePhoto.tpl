{assign var="albumTitle" value=$album->getName()}
{assign var="photoName" value=$photo->getName()}
<div class="jipTitle">{if $isEdit}�������������� "{$photo->getName()}" �� ������� {$albumTitle}{else}�������� ���� � ������ {$albumTitle}{/if}</div>
{if !$errors->isEmpty()}
    <div id="uploadStatusError">
    <ul>
    {foreach from=$errors->export() item=formError}
        <li>{$formError}</li>
    {/foreach}
    </ul></div>
{else}
    {if !$isEdit}
    <iframe name="fmUploadFile" id="fmUploadFile" style="border: 0;width: 200px;height: 100px;" src="about:blank"></iframe>
    <div id="uploadStatus"></div>
    <div id="uploadStatusError"></div>
    {literal}
    <script type="text/javascript">
    var fmUploadFileSubmitButtonValue = null;
    function readUploadStatus() {
        $('uploadStatus').style.display = 'none';
        $('uploadStatusError').style.display = 'none';
        var fmUploadFile = $('fmUploadFile');
        $('fmUploadFileSubmitButton').disable();;
        fmUploadFileSubmitButtonValue = $('fmUploadFileSubmitButton').value;
        $('fmUploadFileSubmitButton').value = "��������...";

        var frameOnLoadFunction = fmUploadFile.onload = function () {
            var statusDivId = fmUploadFile.contentWindow.document.getElementById('uploadStatusError') ?  'uploadStatusError' : 'uploadStatus';
            $(statusDivId).style.display = 'block';
            $(statusDivId).innerHTML = fmUploadFile.contentWindow.document.getElementById(statusDivId).innerHTML;

            $('fmUploadFileSubmitButton').enable();
            $('fmUploadFileSubmitButton').value = fmUploadFileSubmitButtonValue;
            if (statusDivId == 'uploadStatus') {
                $('fmUploadFileForm').reset();
                jipWindow.refreshAfterClose();
            }
        }

        fmUploadFile.onload = frameOnLoadFunction;
        if(/MSIE/.test(navigator.userAgent)) {
            (fmUploadFile.addEventListener || ('on', fmUploadFile.attachEvent))('on' + 'load', frameOnLoadFunction, false);
        }
    }

    function fmResetUploadForm() {
        var fmUploadFile = $('fmUploadFile').setStyle({'width': 0, 'height': 0, 'display': 'none'});
        $('uploadStatus').style.display = 'none';
        if (fmUploadFileSubmitButtonValue) {
            $('fmUploadFileSubmitButton').value = fmUploadFileSubmitButtonValue;
            $('fmUploadFileSubmitButton').enable();
        }
    }
    fmResetUploadForm();
    </script>
    {/literal}{/if}
    <form action="{$form_action}" method="post" {if !$isEdit}target="fmUploadFile" onsubmit="readUploadStatus();" enctype="multipart/form-data"{else}onsubmit="return jipWindow.sendForm(this);"{/if}>
        <table width="99%" border="0" cellpadding="5" cellspacing="0" class="systemTable" align="center">
            {if !$isEdit}<tr>
                <td style="vertical-align: top;">{form->caption name="image" value="����"}</td>
                <td>{form->file name="image"}{$errors->get('image')}
                {*<span style="text-align:center; color: #999; font-size: 90%;">
                    {if $folder->getFilesize() > 0}<br />����������� �� ������ ������������ �����: <b>{$folder->getFilesize()}</b> ��{/if}
                    {assign var=exts value=$folder->getExts()}
                    {if not empty($exts)}<br />����������� �� ���������� ������: <b>{$folder->getExts()}</b>{/if}
                </span> *}
                </td>
            </tr>{/if}
            <tr>
                <td>{form->caption name="name" value="�������� �����"}</td>
                <td>{form->text name="name" value="$photoName"}{$errors->get('name')}</td>
            </tr>
            <tr>
                <td colspan=2 style="text-align:center;">{form->submit id="fmUploadFileSubmitButton" name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
            </tr>
            </tr>
        </table>
    </form>
{/if}