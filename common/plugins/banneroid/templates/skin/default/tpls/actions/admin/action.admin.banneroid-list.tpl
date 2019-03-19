{extends file="_index.tpl"}

{block name="content-bar"}
    {include file="{$aTemplatePathPlugin.banneroid}admin.banneroid.menu.content.bar.tpl"}
{/block}

{block name="content-body"}
    <script type="text/javascript" src="{$aTemplateWebPathPlugin.banneroid}js/banneroid.js"></script>

    <div class="span12">
        <div class="b-wbox">
            <div class="b-wbox-header">
                <h3 class="b-wbox-header-title">{$aLang.plugin.banneroid.banneroid_title}</h3>
            </div>
            <div class="b-wbox-content">
                {if $aBannersList}
                    <table class="table table-people table-talk">
                        <thead>
                        <tr>
                            <td>{$aLang.plugin.banneroid.banneroid_banner}</td>
                            <td class="center">{$aLang.plugin.banneroid.banneroid_place}</td>
                            <td class="center">{$aLang.plugin.banneroid.banneroid_direct}</td>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$aBannersList item=oBanner}
                            <tr>
                                <td><a href="{router page='admin'}banneroid-stats/{$oBanner->getId()}/" class="link">{$oBanner->getName()}</a></td>
                                <td class="center">{$oBanner->getPagesNames()}</td>
                                <td class="center">
                                    <a href="{router page='admin'}banneroid-edit/{$oBanner->getId()}/"><i class="icon icon-note"></i></a>
                                    <a href="javascript:if(confirm('{$aLang.plugin.banneroid.banneroid_delete}?'))window.location.href='{router page='admin'}banneroid-delete/{$oBanner->getId()}/';">
                                        <i class="icon icon-trash"></i>
                                    </a>
                                </td>
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