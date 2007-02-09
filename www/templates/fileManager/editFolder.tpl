<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table width="100%" border="1" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td colspan=2 style="text-align:center;">{if $action eq 'editFolder'}Редактирование{else}Создание{/if} каталога</td>
        </tr>
        <tr>
            <td>{$form.name.label}</td>
            <td>{$form.name.html}{$form.name.error}</td>
        </tr>
            <td>{$form.title.label}</td>
            <td>{$form.title.html}{$form.title.error}</td>
        </tr>
        </tr>
            <td>{$form.filesize.label}</td>
            <td>{$form.filesize.html}{$form.filesize.error}</td>
        </tr>
        </tr>
            <td>{$form.exts.label}</td>
            <td>{$form.exts.html}{$form.exts.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>