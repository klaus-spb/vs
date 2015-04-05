<?php
/*
---------------------------------------------------------
*
*	Module "Vs"
*	Author: Lapenok Nikolai
*	Contact e-mail: reverty@gmail.com
*
---------------------------------------------------------
*/

class PluginVs_ActionVybory extends ActionPlugin
{
    /**
     * Главное меню
     */
    protected $sMenuHeadItemSelect = 'vybory';
    /**
     * Меню
     */
    protected $sMenuItemSelect = 'vybory';
    /**
     * Субменю
     */
    protected $sMenuSubItemSelect = 'all';
    /**
     * Текущий пользователь
     */
    protected $oUserCurrent = null;
    
    /**
     * Инициализация
     */
    public function Init()
	{
        $this->SetDefaultEvent('');
        $this->oUserCurrent = $this->User_GetUserCurrent();      
		
		$this->Viewer_AddHtmlTitle("Выборы");
    }
    
    /**
     * Регистрация событий
     */
    protected function RegisterEvent()
    {
        //$this->AddEventPreg('/^[\w\-\_]+$/i', '/^players$/', 'EventPlayers');
        $this->AddEventPreg('/^[\w\-\_]+$/i', 'EventVybory');
    }
	protected function EventVybory()
	{
	
	
	}
	
	
	
}