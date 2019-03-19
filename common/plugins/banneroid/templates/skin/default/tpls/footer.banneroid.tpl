{foreach from=$aBanners item=oBanner}
    {if !$oBanner->getBannerHtml()}
        <a href="{router page='banneroid'}redirect/{$oBanner->getBannerId()}/1/">
            <img src="{$sBannersPath}{$oBanner->getBannerImage()}" />
        </a>
        {else}
            {$oBanner->getBannerHtml()}
        {/if}
{/foreach}
