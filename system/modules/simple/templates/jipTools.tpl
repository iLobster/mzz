{if $do eq 'close'}
    <script type="text/javascript">
    window.setTimeout(function() {ldelim}
        jipWindow.close({$howMany});
        jipWindow.refreshAfterClose({if $url === true}true{else}"{$url}"{/if});
    {rdelim}, {$timeout});
    </script>
    <p style="text-align: center; font-weight: bold; color: green; font-size: 120%;">{_ saving_changes}</p>
{elseif $do eq 'refresh'}
    <script type="text/javascript">
        jipWindow.refreshAfterClose({if $url === true}true{else}"{$url}"{/if});
    </script>
{elseif $do eq 'redirect'}
    <script type="text/javascript">
    {if !empty($url)}
        if (window.location == '{$url}')
            var targetURL = new String(window.location).replace('#' + window.location.hash, '');
        else
            var targetURL = '{$url}';
        window.location = targetURL;
    {else}
        window.location.reload();
    {/if}
    </script>
    <p align="center"><span id="jipLoad">{_ refreshing_window}</span></p>
{/if}