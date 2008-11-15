{if $do eq 'close'}
    <script type="text/javascript">
    window.setTimeout(function() {ldelim}
        jipWindow.close({$howMany});
        jipWindow.refreshAfterClose({if $url === true}true{else}"{$url}"{/if});
    {rdelim}, {$timeout});
    </script>
    <p style="text-align: center; font-weight: bold; color: green; font-size: 120%;">Сохранение изменений...</p>
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
        window.location.reload(true);
    {/if}
    </script>
    <p align="center"><span id="jipLoad">Обновление окна браузера...</span></p>
{/if}