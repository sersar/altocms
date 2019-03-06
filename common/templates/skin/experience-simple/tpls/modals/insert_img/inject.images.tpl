{if $oTopic}
    <h6>{$oTopic->getTitle()}</h6>
{/if}
<div id="aim-page-images">
    {if $aResources}
        {include file="tpls/modals/insert_img/inject.params.tpl"}

        <script>

            //noinspection JSUnresolvedFunction
            $(function () {
                var $masonryContainer = $('.masonry-container');

                $masonryContainer.imagesLoaded( function() {
                    $masonryContainer.masonry({
                        itemSelector        : '.masonry-item',
                        columnWidth         : '.col-md-8',
                        transitionDuration  : 0
                    });
                });

            })
        </script>
        <div class="masonry-container">
            {foreach $aResources as $oItem}
                <div class="masonry-item col-md-8">
                    <a href="#" data-url="{$oItem->GetImgUrl()}"  onclick="return false;">
                        <img src="{$oItem->GetImgUrl('140x140')}" class="img-thumbnail" alt="image"/>
                    </a>
                </div>
            {/foreach}
        </div>

        <div class="clearfix" id="aim-images-nav" style="display: none;">
            <br/>
            <button id="images-next-page" class="refresh-tree btn pull-right btn-default btn-sm" disabled >
                {$aLang.next_page}
            </button>

            <button id="images-prev-page" class="btn btn-default btn-sm pull-right" disabled >
                {$aLang.prev_page}
            </button>
        </div>

    {else}
        {$aLang.select_category}
    {/if}
</div>