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
                    {if $add_banner}{$aLang.plugin.banneroid.banneroid_add}{else}{$aLang.plugin.banneroid.banneroid_edit}{/if}
                </h3>
            </div>
            <div class="b-wbox-content">
                <form method="post" action="" enctype="multipart/form-data" id="fmBanneroid" class="form-horizontal uniform">
                    <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />


                    {* НАЗВАНИЕ БАННЕРА *}
                    <div class="control-group">
                        <label for="banner_name" class="control-label">
                            {$aLang.plugin.banneroid.banneroid_name}:
                        </label>
                        <div class="controls">
                            <input class="input-wide" type="text" id="banner_name" name="banner_name" value="{$_aRequest.banner_name}"  />
                        </div>
                    </div>

                    {* УРЛ БАННЕРА *}
                    <div class="control-group">
                        <label for="banner_url" class="control-label">
                            {$aLang.plugin.banneroid.banneroid_url}:
                        </label>
                        <div class="controls">
                            <input class="input-wide" type="text" id="banner_url" name="banner_url" value="{$_aRequest.banner_url}"  />
                        </div>
                    </div>

                    {* ВИД БАННЕРА *}
                    <div id="kinds" class="control-group">
                        <label for="kind_image" class="control-label">
                            {$aLang.plugin.banneroid.banneroid_kind}:
                        </label>
                        <div class="controls inline-radio">
                            <div class="col-md-3">
                                <label><input name="banner_kind" type="radio" value="kind_image" {if $_aRequest.banner_is_image && $_aRequest.banner_html==''}checked="checked"{/if} />{$aLang.plugin.banneroid.banneroid_kind_image}</label>
                            </div>
                            <div class="col-md-3">
                                <label><input name="banner_kind" type="radio" value="kind_html" {if not $_aRequest.banner_is_image || $_aRequest.banner_html!=''}checked="checked"{/if} />{$aLang.plugin.banneroid.banneroid_kind_html}</label>
                            </div>
                        </div>
                    </div>

                    {* ИЗОБРАЖЕНИЕ *}
                    <div id="kind_image" class="control-group" {if not $_aRequest.banner_is_image || $_aRequest.banner_html!=''}style="display:none"{/if}>
                        <label for="banner_image" class="control-label mat5">
                            {$aLang.plugin.banneroid.banneroid_kind_image}:
                        </label>
                        <div class="controls">
                            <input class="w40p text" type="file" id="banner_image" name="banner_image"   /><br />
                            {if $_aRequest.banner_is_image}<img src="{$_aRequest.banner_image}" />{/if}
                        </div>
                    </div>

                    {* HTML-КОД *}
                    <div id="kind_html" class="control-group col-md-12" {if $_aRequest.banner_is_image && $_aRequest.banner_html==''}style="display:none"{/if}>
                        <label for="" class="control-label">
                            {$aLang.plugin.banneroid.banneroid_kind_html}:
                        </label>
                        <div class="controls ">
                            <textarea id="banner_html" name="banner_html" cols="40" rows="20" class="input-wide">{$_aRequest.banner_html}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            {* ДАТА ПОКАЗА БАННЕРА *}
                            <div class="control-group col-md-6">
                                <label for="banner_start_date" class="control-label">
                                    {$aLang.plugin.banneroid.banneroid_start_date}:
                                </label>
                                <div class="controls ">
                                    <input id='banner_start_date' name='banner_start_date' type='text' value='{$_aRequest.banner_start_date}' class='date datepicker-simple' />
                                </div>
                            </div>
                            <div class="control-group col-md-6">
                                <label for="banner_end_date" class="control-label">
                                    {$aLang.plugin.banneroid.banneroid_end_date}:
                                </label>
                                <div class="controls">
                                    <input id="banner_end_date" name="banner_end_date" type='text' value='{$_aRequest.banner_end_date}' class='date datepicker-simple'>
                                </div>
                            </div>
                        </div>
                    </div>

                    {* МЕСТО ОТОБРАЖЕНИЯ БАННЕРА *}
                    <div class="control-group">
                        <label for="kind_image" class="control-label">
                            {$aLang.plugin.banneroid.banneroid_place_zone}:
                        </label>
                        <div class="controls inline-radio">
                            <div class="col-md-3"><label><input name="banner_type" type="radio" value="1" {if $_aRequest.banner_type==1}checked="checked"{/if} />{$aLang.plugin.banneroid.banneroid_under_article}</label></div>
                            <div class="col-md-3"><label><input name="banner_type" type="radio" value="2" {if $_aRequest.banner_type==2}checked="checked"{/if} />{$aLang.plugin.banneroid.banneroid_side_bar}</label></div>
                            <div class="col-md-3"><label><input name="banner_type" type="radio" value="3" {if $_aRequest.banner_type==3}checked="checked"{/if} />{$aLang.plugin.banneroid.banneroid_body_begin}</label></div>
                            <div class="col-md-3"><label><input name="banner_type" type="radio" value="4" {if $_aRequest.banner_type==4}checked="checked"{/if} />{$aLang.plugin.banneroid.banneroid_body_end}</label></div>
                        </div>
                    </div>

                    {* СТРАНИЦЫ БАННЕРА *}
                    <div class="control-group">
                        <label for="kind_image" class="control-label">
                            {$aLang.plugin.banneroid.banneroid_page}:
                        </label>
                        <div class="controls inline-radio">
                            {foreach from=$_aRequest.banner_places item=ban_place}
                                <div class="col-md-3">
                                    <label>
                                        <input name="banner_place[]" type="checkbox" value="{$ban_place.place_id}" {if $aPages[$ban_place.place_id]}checked="checked"{/if} class="side_bar" />
                                        &nbsp;{$aLang.plugin.banneroid[$ban_place.place_name]}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    {* ВКЛ/ВЫКЛ *}
                    <div class="control-group">
                        <label for="kind_image" class="control-label">
                            {$aLang.plugin.banneroid.banneroid_active}:
                        </label>
                        <div class="controls inline-radio">
                                <div class="col-md-3">
                                    <label><input name="banner_is_active" type="hidden" value="0" />
                                        <input name="banner_is_active" type="checkbox" value="1" {if $_aRequest.banner_is_active}checked="checked"{/if}/>
                                    </label>
                                </div>
                        </div>
                    </div>

                    <br/><br/>

                    <input type="submit" name="submit_banner" value="{$aLang.plugin.banneroid.banneroid_save}" />
                    <input type="submit" name="cancel" value="{$aLang.plugin.banneroid.banneroid_cancel}"/>

                </form>
            </div>
        </div>
    </div>

{/block}