<?php
/*
 * Пример нового экшна. Задаем новые страницы (не забудьте сконфигурировать роутинг в config.php плагина)
 *
 */
class PluginVs_ActionRating extends ActionPlugin
{
    private $sPlugin = 'vs';
    /**
     * Инизиализация экшена
     *
     */
    public function Init()
    {
        $this->SetDefaultEvent('index'); // ПРи ображении к domain.com/somepage будет вызываться EventIndex()
        $this->oUserCurrent = $this->User_GetUserCurrent();
    }
    
    /**
     * Регистрируем евенты, по сути определяем УРЛы вида /somepage/.../
     *
     */
    protected function RegisterEvent()
    {
        //$this->AddEvent('index','EventIndex'); 
        $this->AddEventPreg('/^[\w\-\_]+$/i', 'EventIndex');
    }
    protected function EventIndex()
    {
        $first = "helloworld";
        //echo Router::GetActionEvent();
        //echo Router::GetParam(1);
        
        
        $this->SetTemplateAction('index');
		
		$oGameType = $this->PluginVs_Stat_GetGametypeByBrief($this->GetParam(0));
		$oGame     = $this->PluginVs_Stat_GetGameByBrief(Router::GetActionEvent());
		$rating_type = Router::GetParam(1);
		
		//$aGames     = $this->PluginVs_Stat_GetGameItemsAll();
		
		$games[] = 0;
		$sql=" select distinct game_id
				from tis_stat_rating  
				where gametype_id != 3
				 ";	
				
		if( $aResults=$this->PluginVs_Stat_GetAll($sql) ){	 
			foreach($aResults as $oResult){	 
				$games[]=$oResult['game_id'];
			} 			
		}
		$aGames     = $this->PluginVs_Stat_GetGameItemsByFilter(array(
			'game_id in' => $games 
			));
			
	
		if(!$oGame){
			$oGame = $aGames[0];
		}
			
		if($oGame){			
			$gametypes[] = 0;
			$sql=" select distinct gametype_id
					from tis_stat_rating  
					where game_id = ".$oGame->getGameId()."  ";	
					
			if( $aResults=$this->PluginVs_Stat_GetAll($sql) ){	 
				foreach($aResults as $oResult){	 
					$gametypes[]=$oResult['gametype_id'];
				} 			
			}
			$aGametypes     = $this->PluginVs_Stat_GetGametypeItemsByFilter(array(
				'gametype_id in' => $gametypes,
				'gametype_id !=' => '3'
				));
			$this->Viewer_Assign('aGametypes', $aGametypes);
		}
		$this->Viewer_Assign('aGames', $aGames);
		
		if(!$oGameType && isset($aGametypes) && $aGametypes){
			$oGameType = $aGametypes[0];
			$rating_type = "_rating";
		}
		$this->Viewer_Assign('oGametype', $oGameType);
		$this->Viewer_Assign('oGame', $oGame);
		
        if ($rating_type == "_rating" && isset($oGameType) && isset($oGame)) {
            
            //$this->Viewer_AddHtmlTitle($oBlog->getTitle());	
            $this->Viewer_AddHtmlTitle('Рейтинг');
            
            
            
            $aRating = $this->PluginVs_Stat_GetRatingItemsByFilter(array(
                'game_id' => $oGame->getGameId(),
                'gametype_id' => $oGameType->getGametypeId(),
                'user_id !=' => '0',
                '#with' => array(
                    'user'
                ),
                '#order' => array(
                    'rating' => 'desc'
                )
            ));
            $this->Viewer_Assign('aRating', $aRating);
            
            //$this->SetTemplate(Plugin::GetTemplatePath(__CLASS__).'actions/ActionVs/gametype_rating.tpl');
            
        } elseif ($rating_type == "_ofrating") {
            
            //$this->Viewer_AddHtmlTitle($oBlog->getTitle());	
            $this->Viewer_AddHtmlTitle('Официальный рейтинг');
            //$oGameType = $this->PluginVs_Stat_GetGametypeByBrief($this->GetParam(0));
           // $oGame     = $this->PluginVs_Stat_GetGameByBrief(Router::GetActionEvent());
            
            $aRating = $this->PluginVs_Stat_GetOfratingItemsByFilter(array(
                'game_id' => $oGame->getGameId(),
                'gametype_id' => $oGameType->getGametypeId(),
                '#with' => array(
                    'user'
                ),
                '#order' => array(
                    'ovrskillpoints' => 'desc'
                )
            ));
            $this->Viewer_Assign('aRating', $aRating);
            //$this->SetTemplateAction('gametype_ofrating');
            //$this->SetTemplate(Plugin::GetTemplatePath(__CLASS__).'actions/ActionVs/gametype_ofrating.tpl');
        }
        //$this->SetTemplate(Plugin::GetTemplatePath(__CLASS__).'actions/ActionVs/gametype_rating.tpl');
        
    }
}