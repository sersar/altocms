<?php

class PluginBanneroid_HookBanneroid extends Hook
{
    /**
     * Register Hooks
     *
     * @return void
     */
    public function RegisterHook()
    {
        if (Router::GetAction() == 'admin') {
            return;
        }
        if (isset($_SERVER['REQUEST_URI'])) {
//            $this->AddHook('init_action', 'AddBannerBlock', __CLASS__, -100);
            $this->AddHook('template_layout_body_begin', 'AddBannerBlock', __CLASS__, -100);
            $this->AddHook(Config::Get('plugin.banneroid.banner_content_hook'), 'AddBannersInContent', __CLASS__, 0);
            $this->AddHook('template_layout_body_begin', 'AddBannersInHeader', __CLASS__, 0);
            $this->AddHook('template_layout_body_end', 'AddBannersInFooter', __CLASS__, 0);
        }
    }
    
    
    /**
     * Hook Handler
     * Add banners block to side bar
     *
     * @return mixed
     */
    public function AddBannerBlock()
    {
        if (in_array(Router::GetAction(), Config::Get('plugin.banneroid.banner_skip_actions'))) {
            return '';
        }
        $aBanners = $this->PluginBanneroid_Banner_GetSideBarBanners($_SERVER['REQUEST_URI'], true);
        if (count($aBanners)) { //Insert banner block
//            E::ModuleViewer()->AddWidget('right', 'widgets/widget.banneroid.tpl', array(
            E::ModuleViewer()->AddWidget('right', 'banneroid', array(
                'plugin' => 'banneroid',
                'aBanners' => $aBanners
            ), Config::Get('plugin.banneroid.banner_block_order'));
        }
        return '';
    }
    
    /**
     * Hook Handler
     * Add banners to content footer
     *
     * @return mixed
     */
    public function AddBannersInContent()
    {
        if (in_array(Router::GetAction(), Config::Get('plugin.banneroid.banner_skip_actions'))) {
            return false;
        }
        
        $aBanners = $this->PluginBanneroid_Banner_GetContentBanners($_SERVER['REQUEST_URI'], true);
        if (count($aBanners)) { //Insert banner block
            E::ModuleViewer()->Assign("aBanners", $aBanners);
            E::ModuleViewer()->Assign('sBannersPath', Config::Get("plugin.banneroid.images_dir"));
            return E::ModuleViewer()->Fetch(
                Plugin::GetTemplatePath(__CLASS__) . 'tpls/content.banneroid.tpl');
        }
    }
    
    /**
     * Hook Handler
     * Add banners to body header
     *
     * @return mixed
     */
    public function AddBannersInHeader()
    {
        if (in_array(Router::GetAction(), Config::Get('plugin.banneroid.banner_skip_actions'))) {
            return false;
        }
        
        $aBanners = $this->PluginBanneroid_Banner_GetHeaderBanners($_SERVER['REQUEST_URI'], true);
        if (count($aBanners)) { //Insert banner block
            E::ModuleViewer()->Assign("aBanners", $aBanners);
            E::ModuleViewer()->Assign('sBannersPath', Config::Get("plugin.banneroid.images_dir"));
            return E::ModuleViewer()->Fetch(
                Plugin::GetTemplatePath(__CLASS__) . 'tpls/header.banneroid.tpl');
        }
    }
    
    /**
     * Hook Handler
     * Add banners to body footer
     *
     * @return mixed
     */
    public function AddBannersInFooter()
    {
        if (in_array(Router::GetAction(), Config::Get('plugin.banneroid.banner_skip_actions'))) {
            return false;
        }
        
        $aBanners = $this->PluginBanneroid_Banner_GetFooterBanners($_SERVER['REQUEST_URI'], true);
        if (count($aBanners)) { //Insert banner block
            E::ModuleViewer()->Assign("aBanners", $aBanners);
            E::ModuleViewer()->Assign('sBannersPath', Config::Get("plugin.banneroid.images_dir"));
            return E::ModuleViewer()->Fetch(
                Plugin::GetTemplatePath(__CLASS__) . 'tpls/footer.banneroid.tpl');
        }
    }
}