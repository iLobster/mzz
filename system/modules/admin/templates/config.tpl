{$module_name}<br />
{foreach from=$config_data key=config_key item=config_value}
    {$config_key}:&nbsp;
    {if is_scalar($config_value)}
        {$config_value}
    {else}
        Not a scalar value;
    {/if}<br />
{/foreach}
<a href="http://framy.local/en/admin/admin/config" class="mzz-jip-link mzz-jip-link-new">test</a>
