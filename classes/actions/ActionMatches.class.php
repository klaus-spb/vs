<?php
/*
 * Пример нового экшна. Задаем новые страницы (не забудьте сконфигурировать роутинг в config.php плагина)
 *
 */

class PluginVs_ActionMatches extends ActionPlugin {
 
	
	/**
	 * Инизиализация экшена
	 *
	 */
	public function Init() {
        $this->SetDefaultEvent('index'); // ПРи ображении к domain.com/somepage будет вызываться EventIndex()
		
		if (!$this->User_IsAuthorization()) {
            $this->Message_AddErrorSingle($this->Lang_Get('not_access'));
            return Router::Action('error');
        }
		
		$this->oUserCurrent = $this->User_GetUserCurrent();
		
	}
	
	protected function RegisterEvent() { 
		$this->AddEventPreg('/^[\w\-\_]+$/i','EventMatches');
	}
	
	protected function EventMatches() {
		$this->sMenuSubItemSelect = "shedule";
		$this->Viewer_AddHtmlTitle('Shedule');
		
		$aFilter = array();
		
		if(isset($_GET['f'])){		
			
			if(isset($_GET['tournaments'])){ 
				foreach ($_GET['tournaments'] as $selectedTournament){
					$aFilter['tournaments'][] =  intval($selectedTournament);
				}
			}
			
			if(isset($_GET['players'])){ 
				foreach ($_GET['players'] as $selectedPlayer){
					$aFilter['players'][] =  intval($selectedPlayer);
				}
			}
			
			
			if(isset($_GET['dates'])){
				$_GET['dates'] = strip_tags($_GET['dates']);
				if( strlen($_GET['dates'])==23 ){
					$aFilter['date_start'] = substr($_GET['dates'], 0,10);
					$aFilter['date_end'] = substr($_GET['dates'], 13,10);
					
					$aFilter['dates'] = $_GET['dates'];
				}
			}
			
			if(isset($_GET['not_played'])){
				$aFilter['not_played'] = 1;
			}
			if(isset($_GET['round'])){
				$aFilter['round_id'] = $_GET['round'];
			}
			if(isset($_GET['event'])){
				$aFilter['event_id'] = $_GET['event'];
			}
		}
		
		// if(!isset($_GET['f']) && $this->myTeam != 0 && $this->oTournament->getGametypeId()!= 8 ){
			// $aFilter['teams'][] = $this->myTeam;
		$aFilter['not_played'] = 1;
		$aFilter['can_insert'] = 1;			
		// }
		$aFilter['month'] =0;
		// $aFilter['my_team_id'] = $this->myTeam;
		// $aFilter['my_teamintournament_id'] = $this->myTeamTournament;
		// $aFilter['tournament_id'] = $this->oTournament->getTournamentId();
			
		$aFilter['user_id'] = $this->oUserCurrent->getId();
		$aFilter['player_id'] = $this->oUserCurrent->getId();
		
		$aFilter['with_tournament_logo'] = 1;
		
		// if(!isset($_GET['f']) ){
			
			// $month_start = strtotime('first day of this month', time());
			// $month_end = strtotime('last day of this month', time());
			// $week_start = strtotime('last Sunday', time());
			// $week_end = strtotime('next Sunday', time()+ (7 * 24 * 60 * 60));
			
			// $aFilter['date_start'] = date('Y-m-d', $week_start);
			// $aFilter['date_end'] = date('Y-m-d', $week_end);
			// $aFilter['dates'] = $aFilter['date_start'].' - '.$aFilter['date_end'];
		// }
		
		$this->Viewer_AddWidget('right','filtermyschedule',array('plugin'=>'vs',  'aFilter'=>$aFilter),205);	
		
		$this->SetTemplateAction('matches');
			
		
		$oMatches=$this->PluginVs_Stat_MatchesSQLNew($aFilter);
			
		

		$oViewer=$this->Viewer_GetLocalViewer();
		$admin='yes';
		// if ($this->isAdmin) {$admin='yes';}
		// if($this->oUserCurrent && $this->oUserCurrent->isAdministrator())$admin='yes';
		$oViewer->Assign('admin',$admin);
		
		$oViewer->Assign('oMatches',$oMatches);
		// $oViewer->Assign('isAdmin',$this->isAdmin);
		$oViewer->Assign('currentweek',date('W', time()));
		$oViewer->Assign('month',$aFilter['month']);
		// $oViewer->Assign('myteam',$this->myTeam);
		// if(isset($this->myTeam) && $this->myTeam!=0){
			// $oTeam=$this->PluginVs_Stat_GetTeamByTeamId($this->myTeam);
			// $this->Viewer_Assign('oTeam',$oTeam);
		// }
		// $oViewer->Assign('tournament_id',$this->oTournament->getTournamentId());
		// $oViewer->Assign('oGame',$this->oGame);
		$sTextResult=$oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__)."actions/ActionTournament/shedule.tpl");
		$this->Viewer_Assign('sRaspisanie',$sTextResult);
	
	}
	
}