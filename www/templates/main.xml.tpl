<?xml version="1.0" encoding="windows-1251"?>
<response>
     <html>
     <![CDATA[
     {$content}
     ]]>
     </html>
     {include file='include.xml.js.tpl'}

{if isset($execute_javascript)}{foreach from=$execute_javascript item=javascript}
     <execute>
     <![CDATA[
     {$javascript}
     ]]>
     </execute>
{/foreach}{/if}

</response>