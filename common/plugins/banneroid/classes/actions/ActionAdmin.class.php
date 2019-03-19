<?php

class PluginBanneroid_ActionAdmin extends PluginBanneroid_Inherit_ActionAdmin
{
    /**
     * Регистрация экшенов админки
     */
    protected function RegisterEvent()
    {
        parent::RegisterEvent();
        $this->AddEvent('banneroid-list', 'EventAdminBanneroidList');
        $this->AddEvent('banneroid-add', 'EventAdminBanneroidAdd');
        $this->AddEvent('banneroid-edit', 'EventAdminBanneroidEdit');
        $this->AddEvent('banneroid-delete', 'EventAdminBanneroidDelete');
        $this->AddEvent('banneroid-stats', 'EventAdminBanneroidStatistic');
        $this->AddEvent('banneroid-stats-banners', 'EventAdminBanneroidStatisticBanners');
    }
    
    /**
     * Статитика по баннерам
     * @return bool
     */
    protected function EventAdminBanneroidStatisticBanners()
    {
        if ($sBannerId = (int)$this->GetParam(0)) {
            $oBanner = $this->PluginBanneroid_Banner_GetBannerById($sBannerId);
            if (!$oBanner) {
                return Router::Action('error');
            }
            E::ModuleViewer()->Assign('oBanner', $oBanner);
            E::ModuleViewer()->Assign('aBannersStats', $this->PluginBanneroid_Banner_GetStatsBanners($sBannerId));
        } else {
            E::ModuleViewer()->Assign('aBannersStats', $this->PluginBanneroid_Banner_GetStatsBanners());
        }
        
        return false;
    }
    
    /**
     * Общая статистика
     */
    protected function EventAdminBanneroidStatistic()
    {
        E::ModuleViewer()->Assign('aBannersStats', $this->PluginBanneroid_Banner_GetStatsTotal());
    }
    
    /**
     * Список баннеров
     */
    protected function EventAdminBanneroidList()
    {
        $this->sMainMenuItem = 'content';
        
        E::ModuleViewer()->Assign('aBannersList', $this->PluginBanneroid_Banner_GetBannersList());
        $this->_setTitle(E::ModuleLang()->Get('plugin.banneroid.banneroid_title'));
    }
    
    /**
     * Добавление баннера
     */
    protected function EventAdminBanneroidAdd()
    {
        $this->sMainMenuItem = 'content';
        
        $oBanner = new PluginBanneroid_ModuleBanner_EntityBanner();
        $oBanner->setBannerStartDate();
        $oBanner->setBannerId(0);
        E::ModuleViewer()->Assign('add_banner', 1);
        
        if (getRequest('submit_banner')) {
            if ($this->PluginBanneroid_Banner_Save($oBanner)) {
                E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('plugin.banneroid.banneroid_ok_add'), E::ModuleLang()->Get('attention'), true);
                Router::Location(Config::Get("path.root.web") . 'admin/banneroid-list/');
            }
        }
        
        
        E::ModuleViewer()->Assign('oBanner', $oBanner);
        $_REQUEST['banner_places'] = $this->PluginBanneroid_Banner_GetAllPages();
        $_REQUEST['banner_start_date'] = date('Y-m-d');
        $_REQUEST['banner_end_date'] = '0000-00-00';
        $_REQUEST['banner_is_image'] = true;
        $_REQUEST['banner_type'] = 1;
        
        
        $this->_setTitle(E::ModuleLang()->Get('plugin.banneroid.banneroid_edit'));
    }
    
    /**
     * Редактирование баннера
     */
    protected function EventAdminBanneroidEdit()
    {
        $this->sMainMenuItem = 'content';
        
        $sBannerId = (int)$this->GetParam(0); // Id of current banner
        
        $oBanner = $this->PluginBanneroid_Banner_GetBannerById($sBannerId);
        
        if (!$oBanner) {
            return Router::Action('error');
        }
        
        if (getRequest('submit_banner')) {
            if ($this->PluginBanneroid_Banner_Save($oBanner)) {
                E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('plugin.banneroid.banneroid_ok_edit'), E::ModuleLang()->Get('attention'), true);
                Router::Location(Config::Get("path.root.web") . 'admin/banneroid-list/');
            }
        }
        
        
        E::ModuleViewer()->Assign('oBanner', $oBanner);
        E::ModuleViewer()->Assign('aPages', $this->PluginBanneroid_Banner_GetActivePages($oBanner));
        
        $_REQUEST['banner_name'] = $oBanner->getBannerName();
        $_REQUEST['banner_html'] = $oBanner->getBannerHtml();
        $_REQUEST['banner_url'] = $oBanner->getBannerUrl();
        $_REQUEST['banner_lang'] = $oBanner->getBannerLang();
        $_REQUEST['banner_start_date'] = $oBanner->getBannerStartDate();
        $_REQUEST['banner_end_date'] = $oBanner->getBannerEndDate();
        $_REQUEST['banner_is_active'] = $oBanner->getBannerIsActive();
        $_REQUEST['banner_places'] = $this->PluginBanneroid_Banner_GetAllPages();
        $_REQUEST['banner_type'] = $oBanner->getBannerType();
        
        if (strlen(@$oBanner->getBannerImage())) {
            $_REQUEST['banner_image'] = Config::Get("plugin.banneroid.images_dir") .
                $oBanner->getBannerImage();
            $_REQUEST['banner_is_image'] = true;
        }
        
        $this->_setTitle(E::ModuleLang()->Get('plugin.banneroid.banneroid_edit'));
        $this->SetTemplateAction('banneroid-add');
    }
    
    /**
     * Удаление баннера
     */
    protected function EventAdminBanneroidDelete()
    {
        $sBannerId = $this->GetParam(0);
        
        $this->PluginBanneroid_Banner_HideBanner($sBannerId);
        E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('plugin.banneroid.banneroid_ok_delete'), E::ModuleLang()->Get('attention'), true);
        
        Router::Location(Config::Get("path.root.web") . 'admin/banneroid-list/');
    }
}