<?php

class PluginVs_WidgetTournamentteamtable extends Widget {
    public function Exec() {
		 
		if( $this->GetParam('oTournament') ){
			$oTournament=$this->GetParam('oTournament');
		}
		if( $this->GetParam('num') ){
			$num=$this->GetParam('num');
		}else{
			$num = 16;
		}
		$this->Viewer_Assign('number',$num);
		if($oTournament){
			
			if($oTournament->getGame()->getSportId()==3){
				//Блок турнирной таблицы
				$TournamentTable = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
							'tournament_id' => $oTournament->getTournamentId(),	
							'round_id' => '0',
							'#with'         => array('team','teamtournament'),
							'#order' =>array('(home_w + away_w + home_wot + away_wot)'=>'desc','position'=>'asc'),
							'#limit' =>array('0',$num),
						));
			}else{
				//Блок турнирной таблицы
				$TournamentTable = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
							'tournament_id' => $oTournament->getTournamentId(),	
							'round_id' => '0',
							'#with'         => array('team','teamtournament'),
							'#order' =>array('position'=>'asc','points'=>'desc'),
							'#limit' =>array('0',$num),
						));
			}
			$this->Viewer_Assign('TournamentTable',$TournamentTable);
				
			$oGame= $this->PluginVs_Stat_GetGameByGameId($oTournament->getGameId());
			if($oGame && $oGame->getSportId()==4)
			{
				$PlayerTable = $this->PluginVs_Stat_GetPlayerstatItemsByFilter(array(
							'tournament_id' => $oTournament->getTournamentId(),	
							'round_id' => '0',
							'#with'         => array('team','user'),
							'#order' =>array('points'=>'desc'),
							'#limit' =>array('0',$num),
						));
					$this->Viewer_Assign('PlayerTable',$PlayerTable);
			}	
			$this->Viewer_Assign('oTournament',$oTournament);
			$this->Viewer_Assign('oGame',$oGame);
		}
		
    }
}
?>