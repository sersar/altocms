
{* ДОБАВИТЬ БАННЕР *}
<div class="btn-group">
    <a href="{router page='admin'}banneroid-add" class="btn btn-primary tip-top {if Router::GetActionEvent()=='banneroid-add'}active{/if}"
       title="{$aLang.plugin.banneroid.banneroid_add}"><i class="icon icon-plus"></i></a>
</div>

{* СПИСОК БАННЕРОВ *}
<div class="btn-group">
    <a class="btn btn-default {if Router::GetActionEvent()=='banneroid-list'}active{/if}" href="{router page='admin'}banneroid-list">
        {$aLang.plugin.banneroid.blog_menu_all}
    </a>
</div>

{* СТАТИСТИКА ПО БАННЕРАМ *}
<div class="btn-group">
    <a class="btn btn-default {if Router::GetActionEvent()=='banneroid-stats-banners'}active{/if}" href="{router page='admin'}banneroid-stats-banners">
        {$aLang.plugin.banneroid.banneroid_stats}
    </a>
</div>

{* ОБЩАЯ СТАТИСТИКА *}
<div class="btn-group">
    <a class="btn btn-default {if Router::GetActionEvent()=='banneroid-stats'}active{/if}" href="{router page='admin'}banneroid-stats">
        {$aLang.plugin.banneroid.banneroid_total_stat}
    </a>
</div>