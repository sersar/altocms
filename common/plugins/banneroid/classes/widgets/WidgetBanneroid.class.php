<?php

class PluginBanneroid_WidgetBanneroid extends Widget
{
    public function Exec()
    {
        $aBanners = $this->GetParam('aBanners');
        if (isset($aBanners[0])) {
            E::ModuleViewer()->Assign("oBanner", $aBanners[0]);
        }
        E::ModuleViewer()->Assign('sBannersPath', Config::Get("plugin.banneroid.images_dir"));
    }
}