<div class="panel panel-default sidebar raised widget widget-banneroid">
    <div class="panel-body">
        <div class="panel-content">
            {if !$oBanner->getBannerHtml()}
                <a href="{router page='banneroid'}redirect/{$oBanner->getBannerId()}/2/">
                    <img src="{$sBannersPath}{$oBanner->getBannerImage()}" />
                </a>
            {else}
                {$oBanner->getBannerHtml()}
            {/if}
        </div>
    </div>
</div>