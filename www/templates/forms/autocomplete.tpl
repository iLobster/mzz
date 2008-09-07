<div id="{$id}_autocompleter" class="autocomplete"></div>
<script type="text/javascript">
    var {$id}_autocompleter = new {if $type == 'local'}Autocompleter.Local{else}Ajax.Autocompleter{/if}('{$id}', '{$id}_autocompleter',
    {if $type == 'local'}{$data}{else}"{$SITE_PATH}{$data}"{/if},
    (autocompleterOptions && autocompleterOptions.{$id}) ? autocompleterOptions.{$id} : {ldelim}{rdelim}
    );
</script>
