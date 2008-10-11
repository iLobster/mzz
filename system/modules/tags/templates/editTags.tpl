<div class="jipTitle">Редактирование тэгов</div>

{form action="$action" method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='vertical-align: top;'>Теги</td>
            <td>{form->textarea name="tags" value=$tags rows="4" cols="50"}</td>
        </tr>
        <tr>
            <td style='vertical-align: top;'>Личные тэги?</td>
            <td>{form->checkbox name="tags" name="shared" text="Общие тэги" value="0" values="0|1"}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
