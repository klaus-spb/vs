<?php

class PluginVs_WidgetFiltermyschedule extends Widget {
    public function Exec() {
		 
		if( $this->GetParam('oTournament') ){
			$oTournament=$this->GetParam('oTournament');
		}
		if( $this->GetParam('aFilter') ){
			$aFilter=$this->GetParam('aFilter');
		}
		// if($oTournament){		
			// $this->Viewer_Assign('oTournament',$oTournament);
		// }
		
		$sql ="SELECT distinct t.tournament_id

		FROM tis_stat_matches m 	
			inner join tis_stat_tournament t 
				on  m.tournament_id=t.tournament_id
			inner join tis_stat_teamsintournament tit_home 
				on m.home_teamtournament=tit_home.id	
			inner join tis_stat_teamsintournament tit_away 
				on m.away_teamtournament=tit_away.id	
		WHERE 1 = 1
				and ( tit_home.player_id = '".$this->User_GetUserCurrent()->getId()."'   or tit_away.player_id = '".$this->User_GetUserCurrent()->getId()."' ) 
				and m.played = 0  
				and 1=1 
				and (t.dateopenrasp='2000-01-01' or t.dateopenrasp >= m.dates) 
				and t.zavershen=0 ";
		$aTournaments = $this->PluginVs_Stat_GetAll($sql);
		$tournaments  = array();
		if ($aTournaments){
			foreach ($aTournaments as $oTournaments)
				$tournaments[] = $oTournaments['tournament_id'];
		} else {
			$tournaments[0] = 0;
		}		
				
		// $sql          = "select t.team_id 
					// from tis_stat_teamsintournament tt, tis_stat_team t 
					// where tt.tournament_id in (" . implode(",", $tournaments) . ") 
							// and tt.team_id=t.team_id 
					// order by t.name";
		// $aTeams_order = $this->PluginVs_Stat_GetAll($sql);
		// $teams_order  = array();
		// if ($aTeams_order){
			// foreach ($aTeams_order as $oTeam_order)
				// $teams_order[] = $oTeam_order['team_id'];
		// } else {
			// $teams_order[0] = 0;
		// }
		
		// $TeamsInTournament = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
			// 'tournament_id in' => $tournaments,
			// '#where' => array(
				// ' 1=1 order by FIELD(team_id,?a)' => array(
					// $teams_order
				// )
			// ),
			// '#with' => array(
				// 'team'
			// )
		// ));
		// foreach($TeamsInTournament as $oTeamsInTournament){	
					// $aTeamsInTournament[$oTeamsInTournament->getTeamId()]=$oTeamsInTournament;			
				// }
		// if($aTeamsInTournament)$this->Viewer_Assign('aTeamsInTournament', $aTeamsInTournament);
		
		$sql="select u.user_id as user_id, u.user_login as login
				from tis_stat_teamsintournament tt, tis_user u
				where tt.tournament_id in (" . implode(",", $tournaments) . ")
					and tt.player_id=u.user_id
				union
				select u.user_id as user_id, u.user_login as login
				from tis_stat_matches m, tis_user u
				where m.tournament_id in (" . implode(",", $tournaments) . ")
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
		
		$aTournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array(
			'tournament_id in' => $tournaments,
			'#order' =>array('brief'=>'asc')));
		$this->Viewer_Assign('aTournaments', $aTournaments);
	
			
    }
}
?>