<?php

class PluginBanneroid_ActionBanneroid extends ActionPlugin
{
    /**
     * Абстрактный метод инициализации экшена
     *
     */
    public function Init()
    {
    
    }
    
    /**
     * Регистрация ивентов
     *
     * @return void
     */
    protected function RegisterEvent()
    {
        $this->AddEvent('redirect', 'EventBannerRedirect');
    }
    
    
    /**
     * Перенаправление клика баннера с подсчетом суммы кликов
     *
     * @return bool
     */
    protected function EventBannerRedirect()
    {
        /** @var int $sBannerId Идентификатор баннера */
        $sBannerId = $this->GetParam(0);
        
        $oBanner = $this->PluginBanneroid_Banner_GetBannerById($sBannerId);
        if (!$oBanner) {
            return Router::Action('error');
        }
        
        $this->PluginBanneroid_Banner_AddBannerStats(array
        ('banner_id' => $oBanner->getBannerId(),
            'event' => 'CLICK',
        ));
        
        Router::Location($oBanner->getBannerUrl());
        
        return true;
    }
}