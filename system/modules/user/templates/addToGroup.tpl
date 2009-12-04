{if !isset($filter)}
    <div class="jipTitle">{_ add_user_to_group} <b>{$group->getName()}</b></div>
    <div style="padding: 15px;">
        <form action="{url}" id='filterForm' method="get" onsubmit="addToGroupSearch(this); return false;">
            <script>{literal}
            (function($){
                addToGroupSearch = function (form){
                    var frm = $(form);
                    $('#users').load(frm.attr('action'), frm.serializeArray());
                    return false;
                }
            })(jQuery);
            {/literal}
            </script>
            {_ username}: <input type="text" value="" name="filter"> <input type="image" src="{$SITE_PATH}/images/search.gif">
        </form>
    </div>
    <div id='users' style='padding: 15px;'>
    </div>
{else}
    {if not empty($too_much)}
        {_ refine_search}
    {else}
        <span style="font-size: 110%;">{_ search_result} ({$users->count()} {_ found})</span>
        <div style="border-top: 2px solid #BABABA; padding: 10px;">
            {form action={url} method="post" jip=true}
                <table border="0" width="100%" cellpadding="2" cellspacing="0" class="systemTable">
                    {foreach from=$users item=user key=user_id}
                        <tr>
                            <td align="center" width="10px">{$user->getId()}</td>
                            <td width="20px" align="center">
                                {form->checkbox name="users[$user_id]" id="users_`$user_id`" value=0 nodefault=1}
                            </td>
                            <td><label for="users_{$user->getId()}">{$user->getLogin()}</label></td>
                        </tr>
                    {/foreach}

                    <tr>
                        <td colspan="2">{form->submit name="submit" value="_ simple/save"}</td>
                        <td>{form->reset jip=true name="reset" value="_ simple/cancel"}</td>
                    </tr>
                </table>
            </form>
        </div>
    {/if}
{/if}