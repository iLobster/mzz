{if !$errors->isEmpty()}
<div id="fmUploadStatusError">
<ul>
{foreach from=$errors->export() item=formError}
    <li>{$formError}</li>
{/foreach}
</ul></div>
{elseif isset($success) && isset($file_name)}
<div id="fmUploadStatus">���� {$file_name} ��������.</div>
{else}
{assign var="folderTitle" value=$folder->getTitle()}
{include file='jipTitle.tpl' title="�������� ����� � ������� $folderTitle"}

{form->open action=$form_action method="post" ajaxUpload="fm"}
    <table width="99%" border="0" cellpadding="5" cellspacing="0" class="systemTable" align="center">
        <tr>
            <td width="25%">��������� ����</td>
            <td width="75%">{$folder->getPath()}</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">{form->caption name="file" value="����"}</td>
            <td>{form->file name="file"}{$errors->get('file')}
            <span style="text-align:center; color: #999; font-size: 90%;">
                {if $folder->getFilesize() > 0}<br />����������� �� ������ ������������ �����: <b>{$folder->getFilesize()}</b> ��{/if}
                {assign var=exts value=$folder->getExts()}
                {if not empty($exts)}<br />����������� �� ���������� ������: <b>{$folder->getExts()}</b>{/if}
            </span></td>
        </tr>
        <tr>
            <td>{form->caption name="name" value="����� ���"}</td>
            <td>{form->text name="name"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td>{form->caption name="about" value="��������"}</td>
            <td>{form->textarea name="about"}{$errors->get('about')}</td>
        </tr>
        <tr>
            <td>{form->caption name="header" value="�������� � ������� �����������"}</td>
            <td>{form->checkbox name="header" value=0}{$errors->get('header')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit id="fmUploadSubmitButton" name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>
{/if}