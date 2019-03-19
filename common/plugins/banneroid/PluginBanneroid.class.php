<?php

if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

/**
 * Banneroid Plugin class for LiveStreet
 */
class PluginBanneroid extends Plugin
{
    /** @var array $aInherits Объявление переопределений (модули, мапперы и сущности) */
    protected $aInherits = array(
        'actions' => array(
            'ActionAdmin',
        ),
    
    );
    
    /**
     * Plugin Activation
     * Creating tables in DB if not exists
     * @return boolean
     */
    public function Activate()
    {
        // Export sql dump
        $this->ExportSQL(dirname(__FILE__) . '/activate.sql');
        // create image directory if it is not exists
        $sDir = Config::Get('path.root.server') . Config::Get('path.uploads.root') . '/banneroid/';
        if (!file_exists($sDir)) {
            @mkdir($sDir);
            @chmod($sDir, 0777);
        }
        E::ModuleCache()->Clean();
        return true;
    }
    
    /**
     * Plugin Initialization
     *
     * @return void
     */
    public function Init()
    {
        E::ModuleViewer()->AppendStyle(Plugin::GetTemplateDir(__CLASS__) . 'assets/css/style.css');
        E::ModuleViewer()->AppendScript(Plugin::GetTemplateDir(__CLASS__) . 'assets/js/script.js');
    }
    
    /**
     * Деактивация плагина
     *
     * @return boolean
     */
    public function Deactivate()
    {
        E::ModuleCache()->Clean();
        $resutls = $this->ExportSQL(dirname(__FILE__) . '/deactivate.sql');
        return $resutls['result'];
    }
}