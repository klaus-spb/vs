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

class PluginVs_ActionTournaments extends ActionPlugin
{
    /**
     * ������� ����
     */
    protected $sMenuHeadItemSelect = 'tournaments';
    /**
     * ����
     */
    protected $sMenuItemSelect = 'tournaments';
    /**
     * �������
     */
    protected $sMenuSubItemSelect = 'all';
    /**
     * ������� ������������
     */
    protected $oUserCurrent = null;
    protected $oTournament = null;
    protected $oGame = null;
	protected $myTeam = 0;
	protected $isAdmin = null;
    
    /**
     * �������������
     */
    public function Init()
    {
		$this->SetDefaultEvent('EventAll');
        $this->oUserCurrent = $this->User_GetUserCurrent();
    }
	
	 /**
     * ����������� �������
     */
    protected function RegisterEvent()
    {
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^all$/', 'EventAll');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^[\w\-\_]+$/i', 'EventAll');
		$this->AddEventPreg('/^[\w\-\_]+$/i',  'EventAll');
    }
	public function EventAll()
    {
		$this->Viewer_AddHtmlTitle('Tournaments');
		$this->SetTemplateAction('all');		
		
		
	}
	public function EventShutdown()
    {
	
    }
}