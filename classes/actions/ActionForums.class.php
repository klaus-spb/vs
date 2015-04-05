<?php
/*
 * ������ ������ �����. ������ ����� �������� (�� �������� ���������������� ������� � config.php �������)
 *
 */

class PluginVs_ActionForums extends ActionPlugin {
    private $sPlugin = 'forums';
	
	protected $sMenuHeadItemSelect = 'tournament';
    /**
     * ����
     */
    protected $sMenuItemSelect = 'tournament';
    /**
     * �������
     */
    protected $sMenuSubItemSelect = 'all';
	
	/**
	 * ������������� ������
	 *
	 */
	public function Init() {
        $this->SetDefaultEvent('index'); // ��� ��������� � domain.com/somepage ����� ���������� EventIndex()
		$this->oUserCurrent = $this->User_GetUserCurrent();
	}

	protected function RegisterEvent() { 
		$this->AddEvent('index','EventIndex');  
	}

	protected function EventIndex() {
		$first="helloworld";
		$this->Viewer_AddHtmlTitle($this->Lang_Get('plugin.vs.forum'));
		$this->SetTemplateAction('index');	
		$this->Viewer_Assign('aForums',  $this->Blog_GetMenuBlogs() );
	}
	
}