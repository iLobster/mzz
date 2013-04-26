<div class="jipTitle">Редактирование конфигурации модуля <i>{$module_name}</i></div>
{form action=$form_action method="post" jip=true class="mzz-jip-form"}
{foreach from=$config_data key=config_key item=config_value}
<div class="field">
    <div class="label">
        {form->caption name="config[`$config_key`]" value="$config_key"}
    </div>
    <div class="text">
        {if is_scalar($config_value)}
            {form->text name="config[`$config_key`]" size="30" value=$config_value}
        {else}
            Not a scalar value;
        {/if}
    </div>
</div>
{/foreach}
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>