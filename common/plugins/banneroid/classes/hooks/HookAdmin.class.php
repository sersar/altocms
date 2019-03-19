<?php

class PluginBanneroid_HookAdmin extends Hook
{
    /**
     * Регистрация хуков
     *
     * @return void
     */
    public function RegisterHook()
    {
        $this->AddHook('template_admin_menu_content', 'AdminMenuInject', __CLASS__);
        
    }
    
    /**
     * Доабвление ссылки в меню админки
     *
     * @return string
     */
    public function AdminMenuInject()
    {
        if (E::IsAdmin()) {
            return E::ModuleViewer()->Fetch(Plugin::GetTemplatePath(__CLASS__) . 'tpls/menu.banneroid.tpl');
        }
    }
}