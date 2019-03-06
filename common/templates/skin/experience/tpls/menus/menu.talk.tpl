 {* Тема оформления Experience v.1.0  для Alto CMS      *}
 {* @licence     CC Attribution-ShareAlike   *}

<div class="panel panel-default panel-table raised">

    <div class="panel-body">

        <div class="panel-header">
            <i class="fa fa-envelope-o"></i>&nbsp;{$aLang.talk_menu_inbox}
        </div>

        {include file='actions/talk/action.talk.filter.tpl'}
        {include file='actions/talk/action.talk.speakers.tpl'}


    </div>

    <div class="panel-footer">
        <ul>
        <li><a class="link link-light-gray link-lead link-clear {if $sMenuSubItemSelect=='inbox'}active{/if}" href="{router page='talk'}">{$aLang.talk_menu_inbox}</a></li>
        {if $iUserCurrentCountTalkNew}
            <li><a class="link link-light-gray link-lead link-clear{if $sMenuSubItemSelect=='new'}active{/if}" href="{router page='talk'}inbox/new/">{$aLang.talk_menu_inbox_new}</a></li>
        {/if}
        <li><a class="link link-light-gray link-lead link-clear {if $sMenuSubItemSelect=='add'}active{/if}" href="{router page='talk'}add/">{$aLang.talk_menu_inbox_create}</a></li>
        <li><a class="link link-light-gray link-lead link-clear {if $sMenuSubItemSelect=='favourites'}active{/if}" href="{router page='talk'}favourites/">{$aLang.talk_menu_inbox_favourites}{if $iCountTalkFavourite} ({$iCountTalkFavourite}){/if}</a></li>
        <li><a class="link link-light-gray link-lead link-clear {if $sMenuSubItemSelect=='blacklist'}active{/if}" href="{router page='talk'}blacklist/">{$aLang.talk_menu_inbox_blacklist}</a></li>
        {hook run='menu_talk_talk_item'}

        <li class="pull-right marr0"><a href="#" class="link link-light-gray link-lead link-clear "
           onclick="jQuery('#block_talk_search_content').toggle(); return false;">
            <span class="hidden-xs visible-sm visible-lg visible-sm">{$aLang.talk_filter_title}</span>
            <span class="visible-xs hidden-md hidden-sm hidden-lg"><i class="fa fa-search"></i></span>
           </a></li> </ul>
    </div>
    {hook run='menu_talk'}
</div>