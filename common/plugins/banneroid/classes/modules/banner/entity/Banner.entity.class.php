<?php

class PluginBanneroid_ModuleBanner_EntityBanner extends Entity
{
    /**
     * Return banner Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->_aData['banner_id'];
    }
    
    /**
     * Return banner name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_aData['banner_name'];
    }
    
    /**
     * Return current date
     *
     * @return string
     */
    public function getNowDate()
    {
        return date('Y-m-d');
    }
    
    /**
     * Return max available year for banner settings
     *
     * @return integer
     */
    public function getMaxYear()
    {
        return date('Y') + Config::Get('plugin.banneroid.max_year');
    }
    
    public function setBannerLang($data)
    {
        $this->_aData['banner_lang'] = $data;
    }
}