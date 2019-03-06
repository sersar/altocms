 {* Тема оформления Experience v.1.0  для Alto CMS      *}
 {* @licence     CC Attribution-ShareAlike   *}

{extends file="_profile.tpl"}

{block name="layout_profile_content"}
<div class="panel panel-default panel-wall raised">

    <div class="panel-body">
        {$oSession=$oUserProfile->getSession()}
        {$oVote=$oUserProfile->getVote()}

        <script type="text/javascript">
            ls.wall.init({
                login: '{$oUserProfile->getLogin()}'
            });

            jQuery(document).ready(function ($) {
                $("textarea").charCount({
                    allowed: 250,
                    warning: 0
                });
            });
        </script>

        <div class="panel-header">
            {$aLang.wall_add_title}
        </div>

        {if E::IsUser()}
            <form class="wall-submit">
                {if E::IsUser()}
                    <br/>
                    <textarea rows="4" id="wall-text" class="form-control js-wall-reply-parent-text"></textarea>
                    <div class="wall-controls">
                        <a class="btn btn-blue btn-big corner-no mat4"
                           onclick="ls.wall.add(jQuery('#wall-text').val(),0); return false;"
                           href="#">{$aLang.wall_add_submit}</a>
                        {*<a class="btn btn-light btn-big corner-no" href="#">предпросмотр</a>*}
                    </div>
                {else}
                    <div class="bg-warning">
                        {$aLang.wall_add_quest}
                    </div>
                {/if}
            </form>
        {else}
            <div id="wall-note-list-empty" class="text-center alert alert-info wall-note">
                <h5>{$aLang.wall_add_quest}</h5>
            </div>
        {/if}

        {if !count($aWall)}
            <div id="wall-note-list-empty" class="bg-warning">
                {$aLang.wall_list_empty}
            </div>
        {/if}

        <div id="wall-container" class="comments wall">
            {include file='actions/profile/action.profile.wall_items.tpl'}
        </div>

    </div>

    <div class="panel-footer">
        {if $iCountWall-count($aWall)}
            <a href="#" onclick="return ls.wall.loadNext();" id="wall-button-next" class="link link-dual link-lead link-clear"><span
                        class="wall-more-inner">{$aLang.wall_load_more} (<span
                            id="wall-count-next">{$iCountWall-count($aWall)}</span>)</span></a>
        {/if}
    </div>

</div>
{/block}
