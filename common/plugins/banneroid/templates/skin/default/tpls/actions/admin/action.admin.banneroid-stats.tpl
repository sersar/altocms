{extends file="_index.tpl"}

{block name="content-bar"}
    {include file="{$aTemplatePathPlugin.banneroid}admin.banneroid.menu.content.bar.tpl"}
{/block}

{block name="content-body"}
    <script type="text/javascript" src="{$aTemplateWebPathPlugin.banneroid}js/banneroid.js"></script>

    <div class="span12">
        <div class="b-wbox">
            <div class="b-wbox-header">
                <h3 class="b-wbox-header-title">
                    {$aLang.plugin.banneroid.banneroid_total}
                </h3>
            </div>
            <div class="b-wbox-content">
                    <div style="margin-bottom: 15px;">
                        <form action="" method="post" id="statsForm">
                            <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
                            <input name='banner_start_date' type='text' value='{$_aRequest.banner_start_date}' class='date datepicker-simple' />
                            <input name='banner_end_date' type='text' value='{$_aRequest.banner_end_date}' class='date datepicker-simple' />
                            <input name="filter" type="submit" value="{$aLang.plugin.banneroid.banneroid_date_filter}" />
                        </form>
                    </div>
                    {if $aBannersStats}
                        <table class="table table-people table-talk">
                            <thead>
                            <tr>
                                <td>{$aLang.plugin.banneroid.banneroid_place_zone}</td>
                                <td class="center">{$aLang.plugin.banneroid.banneroid_clics}</td>
                                <td class="center">{$aLang.plugin.banneroid.banneroid_displays}</td>
                            </tr>
                            </thead>

                            <tbody>
                            {foreach from=$aBannersStats key=place item=stats}
                                <tr>
                                    <td>{$place}</td>
                                    <td class="center">{$stats.click_count}</td>
                                    <td class="center">{$stats.view_count}</td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    {else}
                        {$aLang.plugin.banneroid.banneroid_empty}
                    {/if}
            </div>
        </div>
    </div>
{/block}