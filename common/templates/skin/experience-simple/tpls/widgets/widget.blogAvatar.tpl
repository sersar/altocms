{* Тема оформления Experience v.1.0  для Alto CMS      *}
{* @licence     CC Attribution-ShareAlike  http://site.creatime.org/experience/*}

{if $_aRequest.blog_id}{$sTarget_id=$_aRequest.blog_id}{else}{$sTarget_id=0}{/if}

<div class="panel panel-default sidebar flat widget widget-blog">
    <div class="panel-body">
        <div class="panel-header">
            <i class="fa fa-image"></i>
            {$aLang.widget_blog_avatar_block}
        </div>

        <div class="panel-content">
            {* БЛОК ЗАГРУЗКИ ИЗОБРАЖЕНИЯ *}
            <div class              ="js-alto-uploader"
                 data-target        ="blog_avatar"
                 data-target-id     ="{$sTarget_id}"
                 data-empty         ="{asset file="images/empty_image.png" theme=true}"
                 data-preview-crop  ="252x252crop"
                 data-crop          ="no">

                {* Картинка фона блога *}
                {img attr=[
                    'src'           => "{asset file="images/empty_image.png" theme=true}",
                    'alt'           => "image",
                    'class'         => "thumbnail js-uploader-image fill-width",
                    'target-type'   => "blog_avatar",
                    'crop'          => '252x252crop',
                    'target-id'     => "{$sTarget_id}"
                ]}

                {* Меню управления аватаром блога *}
                <div class="uploader-actions blog-uploader-actions tac">

                    <div>
                        {* Кнопка загрузки картинки *}
                        <a class="js-uploader-button-upload" href="#" onclick="return false">
                            <i class="fa fa-upload"></i>&nbsp;
                            {$aLang.uploader_image_upload}
                            {* Файл для загрузки *}

                        </a>
                        <input type="file" name="uploader-upload-image" class="uploader-actions-file js-uploader-file">
                    </div>

                </div>


                <div class="uploader-actions tac">
                    {* Кнопка удаления картинки *}
                    <a href="#" onclick="return false;" class="js-uploader-button-remove"
                       {if !$bImageIsTemporary}style="display: none;"{/if}>
                        <i class="fa fa-times"></i>&nbsp;{$aLang.uploader_image_delete}
                    </a>
                </div>

                {* Форма обрезки картинки при ее загрузке *}
                {include_once file="modals/modal.crop_img.tpl"}

            </div>
        </div>

    </div>
</div>