<?php
/*
 * Пример нового экшна. Задаем новые страницы (не забудьте сконфигурировать роутинг в config.php плагина)
 *
 */

class PluginVs_ActionForums extends ActionPlugin {
    private $sPlugin = 'forums';
	
	protected $sMenuHeadItemSelect = 'tournament';
    /**
     * Меню
     */
    protected $sMenuItemSelect = 'tournament';
    /**
     * Субменю
     */
    protected $sMenuSubItemSelect = 'all';
	
	/**
	 * Инизиализация экшена
	 *
	 */
	public function Init() {
        $this->SetDefaultEvent('index'); // ПРи ображении к domain.com/somepage будет вызываться EventIndex()
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