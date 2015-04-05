<?php

class PluginVs_WidgetFilterschedule extends Widget {
    public function Exec() {
		 
		if( $this->GetParam('oTournament') ){
			$oTournament=$this->GetParam('oTournament');
		}
		if( $this->GetParam('aFilter') ){
			$aFilter=$this->GetParam('aFilter');
		}
		if($oTournament){		
			$this->Viewer_Assign('oTournament',$oTournament);
		}
		
		$sql          = "select t.team_id from tis_stat_teamsintournament tt, tis_stat_team t where tt.tournament_id='" . $oTournament->getTournamentId() . "' and tt.team_id=t.team_id order by t.name";
		$aTeams_order = $this->PluginVs_Stat_GetAll($sql);
		$teams_order  = array();
		if ($aTeams_order){
			foreach ($aTeams_order as $oTeam_order)
				$teams_order[] = $oTeam_order['team_id'];
		} else {
			$teams_order[0] = 0;
		}
		
		$TeamsInTournament = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
			'tournament_id' => $oTournament->getTournamentId(),
			'#where' => array(
				' 1=1 order by FIELD(team_id,?a)' => array(
					$teams_order
				)
			),
			'#with' => array(
				'team'
			)
		));
		foreach($TeamsInTournament as $oTeamsInTournament){	
					$aTeamsInTournament[$oTeamsInTournament->getTeamId()]=$oTeamsInTournament;			
				}
		if($aTeamsInTournament)$this->Viewer_Assign('aTeamsInTournament', $aTeamsInTournament);
		
		$sql="select u.user_id as user_id, u.user_login as login
				from tis_stat_teamsintournament tt, tis_user u
				where tt.tournament_id = '" . $oTournament->getTournamentId() . "'
					and tt.player_id=u.user_id
				union
				select u.user_id as user_id, u.user_login as login
				from tis_stat_matches m, tis_user u
				where m.tournament_id = '" . $oTournament->getTournamentId() . "'
					and (m.away_player=u.user_id or m.home_player=u.user_id)
				order by login";
				
		$aUsers_order = $this->PluginVs_Stat_GetAll($sql);
		$users_order  = array();
		if ($aUsers_order){
			foreach ($aUsers_order as $oUser_order)
				$users_order[] = $oUser_order['user_id'];
		} else {
			$users_order[0] = 0;
		}		
		
		$aUsers = $this->User_GetUsersByArrayId($users_order);
		
		
		if($aUsers)$this->Viewer_Assign('aUsers', $aUsers);
		
		
		
		
		if($aFilter)$this->Viewer_Assign('aFilter', $aFilter); 
		 
		$sql          = "select distinct tt.round_id from tis_stat_matches tt where tt.tournament_id='" . $oTournament->getTournamentId() . "' ";
		$aRounds_order = $this->PluginVs_Stat_GetAll($sql);
		$rounds  = array();
		$rounds[] = 0;
		$teams_order[0] =-1;
		if ($aRounds_order){
			foreach ($aRounds_order as $round)
				$rounds[] = $round['round_id'];
		}
		
		$sql          = "select distinct sp.round from tis_stat_playoff sp where sp.tournament_id='" . $oTournament->getTournamentId() . "' ";
		$rounds_po = $this->PluginVs_Stat_GetAll($sql);
		$this->Viewer_Assign('rounds_po', $rounds_po);
		
		$aRounds = $this->PluginVs_Stat_GetRoundItemsByFilter(array(
			'round_id in' => $rounds ));
		$this->Viewer_Assign('aRounds', $aRounds);
		
		$aEvents = $this->PluginVs_Stat_GetEventItemsByFilter(array(
					'tournament_id'=>$oTournament->getTournamentId(),
					'#order' =>array('id'=>'desc')
					));
		$this->Viewer_Assign('aEvents',$aEvents);
			
    }
}
?>