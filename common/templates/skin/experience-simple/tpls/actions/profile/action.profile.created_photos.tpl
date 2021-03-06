 {* Тема оформления Experience v.1.0  для Alto CMS      *}
 {* @licence     CC Attribution-ShareAlike  http://site.creatime.org/experience/*}

{extends file="_profile.tpl"}

{block name="layout_profile_submenu"}
    {include file='menus/menu.profile_created.tpl'}
{/block}

{block name="layout_profile_content"}
    <script>
        jQuery(function () {
            jQuery('#js-profile-user-photos').altoImageManager({
                profile: {$oUserProfile->getId()}
            });
        });
    </script>

    <div id="js-profile-user-photos" class="panel panel-default user-friends sidebar flat">

        <div class="panel-body">

            <div class="row">
                <div class="col-sm-20">
                    <div class="modal-title">{$aLang.user_menu_publication_photos} <span id="aim-pages-container"></span></div>
                </div>
                <div class="col-sm-4">
                    <ul class="image-categories-nav list-unstyled list-inline list-no-border pull-right">
                        <li id="backTopics" style="display: none;">
                            <a class="image-categories-nav-back-topics" href="#">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                        </li>
                        <li id="backTalks" style="display: none;">
                            <a class="image-categories-nav-back-talks" href="#">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                        </li>
                        <li>
                            <a class="image-categories-nav-refresh" href="#">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div id="image-categories-tree-container" class="col-md-24 mab24">&nbsp;</div>
            </div>

            <div class="panel-content">
                <script id="aim-pages-template" type="template/javascript">
                    &nbsp;-&nbsp; {$aLang.insertimg_page} %page% {$aLang.insertimg_from} %pages%
                </script>

                <div id="image-container">
                    {include "actions/profile/created_photos/inject.images.topic.tpl" pre=true}
                </div>
            </div>


        </div>

    </div>


{/block}
