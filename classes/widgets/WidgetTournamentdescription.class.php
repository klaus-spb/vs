<?php

class PluginVs_WidgetTournamentdescription extends Widget {
    public function Exec() {
		 
		if( $this->GetParam('oTournament') ){
			$oTournament=$this->GetParam('oTournament');
		}	
		if($oTournament){
		 //Блок турнира		
			$this->Viewer_Assign('tournament',1);
			$aTournamentAdmins = $this->PluginVs_Stat_GetTournamentadminItemsByFilter(array(
				'tournament_id' => $oTournament->getTournamentId(),
				'status' => 'admin',
				'#with'         => array('user')				
			));		
			
			$this->Viewer_Assign('aTournamentAdmins',$aTournamentAdmins);
			$aTournamentAssists = $this->PluginVs_Stat_GetTournamentadminItemsByFilter(array(
				'tournament_id' => $oTournament->getTournamentId(),
				'status' => 'moderator',
				'#with'         => array('user')				
			));		
			$this->Viewer_Assign('aTournamentAssists',$aTournamentAssists);
			
			$sql="select count(*) as total, sum(played) as played from tis_stat_matches where tournament_id='".$oTournament->getTournamentId()."' and round_id<>100 group by tournament_id";
			$aMatches=Engine::GetInstance()->PluginVs_Stat_GetAll($sql);
			$matches_total=0;
			$matches_played=0;
			$matches_total=$aMatches[0]['total'];
			$matches_played=$aMatches[0]['played'];	 
			$this->Viewer_Assign('matches_total',$matches_total);
			$this->Viewer_Assign('matches_played',$matches_played);
			
			/*
			if($oTournament->getTournamentId()==75){
				$sql="select sum(ts.home_w + ts.away_w) as vs_wins,
				sum(ts.home_l + ts.away_l) as ks_wins,
				 gvs.name  as vs_name,
				 gks.name  as ks_name
				from tis_stat_tournamentstat ts

				left join tis_stat_group gvs
					on gvs.group_id = 26

				left join tis_stat_group gks
					on  gks.group_id = 27

				where ts.tournament_id = 75 
					and ts.group_id = 26
                                group by ts.tournament_id, gvs.name, gks.name";
				$aSeriyaStat=$this->PluginVs_Stat_GetAll($sql);
				$this->Viewer_Assign('aSeriyaStat',$aSeriyaStat[0]);
			}
			*/
			$this->Viewer_Assign('oTournament',$oTournament);
			
			$myteamintournament_id = $this->PluginVs_Stat_GetMyTeamtournament($oTournament);
			$this->Viewer_Assign('myteamintournament_id',$myteamintournament_id);
			
			if($this->User_GetUserCurrent() && $myteamintournament_id == 0 && $oTournament->getDatezayavki() >= date("Y-m-d")){
				if( $aZayvki = $this->PluginVs_Stat_GetZayavkiItemsByFilter(array(
					'tournament_id' => $oTournament->getTournamentId(),
					'user_id' => $this->User_GetUserCurrent()->getUserId(),
					'#with'         => array('team'),
					'#order' =>array('prioritet'=>'asc')
					))
				){
					$this->Viewer_Assign('aZayvki',$aZayvki);				
					
				}
				$sql="select distinct team_id from tis_stat_teamsintournament where player_id<>0 and team_id<>0 and tournament_id=".$oTournament->getTournamentId();
				$aZanTeams=$this->PluginVs_Stat_GetAll($sql);
				$this->Viewer_Assign('aZanTeams',$aZanTeams);
			}
			
			if($oTournament->getGametypeId()==8 && $this->User_GetUserCurrent()){
			
				if( $aEvent = $this->PluginVs_Stat_GetEventItemsByFilter(array(
					'tournament_id ' => $oTournament->getTournamentId(),
					'dates >=' =>date("Y-m-d"),
					'closed' => '0',
					'#order' =>array('dates'=>'asc')
					)) ){
						
						//$oTeamTournament = $this->PluginVs_Stat_GetTeamsintournamentByFilter(array('tournament_id' => $oTournament->getTournamentId(),'player_id' => $this->User_GetUserCurrent()->getUserId()));
						$teamintournament_id = $this->PluginVs_Stat_GetMyTeamtournament($oTournament);
						//echo $teamintournament_id;
						$oTeamTournament = $this->PluginVs_Stat_GetTeamsintournamentById($teamintournament_id);
						if( $oTeamTournament ){
							$aEvents = array();
							
							foreach ($aEvent as $oEvent){							
								if( !$oEventPlayer = $this->PluginVs_Stat_GetEventPlayerByFilter(array(
									'event_id ' => $oEvent->getEventId(),
									'teamintournament_id ' => $oTeamTournament->getId()
									)) ){
										$aEvents[]=$oEvent;
									}
							}
							 
							$this->Viewer_Assign('aEvents',$aEvents);
							$this->Viewer_Assign('oTeamTournament',$oTeamTournament);
						}
					
				}
			
			}
	//Блок турнира	
		}
    }
}
?>