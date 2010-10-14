{form->hidden name="captcha_id" value=$captcha_id}
<img width="{if isset($attributes['width'])}{$attributes['width']}{else}120{/if}" height="{if isset($attributes['height'])}{$attributes['height']}{else}40{/if}" src="{url route="captcha" _rand=$captcha_id}" onclick="javascript: this.src = '{url route="captcha" _rand=$captcha_id}&amp;r=' + Math.random();" alt="Click to refresh"/>
<br/>
{form->text name=$attributes['name']}
