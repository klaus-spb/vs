<?php
class PluginVs_ModuleStat extends ModuleORM {
	public $oMapper=null;
	public function Init() {
		parent::Init();
		$this->oMapper=Engine::GetMapper(__CLASS__,'Stat');
		$this->oUserCurrent=$this->User_GetUserCurrent();
	}
	
	public function IsTournamentAdmin($oTournament) {
		$admin = false;
		if($this->oUserCurrent){
			$sKey="user_".$this->oUserCurrent->GetUserId()."_tournament_admin_".$oTournament->getTournamentId();
			
			if (false === ($myTeam = $this->Cache_Get($sKey))) {
				$admin = false;
				if ($this->User_IsAuthorization()) {
					$aAdmin = $this->PluginVs_Stat_GetTournamentadminItemsByFilter(array(
						'tournament_id' => $oTournament->getTournamentId(),
						'user_id'	=> $this->oUserCurrent->GetUserId(),
						'#page' 	=> 'count',
						'expire >=' => date("Y-m-d")
					));
					if($aAdmin['count']>0)$admin = true; 
				}
			}
		}
		return $admin;
		
	}
	public function GetMyTournaments() {
		$myTournaments = array();
		if($this->oUserCurrent){
			$sKey="user_".$this->oUserCurrent->GetUserId()."_tournaments";
			
			if (false === ($myTournaments = $this->Cache_Get($sKey))) {
				$myTournaments[] = 0;
				
				$sql="SELECT t.tournament_id
				FROM tis_stat_teamsintournament tt, tis_stat_tournament t
				WHERE tt.player_id =  '".$this->oUserCurrent->GetUserId()."'
					AND t.zavershen =  '0'
					AND t.tournament_id = tt.tournament_id
					AND t.site='".Config::Get('sys.site')."'
				union
				SELECT t.tournament_id
				FROM tis_stat_playertournament pt, tis_stat_tournament t
				WHERE pt.user_id =  '".$this->oUserCurrent->GetUserId()."'
					AND pt.team_id <> 0
					AND t.zavershen =  '0'
					AND t.tournament_id = pt.tournament_id
					AND t.site='".Config::Get('sys.site')."'
				union
				SELECT t.tournament_id
				FROM tis_stat_tournamentadmin ta, tis_stat_tournament t
				WHERE ta.user_id =  '".$this->oUserCurrent->GetUserId()."'
					AND t.zavershen =  '0'
					AND t.tournament_id = ta.tournament_id
					AND t.site='".Config::Get('sys.site')."' ";
				$aTournaments = Engine::GetInstance()->PluginVs_Stat_GetAll($sql);
				
				if($aTournaments){
					foreach($aTournaments as $oTournament){
						$myTournaments[]=$oTournament['tournament_id'];
					}
				}
				$this->Cache_Set($myTournaments, $sKey, array("PluginVs_ModuleStat_EntityTeamsintournament_save","PluginVs_ModuleStat_EntityPlayertournament_save"), 60*60*24*1);
			}		
		}else{
			$myTournaments[] = '0';
		}
        return $myTournaments;
    }
	
	public function GetMyTeam($oTournament) {
		$myTeam = 0;
		if($this->oUserCurrent){
			$sKey="user_".$this->oUserCurrent->GetUserId()."_tournament_".$oTournament->getTournamentId();
			
			if (false === ($myTeam = $this->Cache_Get($sKey))) {
				$myTeam = 0;
				if ($this->User_IsAuthorization()) {
					$aTeam = $this->PluginVs_Stat_GetTeamsintournamentByFilter(array(
						'tournament_id' => $oTournament->getTournamentId(),
						'player_id' => $this->oUserCurrent->GetUserId()		
					));		
					if($aTeam){$myTeam=$aTeam->getTeamId();}		
				}
				if($myTeam==0 && $oTournament->getGametypeId()==3 && $this->User_IsAuthorization()){
					if($aTeam = $this->PluginVs_Stat_GetPlayertournamentByFilter(array(
						'tournament_id' => $oTournament->getTournamentId(),
						'user_id' => $this->oUserCurrent->GetUserId()		
					 ))	){
						if($aTeam = $this->PluginVs_Stat_GetTeamsintournamentByFilter(array(
							'tournament_id' => $oTournament->getTournamentId(),
							'team_id' => $aTeam->getTeamId()		
						)) ){
							$myTeam=$aTeam->getTeamId();
						}
					}
				}
				$this->Cache_Set($myTeam, $sKey, array("PluginVs_ModuleStat_EntityTeamsintournament_save","PluginVs_ModuleStat_EntityPlayertournament_save"), 60*60*24*1);
			}		
		}
        return $myTeam;
    }

	public function GetMyTeamtournament($oTournament) {
		$myTeamtournament = 0;
		if($this->oUserCurrent){
			$sKey="user_".$this->oUserCurrent->GetUserId()."_teamtournament_".$oTournament->getTournamentId();
			
			if (false === ($myTeamtournament = $this->Cache_Get($sKey))) {
				$myTeamtournament = 0;
				if ($this->User_IsAuthorization()) {
					$aTeam = $this->PluginVs_Stat_GetTeamsintournamentByFilter(array(
						'tournament_id' => $oTournament->getTournamentId(),
						'player_id' => $this->oUserCurrent->GetUserId()		
					));		
					if($aTeam){$myTeamtournament=$aTeam->getId();}		
				}
				if($myTeamtournament==0 && $oTournament->getGametypeId()==3 && $this->User_IsAuthorization()){
					if($aTeam = $this->PluginVs_Stat_GetPlayertournamentByFilter(array(
						'tournament_id' => $oTournament->getTournamentId(),
						'user_id' => $this->oUserCurrent->GetUserId()		
					 ))	){
						if($aTeam = $this->PluginVs_Stat_GetTeamsintournamentByFilter(array(
							'tournament_id' => $oTournament->getTournamentId(),
							'team_id' => $aTeam->getTeamId()		
						)) ){
							$myTeamtournament=$aTeam->getId();
						}
					}
				}
				$this->Cache_Set($myTeamtournament, $sKey, array("PluginVs_ModuleStat_EntityTeamsintournament_save","PluginVs_ModuleStat_EntityPlayertournament_save"), 60*60*24*1);
			}		
		}
        return $myTeamtournament;
    }
	
	public function GetMyMatches($user_id) {
        return $this->oMapper->GetMyMatches($user_id);
    }
	
	public function GetAll($sql) {
        return $this->oMapper->GetAll($sql);
    }
	public function CreateBlog($sql) {
        return $this->oMapper->CreateBlog($sql);
    }
	public function DelZayavki($user,$tournament) {
        return $this->oMapper->DelZayavki($user,$tournament);
    }
	public function InsertZayavki($user, $tournament, $number, $prior ) {
        return $this->oMapper->InsertZayavki($user, $tournament, $number, $prior );
    }
	public function CheckZayavkaTime($user,$tournament) {
        return $this->oMapper->CheckZayavkaTime($user,$tournament);
    }
	public function PlayerRatings($user_id,$game_id,$gametype_id) {
        return $this->oMapper->PlayerRatings($user_id,$game_id,$gametype_id);
    }
	public function PlayerStats($aFilter) {
	
		$sKey="player_stat_".serialize($aFilter);
		if (false === ($data = $this->Cache_Get($sKey))) {
			$data = $this->oMapper->PlayerStats($aFilter);
			$this->Cache_Set($data, $sKey, array("PluginVs_ModuleStat_EntityMatchplayerstat_save","PluginVs_ModuleStat_EntityMatchplayerstat_add"), 60*60*2);
		}
		return $data;
		
		
        //return $this->oMapper->PlayerStats($aFilter);
    }
	public function SituationStats($aFilter) {
        return $this->oMapper->SituationStats($aFilter);
    }
	public function MatchesSQL($aFilter) {
        return $this->oMapper->MatchesSQL($aFilter);
    }
	public function MatchesSQLNew($aFilter) {
        return $this->oMapper->MatchesSQLNew($aFilter);
    }
	public function CheckSetZayavkaTime($user,$tournament,$psnid) {
        return $this->oMapper->CheckSetZayavkaTime($user,$tournament,$psnid);
    }
	public function InsertZayavkaTime($user,$tournament) {
        return $this->oMapper->InsertZayavkaTime($user,$tournament);
    }
	public function Zayavok($tournament) {
        return $this->oMapper->Zayavok($tournament);
    }
	public function TeamZayavki($tournament) {
        return $this->oMapper->TeamZayavki($tournament);
    }
	public function TeamZayavok($tournament) {
        return $this->oMapper->TeamZayavok($tournament);
    }
	
	public function GetPlayerByFilter($aFilter,$aOrder,$iCurrPage,$iPerPage,$aAllowData=null) {
		$sKey="user_filter_".serialize($aFilter).serialize($aOrder)."_{$iCurrPage}_{$iPerPage}";
		if (false === ($data = $this->Cache_Get($sKey))) {
			$data = array('collection'=>$this->oMapper->GetPlayerByFilter($aFilter,$aOrder,$iCount,$iCurrPage,$iPerPage),'count'=>$iCount);
			$this->Cache_Set($data, $sKey, array("user_update","user_new"), 60*60*24*2);
		}
		$data['collection']=$this->GetUsersAdditionalData($data['collection'],$aAllowData);
		return $data;
	}
	
	public function GetMatchesAdditionalData($aTopicId,$aAllowData=array('user'=>array(),'blog'=>array('owner'=>array(),'relation_user'),'vote','favourite','comment_new')) {
		 //print_r( $aMatchId);
		 
		$aTopicId=array_unique($aTopicId);
		$aTopics=array();
		$aTopicIdNotNeedQuery=array();
		/**
		 * Делаем мульти-запрос к кешу
		 */
		$aCacheKeys=func_build_cache_keys($aTopicId,'matches_');
		//print_r($aCacheKeys);
		if (false !== ($data = $this->Cache_Get($aCacheKeys))) {			
			/**
			 * проверяем что досталось из кеша
			 */ 
			 /*
			foreach ($aCacheKeys as $sValue => $sKey ) {
				if (array_key_exists($sKey,$data)) {	
					if ($data[$sKey]) {
						$aTopics[$data[$sKey]->getMatchId()]=$data[$sKey];
					} else {
						$aTopicIdNotNeedQuery[]=$sValue;
					}
				} 
			}
			*/
		}
		/**
		 * Смотрим каких топиков не было в кеше и делаем запрос в БД
		 */		
		$aTopicIdNeedQuery=array_diff($aTopicId,array_keys($aTopics));		
		$aTopicIdNeedQuery=array_diff($aTopicIdNeedQuery,$aTopicIdNotNeedQuery);
 		
		$aTopicIdNeedStore=$aTopicIdNeedQuery; 
		 
		if($aTopicIdNeedQuery)
		if ($data = $this->PluginVs_Stat_GetMatchesItemsByFilter(array(
				'match_id in ' => $aTopicIdNeedQuery,	
				'#with'         => array('hometeam','awayteam','tournament')
			))
			
			/* $this->oMapperTopic->GetTopicsByArrayId($aTopicIdNeedQuery)*/) {
			foreach ($data as $oMatch) {
			
				/*$oTournament=$this->PluginVs_Stat_GetTournamentByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),	
					'#with'         => array('blog')
				));
				$oMatch->setBlog($oTournament->getBlog());
				*/
				/**
				 * Добавляем к результату и сохраняем в кеш
				 */
				$aTopics[$oMatch->getMatchId()]=$oMatch;
				$this->Cache_Set($oMatch, "matches_{$oMatch->getMatchId()}", array(), 60*60*24*4);
				$aTopicIdNeedStore=array_diff($aTopicIdNeedStore,array($oMatch->getMatchId()));
			}
		}
		/**
		 * Сохраняем в кеш запросы не вернувшие результата
		 */
		 
	 	foreach ($aTopicIdNeedStore as $sId) {
			$this->Cache_Set(null, "matches_{$sId}", array(), 60*60*24*4);
		}	 
/*		
		$aTopics=func_array_sort_by_keys($aTopics,$aTopicId);
		return $aTopics;
		
		
		//--------------------------------------------//
		$aMatch=$this->PluginVs_Stat_GetMatchesItemsByFilter(array(
				'match_id in ' => $aMatchId,	
				'#with'         => array('hometeam','awayteam','tournament')
			));
		foreach ($aMatch as $oMatch) { 
			$oTournament=$this->PluginVs_Stat_GetTournamentByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),	
				'#with'         => array('blog')
			));
			$oMatch->setBlog($oTournament->getBlog());
			
			$aMatches[$oMatch->getMatchId()]=$oMatch;
			

			
			 $this->Cache_Set($oMatch, "match_{$oMatch->getMatchId()}", array(), 60*60*24*4);
			 $aTopicIdNeedStore=array_diff($aTopicIdNeedStore,array($oMatch->getMatchId()));
		}
			
		$aMatches=func_array_sort_by_keys($aMatches,$aMatchId); 
		return $aMatches;	*/
		$aTopics=func_array_sort_by_keys($aTopics,$aTopicId);
		return $aTopics;	
	}
	public function GetTopicsByPlatform($iPage,$iPerPage,$platform,$bAddAccessible=false) {
		$aFilter=array(
			'blog_type' => array(
				'personal',
				'open'
			),
			'platform' => $platform,
			'topic_publish' => 1,
                        'order' => 't.topic_date_add desc'

		);

		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}

		return $this->Topic_GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}
	public function GetTopicsByGame($iPage,$iPerPage,$game,$bAddAccessible=false) {
		$aFilter=array(
			'blog_type' => array(
				'personal',
				'open'
			),
			//'platform' => $platform,
			'game' => $game,
			'topic_publish' => 1,
                        'order' => 't.topic_date_add desc'

		);

		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}

		return $this->Topic_GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}
	public function GetTopicsByGametype($iPage,$iPerPage,$platform,$game,$gametype,$bAddAccessible=false) {
		$aFilter=array(
			'blog_type' => array(
				'personal',
				'open'
			),
			'platform' => $platform,
			'game' => $game,
			'gametype' => $gametype,
			'topic_publish' => 1,
                        'order' => 't.topic_date_add desc'

		);

		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}

		return $this->Topic_GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}
	public function GetTopicsByTournament($iPage,$iPerPage,$tournament_id,$bAddAccessible=false) {
		$aFilter=array(
	
			'tournament_id' => $tournament_id,
			'topic_publish' => 1,
                        'order' => array('t.topic_sticky desc','t.topic_date_add desc')

		);

		if($this->oUserCurrent && $bAddAccessible) {
			$aOpenBlogs = $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent);
			if(count($aOpenBlogs)) $aFilter['blog_type']['close'] = $aOpenBlogs;
		}

		return $this->Topic_GetTopicsByFilter($aFilter,$iPage,$iPerPage);
	}
	
	public function MonthMatches($tournament_id,$team_id, $month) {
		return $this->oMapper->MonthMatches($tournament_id,$team_id, $month);
	}
	public function PlayoffTree($tournament_id) {
		return $this->oMapper->PlayoffTree($tournament_id);
	}
	public function PlayoffTreePairs($tournament_id) {
		return $this->oMapper->PlayoffTreePairs($tournament_id);
	}
	public function PlayoffTreeWithMatches($tournament_id) {
		return $this->oMapper->PlayoffTreeWithMatches($tournament_id);
	}
	
	public function StreamReadMainPage($iCount=null,$iFromId=null, $tournament_id=null, $userId=null,$gameId=null, $only_matches=0, $blogId=null) {
		$aEventTypes = array(
			'match_played' => array('related' => 'matches') 
		);	
		if(!$only_matches!=1){
			$aEventTypes['teh_penalty']=array('related' => 'penalty');
		} 
		if(is_null($iCount))$iCount=20;
		if(is_null($iFromId))$iFromId=0;
		if(is_null($tournament_id))$tournament_id=0;
		if(is_null($userId))$userId=0;
		if(is_null($gameId))$gameId=0;
		if(is_null($blogId))$blogId=0;
		
		$sql="SELECT 
    st.id as id,
    at.name as away_name,
    at.logo as away_logo,
    ht.name as home_name,
    ht.logo as home_logo,
    t.name as tournament_name,
    t.url as tournament_url,
    u_home.user_login as home_player,
    u_away.user_login as away_player,
    ifnull(u_home.user_profile_avatar,
            'http://virtualsports.ru/templates/skin/btch/images/avatar_male_100x100.png') as home_user_profile_avatar,
    ifnull(u_away.user_profile_avatar,
            'http://virtualsports.ru/templates/skin/btch/images/avatar_male_100x100.png') as away_user_profile_avatar
FROM
    `tis_stat_stream` st
        inner join
    `tis_stat_matches` m ON (m.blog_id = (".$blogId.") or 0 = (".$blogId.") )
        and st.what_id = m.match_id
        and (m.tournament_id = (".$tournament_id.") or 0 = (".$tournament_id.") )
        inner join
    tis_stat_tournament t ON m.tournament_id = t.tournament_id
        left join
    tis_stat_team ht ON m.home = ht.team_id
        left join
    tis_stat_team at ON m.away = at.team_id
        inner join
    tis_stat_teamsintournament tit_home ON m.home_teamtournament = tit_home.id
        left join
    tis_user u_home ON u_home.user_id = tit_home.player_id
        inner join
    tis_stat_teamsintournament tit_away ON m.away_teamtournament = tit_away.id
        left join
    tis_user u_away ON u_away.user_id = tit_away.player_id
where
    st.event_type = 'match_played'
order by st.id desc
limit 0,".$iCount;

		$aTemp=Engine::GetInstance()->PluginVs_Stat_GetAll($sql);
		$events=array();
		$events[0]=0;
		if($aTemp)
		foreach($aTemp as $oTemp){
			$events[$oTemp['id']]=$oTemp['id'];
		}
		
		$aEvents=$this->PluginVs_Stat_GetStreamItemsByFilter(array( 
				'id in' => $events,
				'#order' =>array('date_add'=>'desc'),
				'#limit' =>array('0',$iCount)
			));
		$aNeedObjects=array();
		
		$teams=array();
		if($aTemp)
		foreach($aTemp as $oTemp){
		 
			$teams[$oTemp['id']]['away_player']=$oTemp['away_player'];			
			$teams[$oTemp['id']]['away_user_profile_avatar']=$oTemp['away_user_profile_avatar'];
			$teams[$oTemp['id']]['home_player']=$oTemp['home_player'];
			$teams[$oTemp['id']]['home_user_profile_avatar']=$oTemp['home_user_profile_avatar'];
			
			$teams[$oTemp['id']]['away_name']=$oTemp['away_name'];
			$teams[$oTemp['id']]['home_name']=$oTemp['home_name'];
			$teams[$oTemp['id']]['away_logo']=$oTemp['away_logo'];
			$teams[$oTemp['id']]['home_logo']=$oTemp['home_logo'];
			$teams[$oTemp['id']]['tournament_name']=$oTemp['tournament_name'];
			$teams[$oTemp['id']]['tournament_url']=$oTemp['tournament_url'];
		}
		
		foreach ($aEvents as $oEvent) {
			if (isset($aEventTypes[$oEvent->getEventType()]['related'])) {
				$aNeedObjects[$aEventTypes[$oEvent->getEventType()]['related']][]=$oEvent->getWhatId();				
			}
			$oEvent->setAwayName($teams[$oEvent->getId()]['away_name']);
			$oEvent->setHomeName($teams[$oEvent->getId()]['home_name']);
			$oEvent->setAwayUserProfileAvatar($teams[$oEvent->getId()]['away_user_profile_avatar']);
			$oEvent->setHomeUserProfileAvatar($teams[$oEvent->getId()]['home_user_profile_avatar']);
			
			$oEvent->setAwayPlayer($teams[$oEvent->getId()]['away_player']);
			$oEvent->setHomePlayer($teams[$oEvent->getId()]['home_player']);
			$oEvent->setAwayLogo($teams[$oEvent->getId()]['away_logo']);
			$oEvent->setHomeLogo($teams[$oEvent->getId()]['home_logo']);
			
			
			$oEvent->setTournamentName($teams[$oEvent->getId()]['tournament_name']);
			$oEvent->setTournamentUrl($teams[$oEvent->getId()]['tournament_url']);
		}
		
		$aObjects=array();
		foreach ($aNeedObjects as $sType => $aListId) {
			if (count($aListId)) {
				$aListId=array_unique($aListId);
				if($sType=='matches'){
					if ($aRes=$this->PluginVs_Stat_GetMatchesItemsByFilter(array(
						'match_id in' => $aListId,	
						'#with'         => array( 'blog')
						))
						) {
						foreach ($aRes as $oObject) {
							$aObjects[$sType][$oObject->getMatchId()]=$oObject; 
						}
						//PluginFirephp::GetLog(count($aRes));
					}
				}
			}
		}
		foreach ($aEvents as $key => $oEvent) {
				if (isset($aEventTypes[$oEvent->getEventType()]['related'])) {
					$sTypeObject=$aEventTypes[$oEvent->getEventType()]['related'];
					if (isset($aObjects[$sTypeObject][$oEvent->getWhatId()])) {
						$oEvent->setWhat($aObjects[$sTypeObject][$oEvent->getWhatId()]);
					} else {
						unset($aEvents[$key]);
					}
				} else {
					unset($aEvents[$key]);
				}

		}		
		return $aEvents;
	}
	public function StreamRead($iCount=null,$iFromId=null, $tournament_id=null, $userId=null,$gameId=null, $only_matches=0) {
		
		$aEventTypes = array(
			'match_played' => array('related' => 'matches') 
		);	
		if(!$only_matches!=1){
			$aEventTypes['teh_penalty']=array('related' => 'penalty');
		} 
		if(is_null($iCount))$iCount=20;
		if(is_null($iFromId))$iFromId=0;
		if(is_null($tournament_id))$tournament_id=0;
		if(is_null($userId))$userId=0;
		if(is_null($gameId))$gameId=0;
		
		if($userId>0){		
			$sql="SELECT st.id as id FROM `tis_stat_stream` st , `tis_stat_matches` m
			where (m.home_player=".$userId." or m.away_player=".$userId.")
				and (m.tournament_id = (".$tournament_id.") or 0 = (".$tournament_id.") )
				and (m.game_id = (".$gameId.") or 0 = (".$gameId.") )
				and st.event_type='match_played'
				and st.what_id=m.match_id
			order by st.id desc
			limit 0,".$iCount;

			$aTemp=Engine::GetInstance()->PluginVs_Stat_GetAll($sql);
			$events=array();
			$events[0]=0;
			if($aTemp)
			foreach($aTemp as $oTemp){
				$events[]=$oTemp['id'];
			}
			
			$aEvents=$this->PluginVs_Stat_GetStreamItemsByFilter(array( 
					'id in' => $events,
					'#order' =>array('date_add'=>'desc'),
					'#limit' =>array('0',$iCount)
				));
		}else{		
			$aEvents=$this->PluginVs_Stat_GetStreamItemsByFilter(array( 
					'#where' => array('(id < (?d) or 0 = (?d) ) and (tournament_id = (?d) or 0 = (?d) ) and ( (event_type = "match_played" and 1 = (?d)) or  0 = (?d) )' => array($iFromId, $iFromId, $tournament_id, $tournament_id,  $only_matches,  $only_matches)),				
					'#order' =>array('date_add'=>'desc'),
					'#limit' =>array('0',$iCount)
				));  
		}		
		$aNeedObjects=array();
		foreach ($aEvents as $oEvent) {
			if (isset($aEventTypes[$oEvent->getEventType()]['related'])) {
				$aNeedObjects[$aEventTypes[$oEvent->getEventType()]['related']][]=$oEvent->getWhatId();
//echo $oEvent->getWhatId();				
			}
			//$aNeedObjects['user'][]=$oEvent->getUserId();
		}
		
		$aObjects=array();
		foreach ($aNeedObjects as $sType => $aListId) {
			if (count($aListId)) {
				$aListId=array_unique($aListId);
				$sMethod = 'loadRelated' . ucfirst($sType);
				//echo $sType;
				if($sType=='matches'){
					if ($aRes=$this->PluginVs_Stat_GetMatchesItemsByFilter(array(
						'match_id in' => $aListId,	
						'#with'         => array('hometeam','awayteam','homeuser','awayuser', 'tournament')
						))
						) {
						foreach ($aRes as $oObject) {
							$aObjects[$sType][$oObject->getMatchId()]=$oObject;
							//echo $oObject->getMatchId();
						}
					}
				}elseif($sType=='penalty'){
					if ($aRes=$this->PluginVs_Stat_GetPenaltyItemsByFilter(array(
						'id in' => $aListId,	
						'#with'         => array('player','match')
						))
						) {
						foreach ($aRes as $oObject) {
							$aObjects[$sType][$oObject->getId()]=$oObject;
							//echo $oObject->getMatchId();
						}
					}

				}elseif (method_exists($this, $sMethod)) {
					if ($aRes=$this->$sMethod($aListId)) {
						foreach ($aRes as $oObject) {
							$aObjects[$sType][$oObject->getId()]=$oObject;
						}
					}
				}
			}
		}
		//print_r($aNeedObjects['matches']);
		
		foreach ($aEvents as $key => $oEvent) {
			/**
			 * Жестко вытаскиваем автора события
			 */
			 

				if (isset($aEventTypes[$oEvent->getEventType()]['related'])) {
					$sTypeObject=$aEventTypes[$oEvent->getEventType()]['related'];
					if (isset($aObjects[$sTypeObject][$oEvent->getWhatId()])) {
						$oEvent->setWhat($aObjects[$sTypeObject][$oEvent->getWhatId()]);
						//echo $oEvent->getWhat()->getMatchId();
					} else {
						unset($aEvents[$key]);
					}
				} else {
					unset($aEvents[$key]);
				}

		}
		
		return $aEvents;
	}
	public function loadRelatedUser($aIds) {
		return $this->User_GetUsersAdditionalData($aIds);
	}

//внесение результатов	
	public function AutoSubmit() {
		//echo 'alloha';
		//$this->Viewer_SetResponseAjax('json',true,false);
		//$this->Viewer_AssignAjax('message','');
		$sql="SELECT mr.id  
			FROM `tis_stat_matchresult`mr,
				`tis_stat_matches`m,
				`tis_stat_tournament` t				
			where mr.match_id=m.match_id 
				and m.tournament_id = t.tournament_id
				and t.autosubmit=1
				and not exists (select 1 from `tis_stat_matchresult` where match_id=mr.match_id and mr.id<>id)
				and date_add(mr.dates, INTERVAL t.submithours HOUR)<now()
				";
		$aMatches=$this->PluginVs_Stat_GetAll($sql);
		if($aMatches){
		
			foreach($aMatches as $aMatch){		
				$oMatchResult=$this->PluginVs_Stat_GetMatchresultById($aMatch['id']);
				$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($oMatchResult->getMatchId());
				
				$user_id=0;
				$team_id=0;
				if($oMatchResult->getTeamId()==$oMatch->getHome()){$team_id=$oMatch->getAway();}else{$team_id=$oMatch->getHome();}
				if($oMatchResult->getTeamintournamentId()==$oMatch->getHomeTeamtournament()){$teamintournament_id=$oMatch->getAwayTeamtournament();}else{$teamintournament_id=$oMatch->getHomeTeamtournament();}
				
				if( $oTeamintournament = $this->PluginVs_Stat_GetTeamsintournamentByFilter(array(
							'id' => $teamintournament_id, 
							'tournament_id' => $oMatch->getTournamentId()			
							))
				)$user_id=$oTeamintournament->getPlayerId();
				if( /*$user_id!=0 || */$teamintournament_id!=0){	
					$oMatchResult_add =  Engine::GetEntity('PluginVs_Stat_Matchresult');
					$oMatchResult_add->setMatchId($oMatchResult->getMatchId());
					$oMatchResult_add->setUserId($user_id);
					$oMatchResult_add->setTeamId($team_id);
					$oMatchResult_add->setTeamintournamentId($teamintournament_id);					
					$oMatchResult_add->setAway($oMatchResult->getAway());
					$oMatchResult_add->setHome($oMatchResult->getHome());
					$oMatchResult_add->setComment('подтверждено автоматом');
					$oMatchResult_add->setDates(date("Y-m-d H:i:s"));
					$oMatchResult_add->setOt($oMatchResult->getOt());
					$oMatchResult_add->setSo($oMatchResult->getSo());
					//if(isset($zhaloba))$oMatchResult_add->setHome($zhaloba);
					$oMatchResult_add->Add();
					
					//$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($oMatchResult->getMatchId());
					if($oMatch->getHomeTeamtournament()==$teamintournament_id){
						$oMatch->setHomeInsert(1);
						$oMatch->Save();
					}
					if($oMatch->getAwayTeamtournament()==$teamintournament_id){
						$oMatch->setAwayInsert(1);
						$oMatch->Save();
					}
					$this->CheckResult($oMatchResult->getMatchId());
				}
			}
		}

	}
	
	public function CheckResult($match_id) {
		$aMatchResults = $this->PluginVs_Stat_GetMatchresultItemsByFilter(array(
						'match_id' => $match_id,
						'#page' => 'count'
						));
		if($aMatchResults['count']==2){
				$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
				
				if($oMatch->getTournamentId()!=0){
					$oResultHome = $this->PluginVs_Stat_GetMatchresultByFilter(array(
							'match_id' => $match_id,
							'teamintournament_id' => $oMatch->getHomeTeamtournament()			
							));
					$oResultAway = $this->PluginVs_Stat_GetMatchresultByFilter(array(
							'match_id' => $match_id,
							'teamintournament_id' => $oMatch->getAwayTeamtournament()			
							));
				}else{
					$oResultHome = $this->PluginVs_Stat_GetMatchresultByFilter(array(
							'match_id' => $match_id,
							'teamintournament_id' => $oMatch->getHomeTeamtournament(),
							'user_id' => $oMatch->getHomePlayer()								
							));
					$oResultAway = $this->PluginVs_Stat_GetMatchresultByFilter(array(
							'match_id' => $match_id,
							'teamintournament_id' => $oMatch->getAwayTeamtournament(),
							'user_id' => $oMatch->getAwayPlayer()			
							));				
				
				}
				if($oResultHome->getHome()==$oResultHome->getHome()
					&& $oResultHome->getHome()==$oResultAway->getHome()
					&& $oResultHome->getAway()==$oResultAway->getAway()
					&& $oResultHome->getOt()==$oResultAway->getOt()
					&& $oResultHome->getSo()==$oResultAway->getSo()
					&& $oResultHome->getKo()==$oResultAway->getKo()
					&& $oResultHome->getTehko()==$oResultAway->getTehko()
					&& $oResultHome->getSubmission()==$oResultAway->getSubmission()
					&& $oResultHome->getDecision()==$oResultAway->getDecision()
					&& $oResultHome->getDisqualification()==$oResultAway->getDisqualification()
					&& $oResultHome->getPeriod()==$oResultAway->getPeriod())
					{
						$oMatch->setGoalsHome($oResultHome->getHome());
						$oMatch->setGoalsAway($oResultHome->getAway());
						$oMatch->setOt($oResultHome->getOt());
						$oMatch->setSo($oResultHome->getSo());
						
						$oMatch->setKo($oResultHome->getKo());
						$oMatch->setTehko($oResultHome->getTehko());
						$oMatch->setSubmission($oResultHome->getSubmission());
						$oMatch->setDecision($oResultHome->getDecision());
						$oMatch->setDisqualification($oResultHome->getDisqualification());
						
						$oMatch->setHomePlayer($oResultHome->getUserId());
						$oMatch->setAwayPlayer($oResultAway->getUserId());
						$oMatch->setHomeComment($oResultHome->getComment());
						$oMatch->setAwayComment($oResultAway->getComment());
						$oMatch->setPeriod($oResultAway->getPeriod());
						$oMatch->setPlayed(1);
						$oMatch->setPlayDates(date("Y-m-d H:i:s"));
						$oMatch->Save();
						$this->FormulaLfrmRating($oMatch);
						if($oMatch->getHomeRating()==0 && $oMatch->getAwayRating()==0 && $oMatch->getTeh()==0)
						$this->CalcRatingAll($match_id);//$this->CalcRating($match_id);
						$this->CalcStat($match_id);
						if($oMatch->getAwayPlayer()!=$oMatch->getHomePlayer())$this->CalcPlayerStat($match_id);
						$this->CalcPosition($match_id);
						if(!$oEvent = $this->PluginVs_Stat_GetStreamByFilter(array(
							'event_type' => 'match_played',
							'what_id' => $match_id		
							))
						){
							$oEvent =  Engine::GetEntity('PluginVs_Stat_Stream');
							$oEvent->setEventType('match_played');
							$oEvent->setWhatId($match_id);
							$oEvent->setTournamentId($oMatch->getTournamentId());
							$oEvent->setDateAdd(date("Y-m-d H:i:s"));
							$oEvent->Add();
						
						}
					}else{
					//ищем админов и пишем им в личку с номером матча
					
					}
		}		
    }
	
	public function CheckRatingTable($oMatch) {
	
	
		//Game
		if( !$oRatingGameHome = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => 0,
						'user_id' => $oMatch->getHomePlayer()			
						)) 
			)
		{
			$oHomeRating_add = null;
			$oHomeRating_add =  Engine::GetEntity('PluginVs_Stat_Rating');
			$oHomeRating_add->setUserId($oMatch->getHomePlayer());
			$oHomeRating_add->setGameId($oMatch->getGameId());
			$oHomeRating_add->setGametypeId(0);
			$oHomeRating_add->setRating(1000);
			$oHomeRating_add->setMatches(0);
			$oHomeRating_add->Add();
		}
		
		if( !$oRatingGameAway = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => 0,
						'user_id' => $oMatch->getAwayPlayer()			
						)) 
			)
		{
			$oAwayRating_add = null;
			$oAwayRating_add =  Engine::GetEntity('PluginVs_Stat_Rating');
			$oAwayRating_add->setUserId($oMatch->getAwayPlayer());
			$oAwayRating_add->setGameId($oMatch->getGameId());
			$oAwayRating_add->setGametypeId(0);
			$oAwayRating_add->setRating(1000);
			$oAwayRating_add->setMatches(0);
			$oAwayRating_add->Add();
		}
		//Game with gametype
		if( !$oRatingGametypeHome = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => $oMatch->getGametypeId(),
						'user_id' => $oMatch->getHomePlayer()			
						)) 
			)
		{
			$oHomeRating_add = null;
			$oHomeRating_add =  Engine::GetEntity('PluginVs_Stat_Rating');
			$oHomeRating_add->setUserId($oMatch->getHomePlayer());
			$oHomeRating_add->setGameId($oMatch->getGameId());
			$oHomeRating_add->setGametypeId($oMatch->getGametypeId());
			$oHomeRating_add->setRating(1000);
			$oHomeRating_add->setMatches(0);
			$oHomeRating_add->Add();
		}
		
		if( !$oRatingGametypeAway = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => $oMatch->getGametypeId(),
						'user_id' => $oMatch->getAwayPlayer()			
						)) 
			)
		{
			$oAwayRating_add = null;
			$oAwayRating_add =  Engine::GetEntity('PluginVs_Stat_Rating');
			$oAwayRating_add->setUserId($oMatch->getAwayPlayer());
			$oAwayRating_add->setGameId($oMatch->getGameId());
			$oAwayRating_add->setGametypeId($oMatch->getGametypeId());
			$oAwayRating_add->setRating(1000);
			$oAwayRating_add->setMatches(0);
			$oAwayRating_add->Add();
		}
		//Blog - league
		if( !$oRatingBlogHome = $this->PluginVs_Stat_GetRatingByFilter(array(
						'blog_id' => $oMatch->getBlogId(),
						'user_id' => $oMatch->getHomePlayer()			
						)) 
			)
		{
			$oHomeRating_add = null;
			$oHomeRating_add =  Engine::GetEntity('PluginVs_Stat_Rating');
			$oHomeRating_add->setUserId($oMatch->getHomePlayer());
			$oHomeRating_add->setBlogId($oMatch->getBlogId());
			$oHomeRating_add->setRating(1000);
			$oHomeRating_add->setMatches(0);
			$oHomeRating_add->Add();
		}
		
		if( !$oRatingBlogAway = $this->PluginVs_Stat_GetRatingByFilter(array(
						'blog_id' => $oMatch->getBlogId(),
						'user_id' => $oMatch->getAwayPlayer()			
						)) 
			)
		{
			$oAwayRating_add = null;
			$oAwayRating_add =  Engine::GetEntity('PluginVs_Stat_Rating');
			$oAwayRating_add->setUserId($oMatch->getAwayPlayer());
			$oAwayRating_add->setBlogId($oMatch->getBlogId());
			$oAwayRating_add->setRating(1000);
			$oAwayRating_add->setMatches(0);
			$oAwayRating_add->Add();
		}
		//Tournament
		if( !$oRatingTournamentHome = $this->PluginVs_Stat_GetRatingByFilter(array(
						'tournament_id' => $oMatch->getTournamentId(),
						'user_id' => $oMatch->getHomePlayer()			
						)) 
			)
		{	
			$oHomeRating_add = null;
			$oHomeRating_add =  Engine::GetEntity('PluginVs_ModuleStat_EntityRating');
			$oHomeRating_add->setUserId($oMatch->getHomePlayer());
			$oHomeRating_add->setTournamentId($oMatch->getTournamentId());
			$oHomeRating_add->setRating(1000);
			$oHomeRating_add->setMatches('0');
			$oHomeRating_add->Add();
			
		}
		
		if( !$oRatingTournamentAway = $this->PluginVs_Stat_GetRatingByFilter(array(
						'tournament_id' => $oMatch->getTournamentId(),
						'user_id' => $oMatch->getAwayPlayer()			
						)) 
			)
		{
			$oAwayRating_add = null;
			$oAwayRating_add =  Engine::GetEntity('PluginVs_ModuleStat_EntityRating');
			$oAwayRating_add->setUserId($oMatch->getAwayPlayer());
			$oAwayRating_add->setTournamentId($oMatch->getTournamentId());
			$oAwayRating_add->setRating(1000);
			$oAwayRating_add->setMatches(0);
			$oAwayRating_add->Add();
		}
		
		if( !$oHomeMatchRating = $this->PluginVs_Stat_GetMatchRatingByFilter(array(
				'match_id' => $oMatch->getMatchId(),
				'teamintournament_id' => $oMatch->getHomeTeamtournament()			
				)) 
			) 
		{
			$oHomeMatchRating_add =  Engine::GetEntity('PluginVs_Stat_MatchRating');
			$oHomeMatchRating_add->setUserId($oMatch->getHomePlayer());
			$oHomeMatchRating_add->setTeamintournamentId($oMatch->getHomeTeamtournament());
			$oHomeMatchRating_add->setMatchId($oMatch->getMatchId());
			$oHomeMatchRating_add->Add();
		}
		if( !$oAwayMatchRating = $this->PluginVs_Stat_GetMatchRatingByFilter(array(
				'match_id' => $oMatch->getMatchId(),
				'teamintournament_id' => $oMatch->getAwayTeamtournament()			
				))
			) 
		{
			$oAwayMatchRating_add =  Engine::GetEntity('PluginVs_Stat_MatchRating');
			$oAwayMatchRating_add->setUserId($oMatch->getAwayPlayer());
			$oAwayMatchRating_add->setTeamintournamentId($oMatch->getAwayTeamtournament());
			$oAwayMatchRating_add->setMatchId($oMatch->getMatchId());
			$oAwayMatchRating_add->Add();	
				
		}
				
		
	}
	
	public function CalcRatingAll($match_id) {
	
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);		
		
				
		$this->CheckRatingTable($oMatch);		

		$oHomeMatchRating = $this->PluginVs_Stat_GetMatchRatingByFilter(array(
				'match_id' => $oMatch->getMatchId(),
				'teamintournament_id' => $oMatch->getHomeTeamtournament()			
				));
		$oAwayMatchRating = $this->PluginVs_Stat_GetMatchRatingByFilter(array(
				'match_id' => $oMatch->getMatchId(),
				'teamintournament_id' => $oMatch->getAwayTeamtournament()			
				));
		//Game
		$oHomeRatingGame = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => 0,
						'user_id' => $oMatch->getHomePlayer()			
						));
						
		$oAwayRatingGame = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => 0,
						'user_id' => $oMatch->getAwayPlayer()			
						));
		//Gametype
		$oHomeRatingGametype = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => $oMatch->getGametypeId(),
						'user_id' => $oMatch->getHomePlayer()			
						));
						
		$oAwayRatingGametype = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => $oMatch->getGametypeId(),
						'user_id' => $oMatch->getAwayPlayer()			
						)); 
		//Blog
		$oHomeRatingBlog = $this->PluginVs_Stat_GetRatingByFilter(array(
						'blog_id' => $oMatch->getBlogId(),
						'user_id' => $oMatch->getHomePlayer()			
						));
						
		$oAwayRatingBlog = $this->PluginVs_Stat_GetRatingByFilter(array(
						'blog_id' => $oMatch->getBlogId(),
						'user_id' => $oMatch->getAwayPlayer()			
					)); 
		//Tournament
		$oHomeRatingTournament = $this->PluginVs_Stat_GetRatingByFilter(array(
						'tournament_id' => $oMatch->getTournamentId(),
						'user_id' => $oMatch->getHomePlayer()			
						));
	
		$oAwayRatingTournament = $this->PluginVs_Stat_GetRatingByFilter(array(
						'tournament_id' => $oMatch->getTournamentId(),
						'user_id' => $oMatch->getAwayPlayer()			
						));
		 				
		$this->FormulaRating($oMatch, $oHomeRatingGame, $oAwayRatingGame, $oHomeMatchRating, $oAwayMatchRating, 'game');
		$this->FormulaRating($oMatch, $oHomeRatingGametype, $oAwayRatingGametype, $oHomeMatchRating, $oAwayMatchRating, 'gametype');
		$this->FormulaRating($oMatch, $oHomeRatingBlog, $oAwayRatingBlog, $oHomeMatchRating, $oAwayMatchRating, 'blog');
		$this->FormulaRating($oMatch, $oHomeRatingTournament, $oAwayRatingTournament, $oHomeMatchRating, $oAwayMatchRating, 'tournament');
		$oHomeMatchRating->Save();
		$oAwayMatchRating->Save();
    }
	
	public function FormulaRating($oMatch, $oHomeRating, $oAwayRating, &$oHomeMatchRating, &$oAwayMatchRating, $what) {
		$G=1;
		if(abs($oMatch->getGoalsHome()-$oMatch->getGoalsAway())==1)$G=1;
		if(abs($oMatch->getGoalsHome()-$oMatch->getGoalsAway())==2)$G=1.5;
		if(abs($oMatch->getGoalsHome()-$oMatch->getGoalsAway())>2)$G=(11+abs($oMatch->getGoalsHome()-$oMatch->getGoalsAway()))/8;
		$K=10;
		if($oMatch->getTournamentId()==0)$K=10; //товарки
		if($oMatch->getTournamentId()!=0)$K=30; //турнир
		
		$W=0;
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())>0)$W=1;
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())==0)$W=0.5;		
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getOt()==1)$W=0.5;
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getSo()==1)$W=0.5;
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0)$W=0;
		
		$newHomerating = round($oHomeRating->getRating(),2)+$G*$K * ( $W - 1/(pow(10,(-1)*($oHomeRating->getRating()-$oAwayRating->getRating())/400 ) +1));
						
		$W=0;
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())>0)$W=1;
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())==0)$W=0.5;		
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getOt()==1)$W=0.5;
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getSo()==1)$W=0.5;
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0)$W=0;
		
		$newAwayrating = round($oAwayRating->getRating(),2)+$G*$K * ( $W - 1/(pow(10,(-1)*($oAwayRating->getRating()-$oHomeRating->getRating())/400 ) +1));
		
		if($what == 'game') {
			$oHomeMatchRating->setGameRating(number_format(round($newHomerating,2)-$oHomeRating->getRating(),2, '.', ''));
			$oAwayMatchRating->setGameRating(number_format(round($newAwayrating,2)-$oAwayRating->getRating(),2, '.', ''));
		}
		
		if($what == 'gametype') {
			$oHomeMatchRating->setGametypeRating(number_format(round($newHomerating,2)-$oHomeRating->getRating(),2, '.', ''));
			$oAwayMatchRating->setGametypeRating(number_format(round($newAwayrating,2)-$oAwayRating->getRating(),2, '.', ''));
			$oMatch->setHomeRating(number_format(round($newHomerating,2)-$oHomeRating->getRating(),2, '.', ''));
			$oMatch->setAwayRating(number_format(round($newAwayrating,2)-$oAwayRating->getRating(),2, '.', ''));
			$oMatch->Save();
		}
		
		if($what == 'blog') {
			$oHomeMatchRating->setBlogRating(number_format(round($newHomerating,2)-$oHomeRating->getRating(),2, '.', ''));
			$oAwayMatchRating->setBlogRating(number_format(round($newAwayrating,2)-$oAwayRating->getRating(),2, '.', ''));
		}
		
		if($what == 'tournament') {
			$oHomeMatchRating->setTournamentRating(number_format(round($newHomerating,2)-$oHomeRating->getRating(),2, '.', ''));
			$oAwayMatchRating->setTournamentRating(number_format(round($newAwayrating,2)-$oAwayRating->getRating(),2, '.', ''));
		}
		
		$oHomeRating->setRating(number_format(round($newHomerating,2),2, '.', ''));	
		$oHomeRating->setMatches($oHomeRating->getMatches()+1);
		$oHomeRating->Save();	
		
		$oAwayRating->setRating(number_format(round($newAwayrating,2),2, '.', ''));	
		$oAwayRating->setMatches($oAwayRating->getMatches()+1);
		$oAwayRating->Save();
	}
	public function FormulaLfrmRating($oMatch) {
		
		$this->CheckRatingTable($oMatch);
		
		$oHomeMatchRating = $this->PluginVs_Stat_GetMatchRatingByFilter(array(
				'match_id' => $oMatch->getMatchId(),
				'teamintournament_id' => $oMatch->getHomeTeamtournament()			
				));
		$oAwayMatchRating = $this->PluginVs_Stat_GetMatchRatingByFilter(array(
				'match_id' => $oMatch->getMatchId(),
				'teamintournament_id' => $oMatch->getAwayTeamtournament()			
				));
		if($oMatch->getHometeamtournament()->getId()) {
			$oHomeTeam = $oMatch->getHometeamtournament()->getTeam();
		}
		if($oMatch->getAwayteamtournament()->getId()) {
			$oAwayTeam = $oMatch->getAwayteamtournament()->getTeam();
		}
		if($oAwayTeam && $oHomeTeam){
			$G=0;
			$W=0;
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())>0)$W=1;
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())==0 && $oMatch->getTeh()==0)$W=0.5;		
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getOt()==1)$W=0.5;
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getSo()==1)$W=0.5;
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0)$W=0;
			
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())>0)$G = ($oMatch->getGoalsHome()-$oMatch->getGoalsAway())/100;
			
			$iHomeRating = ( ($oAwayTeam->getSkill() - 150)/($oHomeTeam->getSkill() - 150) )*($W + $G);
			
			$G=0;
			$W=0;
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())>0)$W=1;
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())==0 && $oMatch->getTeh()==0)$W=0.5;		
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getOt()==1)$W=0.5;
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getSo()==1)$W=0.5;
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0)$W=0;	
			
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())>0)$G = ($oMatch->getGoalsAway()-$oMatch->getGoalsHome())/100;
			
			$iAwayRating = ( ($oHomeTeam->getSkill() - 150)/($oAwayTeam->getSkill() - 150) )*($W + $G);
			
			
			$oHomeMatchRating->setTournamentRatingLfrm(number_format($iHomeRating,2, '.', ''));
			$oAwayMatchRating->setTournamentRatingLfrm(number_format($iAwayRating,2, '.', ''));

			$oHomeMatchRating->Save();
			$oAwayMatchRating->Save();
		}
	}
	
	public function CalcRating($match_id) {
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
		
		if( !$oRating = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => $oMatch->getGametypeId(),
						'user_id' => $oMatch->getHomePlayer()			
						)) 
			)
		{
			$oHomeRating_add =  Engine::GetEntity('PluginVs_Stat_Rating');
			$oHomeRating_add->setUserId($oMatch->getHomePlayer());
			$oHomeRating_add->setGameId($oMatch->getGameId());
			$oHomeRating_add->setGametypeId($oMatch->getGametypeId());
			$oHomeRating_add->setRating(1000);
			$oHomeRating_add->setMatches(0);
			$oHomeRating_add->Add();
		}
		
		if( !$oRating = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => $oMatch->getGametypeId(),
						'user_id' => $oMatch->getAwayPlayer()			
						)) 
			)
		{
			$oAwayRating_add =  Engine::GetEntity('PluginVs_Stat_Rating');
			$oAwayRating_add->setUserId($oMatch->getAwayPlayer());
			$oAwayRating_add->setGameId($oMatch->getGameId());
			$oAwayRating_add->setGametypeId($oMatch->getGametypeId());
			$oAwayRating_add->setRating(1000);
			$oAwayRating_add->setMatches(0);
			$oAwayRating_add->Add();
		}
		
		$oHomeRating = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => $oMatch->getGametypeId(),
						'user_id' => $oMatch->getHomePlayer()			
						));
						
		$oAwayRating = $this->PluginVs_Stat_GetRatingByFilter(array(
						'game_id' => $oMatch->getGameId(),
						'gametype_id' => $oMatch->getGametypeId(),
						'user_id' => $oMatch->getAwayPlayer()			
						)); 
		$G=1;
		if(abs($oMatch->getGoalsHome()-$oMatch->getGoalsAway())==1)$G=1;
		if(abs($oMatch->getGoalsHome()-$oMatch->getGoalsAway())==2)$G=1.5;
		if(abs($oMatch->getGoalsHome()-$oMatch->getGoalsAway())>2)$G=(11+abs($oMatch->getGoalsHome()-$oMatch->getGoalsAway()))/8;
		$K=10;
		if($oMatch->getTournamentId()==0)$K=10; //товарки
		if($oMatch->getTournamentId()!=0)$K=30; //турнир
		//if($oMatch->getTournamentId()!=0 && $oMatch->getRoundId()==0)$K=30; //турнир
		
		$W=0;
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())>0)$W=1;
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())==0)$W=0.5;		
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getOt()==1)$W=0.5;
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getSo()==1)$W=0.5;
		if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0)$W=0;
		
		$newHomerating = round($oHomeRating->getRating(),2)+$G*$K * ( $W - 1/(pow(10,(-1)*($oHomeRating->getRating()-$oAwayRating->getRating())/400 ) +1));
						
		$W=0;
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())>0)$W=1;
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())==0)$W=0.5;		
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getOt()==1)$W=0.5;
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getSo()==1)$W=0.5;
		if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0)$W=0;
		
		$newAwayrating = round($oAwayRating->getRating(),2)+$G*$K * ( $W - 1/(pow(10,(-1)*($oAwayRating->getRating()-$oHomeRating->getRating())/400 ) +1));
		
		$oMatch->setHomeRating(number_format(round($newHomerating,2)-$oHomeRating->getRating(),2, '.', ''));
		$oMatch->setAwayRating(number_format(round($newAwayrating,2)-$oAwayRating->getRating(),2, '.', ''));
		$oMatch->Save();
		
		$oHomeRating->setRating(number_format(round($newHomerating,2),2, '.', ''));	
		$oHomeRating->setMatches($oHomeRating->getMatches()+1);
		$oHomeRating->Save();	
		
		$oAwayRating->setRating(number_format(round($newAwayrating,2),2, '.', ''));	
		$oAwayRating->setMatches($oAwayRating->getMatches()+1);
		$oAwayRating->Save();			
		
    }
	
	
	public function CalcLastTen($oStat, $oMatch, $teamintournament_id){
		$aMatches=$this->PluginVs_Stat_GetMatchesItemsByFilter(array(
			'played'=> '1',
			'tournament_id' => $oMatch->getTournamentId(),
			'round_id' => $oMatch->getRoundId(),
			'#where' => array('(home_teamtournament = (?d) or away_teamtournament = (?d) )' => array($teamintournament_id, $teamintournament_id)),	
			'#order' =>array('play_dates'=>'desc'),
			'#limit' =>array('0','10')
		));
		$win=0;
		$ot=0;
		$lose=0;
		$results = array();
		foreach($aMatches as $oMatches){
			if($oMatches->getHomeTeamtournament()==$teamintournament_id){
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())>0 && $oMatches->getOt()==0 && $oMatches->getSo()==0 )$win++;
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())>0 && $oMatches->getOt()==1 && $oMatches->getSo()==0 )$win++;
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())>0 && $oMatches->getOt()==0 && $oMatches->getSo()==1 )$win++;
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())<0 && $oMatches->getOt()==0 && $oMatches->getSo()==0 )$lose++;
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())<0 && $oMatches->getOt()==1 && $oMatches->getSo()==0 )$ot++;
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())<0 && $oMatches->getOt()==0 && $oMatches->getSo()==1 )$ot++;
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())==0 && $oMatches->getTeh()==0)$ot++;
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())==0 && $oMatches->getTeh()==1)$lose++;
				
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())>0)$results[] = '1';
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())<0)$results[] = '0';
				if(($oMatches->getGoalsHome()-$oMatches->getGoalsAway())==0)$results[] = '2';
			}
			
			if($oMatches->getAwayTeamtournament()==$teamintournament_id){
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())>0 && $oMatches->getOt()==0 && $oMatches->getSo()==0 )$win++;
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())>0 && $oMatches->getOt()==1 && $oMatches->getSo()==0 )$win++;
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())>0 && $oMatches->getOt()==0 && $oMatches->getSo()==1 )$win++;
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())<0 && $oMatches->getOt()==0 && $oMatches->getSo()==0 )$lose++;
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())<0 && $oMatches->getOt()==1 && $oMatches->getSo()==0 )$ot++;
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())<0 && $oMatches->getOt()==0 && $oMatches->getSo()==1 )$ot++;
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())==0 && $oMatches->getTeh()==0)$ot++;
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())==0 && $oMatches->getTeh()==1)$lose++;
				
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())>0)$results[] = '1';
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())<0)$results[] = '0';
				if(($oMatches->getGoalsAway()-$oMatches->getGoalsHome())==0)$results[] = '2';
			}
		}
		$oStat->setLastTen($win."-".$lose."-".$ot);
		$oStat->setLastTenResult(serialize($results));
		return $oStat;
	}
	
	public function CanRecalcPoints($oMatch){
		if($oMatch->getEventId()){
			if( $oEvent = $this->PluginVs_Stat_GetEventByEventId($oMatch->getEventId()) ){
				if($oEvent->getClosed()==1)return false;			
			}			
		}	
		return true;
	}
	
	public function NullTitul($oMatch,$teamintournament_id){
		$aTournamentStat = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
			'tournament_id' => $oMatch->getTournamentId(),
			'teamintournament_id <>' => $teamintournament_id
		));
		foreach($aTournamentStat as $oTournamentStat) {
			$oTournamentStat->setTitul(0);
			$oTournamentStat->Save();
		}
		return true;
	}
	
	
	public function CalcDelStat($oTeamResult, $oSopernikResult, $oStat, $oMatch, $oTournament, $goal_diff, $plus_minus = 1) {
		
		$can_recalc_points = $this->CanRecalcPoints($oMatch);
		
		$teh_win  = 0;
		$teh_lose = 0;
		if($oMatch->getEventId()!=0){
			$teh_win  = 0.5;
			$teh_lose = -3;				
		}
		$same_conf = 0;
		$same_div = 0;
		if(	$oMatch->getHometeamtournament()->getParentgroupId() != 0 
			&& $oMatch->getHometeamtournament()->getParentgroupId() == $oMatch->getAwayteamtournament()->getParentgroupId()) {
			
			$same_conf = 1;	
		}
		if(	$oMatch->getHometeamtournament()->getGroupId() != 0 
			&& $oMatch->getHometeamtournament()->getGroupId() == $oMatch->getAwayteamtournament()->getGroupId()) {
			
			$same_div = 1;	
		}
		
		
		if($oStat->getTeamintournamentId() == $oMatch->getHomeTeamtournament()){
			if($oMatch->getTeh()==0) {
				if($goal_diff>0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
					$oStat->setHomeW($oStat->getHomeW() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfW($oStat->getConfW() + $plus_minus * 1); 
					if($same_div)$oStat->setDivW($oStat->getDivW() + $plus_minus * 1); 
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getWin());
				}
				if($goal_diff>0 && $oMatch->getOt()==1 && $oMatch->getSo()==0 ){
					$oStat->setHomeWot($oStat->getHomeWot() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfWot($oStat->getConfWot() + $plus_minus * 1); 
					if($same_div)$oStat->setDivWot($oStat->getDivWot() + $plus_minus * 1); 
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getWinO());
				}
				if($goal_diff>0 && $oMatch->getOt()==0 && $oMatch->getSo()==1 ){
					$oStat->setHomeWb($oStat->getHomeWb() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfWb($oStat->getConfWb() + $plus_minus * 1); 
					if($same_div)$oStat->setDivWb($oStat->getDivWb() + $plus_minus * 1); 
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getWinB());
				}
				if($goal_diff<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
					$oStat->setHomeL($oStat->getHomeL() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfL($oStat->getConfL() + $plus_minus * 1); 
					if($same_div)$oStat->setDivL($oStat->getDivL() + $plus_minus * 1);
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLose());
				}
				if($goal_diff<0 && $oMatch->getOt()==1 && $oMatch->getSo()==0 ){
					$oStat->setHomeLot($oStat->getHomeLot() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfLot($oStat->getConfLot() + $plus_minus * 1); 
					if($same_div)$oStat->setDivLot($oStat->getDivLot() + $plus_minus * 1);
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLoseO());
				}
				if($goal_diff<0 && $oMatch->getOt()==0 && $oMatch->getSo()==1 ){
					$oStat->setHomeLb($oStat->getHomeLb() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfLb($oStat->getConfLb() + $plus_minus * 1); 
					if($same_div)$oStat->setDivLb($oStat->getDivLb() + $plus_minus * 1);
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLoseB());
				}
				if($goal_diff==0 && $oMatch->getTeh()==0){
					$oStat->setHomeT($oStat->getHomeT() + $plus_minus * 1);
					if($same_conf)$oStat->setConfT($oStat->getConfT() + $plus_minus * 1); 
					if($same_div)$oStat->setDivT($oStat->getDivT() + $plus_minus * 1); 
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getPointsN());
				}
				if($goal_diff>0 && $oMatch->getTeh()==0 && $oMatch->getGoalsAway()==0)$oStat->setSuhW($oStat->getSuhW() + $plus_minus * 1);
				if($goal_diff<0 && $oMatch->getTeh()==0 && $oMatch->getGoalsHome()==0)$oStat->setSuhL($oStat->getSuhL() + $plus_minus * 1);
			}
			
			if($oMatch->getTeh()==1) {				
				if($goal_diff==0 && $oMatch->getTeh()==1){
					$oStat->setHomeL($oStat->getHomeL() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfL($oStat->getConfL() + $plus_minus * 1); 
					if($same_div)$oStat->setDivL($oStat->getDivL() + $plus_minus * 1);
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLose());
				}
				if($oMatch->getEventId()!=0){
					if($goal_diff>0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
						$oStat->setHomeW($oStat->getHomeW() + $plus_minus * 1); 
						if($same_conf)$oStat->setConfW($oStat->getConfW() + $plus_minus * 1); 
						if($same_div)$oStat->setDivW($oStat->getDivW() + $plus_minus * 1); 
						if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $teh_win );
					}
					if($goal_diff<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
						$oStat->setHomeL($oStat->getHomeL() + $plus_minus * 1); 
						if($same_conf)$oStat->setConfL($oStat->getConfL() + $plus_minus * 1); 
						if($same_div)$oStat->setDivL($oStat->getDivL() + $plus_minus * 1);
						if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $teh_lose );
					}
				}else{
					if($goal_diff>0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
						$oStat->setHomeW($oStat->getHomeW() + $plus_minus * 1); 
						if($same_conf)$oStat->setConfW($oStat->getConfW() + $plus_minus * 1); 
						if($same_div)$oStat->setDivW($oStat->getDivW() + $plus_minus * 1);
						if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getWin());
					}
					if($goal_diff<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
						$oStat->setHomeL($oStat->getHomeL() + $plus_minus * 1); 
						if($same_conf)$oStat->setConfL($oStat->getConfL() + $plus_minus * 1); 
						if($same_div)$oStat->setDivL($oStat->getDivL() + $plus_minus * 1);
						if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLose());
					}
				}
			}

			$oStat->setGf($oStat->getGf() + $plus_minus * $oMatch->getGoalsHome());
			$oStat->setGa($oStat->getGa() + $plus_minus * $oMatch->getGoalsAway());
			
			$oStat->setYardW($oStat->getYardW()  + $plus_minus *  $oMatch->getHomeYard());
			$oStat->setYardL($oStat->getYardL()  + $plus_minus *  $oMatch->getAwayYard());
			
		}else{
			if($oMatch->getTeh()==0) {
				if($goal_diff>0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
					$oStat->setAwayW($oStat->getAwayW() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfW($oStat->getConfW() + $plus_minus * 1); 
					if($same_div)$oStat->setDivW($oStat->getDivW() + $plus_minus * 1);
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getWin());
				}
				if($goal_diff>0 && $oMatch->getOt()==1 && $oMatch->getSo()==0 ){
					$oStat->setAwayWot($oStat->getAwayWot() + $plus_minus * 1);
					if($same_conf)$oStat->setConfWot($oStat->getConfWot() + $plus_minus * 1); 
					if($same_div)$oStat->setDivWot($oStat->getDivWot() + $plus_minus * 1); 
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getWinO());
				}
				if($goal_diff>0 && $oMatch->getOt()==0 && $oMatch->getSo()==1 ){
					$oStat->setAwayWb($oStat->getAwayWb() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfWb($oStat->getConfWb() + $plus_minus * 1); 
					if($same_div)$oStat->setDivWb($oStat->getDivWb() + $plus_minus * 1);
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getWinB());
				}
				if($goal_diff<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
					$oStat->setAwayL($oStat->getAwayL() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfL($oStat->getConfL() + $plus_minus * 1); 
					if($same_div)$oStat->setDivL($oStat->getDivL() + $plus_minus * 1);
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLose());
				}
				if($goal_diff<0 && $oMatch->getOt()==1 && $oMatch->getSo()==0 ){
					$oStat->setAwayLot($oStat->getAwayLot() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfLot($oStat->getConfLot() + $plus_minus * 1); 
					if($same_div)$oStat->setDivLot($oStat->getDivLot() + $plus_minus * 1);
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLoseO());
				}
				if($goal_diff<0 && $oMatch->getOt()==0 && $oMatch->getSo()==1 ){
					$oStat->setAwayLb($oStat->getAwayLb() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfLb($oStat->getConfLb() + $plus_minus * 1); 
					if($same_div)$oStat->setDivLb($oStat->getDivLb() + $plus_minus * 1);
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLoseB());
				}
				if($goal_diff==0 && $oMatch->getTeh()==0){
					$oStat->setAwayT($oStat->getAwayT() + $plus_minus * 1); 
					if($same_conf)$oStat->setConfT($oStat->getConfT() + $plus_minus * 1); 
					if($same_div)$oStat->setDivT($oStat->getDivT() + $plus_minus * 1); 
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getPointsN());
				}
				if($goal_diff>0 && $oMatch->getTeh()==0 && $oMatch->getGoalsHome()==0)$oStat->setSuhW($oStat->getSuhW() + $plus_minus * 1);
				if($goal_diff<0 && $oMatch->getTeh()==0 && $oMatch->getGoalsAway()==0)$oStat->setSuhL($oStat->getSuhL() + $plus_minus * 1);
			}
			if($oMatch->getTeh()==1) {
				if($goal_diff==0 && $oMatch->getTeh()==1){
					$oStat->setAwayL($oStat->getAwayL() + $plus_minus * 1);
					if($same_conf)$oStat->setConfL($oStat->getConfL() + $plus_minus * 1); 
					if($same_div)$oStat->setDivL($oStat->getDivL() + $plus_minus * 1); 
					if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLose());
				}
				if($oMatch->getEventId()!=0){
					if($goal_diff>0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
						$oStat->setAwayW($oStat->getAwayW() + $plus_minus * 1); 
						if($same_conf)$oStat->setConfW($oStat->getConfW() + $plus_minus * 1); 
						if($same_div)$oStat->setDivW($oStat->getDivW() + $plus_minus * 1);
						if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $teh_win );
					}
					if($goal_diff<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
						$oStat->setAwayL($oStat->getAwayL() + $plus_minus * 1); 
						if($same_conf)$oStat->setConfL($oStat->getConfL() + $plus_minus * 1); 
						if($same_div)$oStat->setDivL($oStat->getDivL() + $plus_minus * 1);
						if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $teh_lose);
					}
				}else{
					if($goal_diff>0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
						$oStat->setAwayW($oStat->getAwayW() + $plus_minus * 1); 
						if($same_conf)$oStat->setConfW($oStat->getConfW() + $plus_minus * 1); 
						if($same_div)$oStat->setDivW($oStat->getDivW() + $plus_minus * 1);
						if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getWin());
					}
					if($goal_diff<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0 ){
						$oStat->setAwayL($oStat->getAwayL() + $plus_minus * 1);
						if($same_conf)$oStat->setConfL($oStat->getConfL() + $plus_minus * 1); 
						if($same_div)$oStat->setDivL($oStat->getDivL() + $plus_minus * 1); 
						if($can_recalc_points)$oStat->setPoints($oStat->getPoints() + $plus_minus * $oTournament->getLose());
					}
				}
			}
			

			
			$oStat->setGf($oStat->getGf() + $plus_minus * $oMatch->getGoalsAway());
			$oStat->setGa($oStat->getGa() + $plus_minus * $oMatch->getGoalsHome());
			
			$oStat->setYardW($oStat->getYardW()  + $plus_minus *  $oMatch->getAwayYard());
			$oStat->setYardL($oStat->getYardL()  + $plus_minus *  $oMatch->getHomeYard());
			
		}
				
		if($goal_diff>0 && $oMatch->getKo()==1)$oStat->setWko($oStat->getWko() + $plus_minus * 1);
		if($goal_diff>0 && $oMatch->getTehko()==1)$oStat->setWtko($oStat->getWtko() + $plus_minus * 1);
		if($goal_diff>0 && $oMatch->getSubmission()==1)$oStat->setWsub($oStat->getWsub() + $plus_minus * 1);
		if($goal_diff>0 && $oMatch->getDecision()==1)$oStat->setWdec($oStat->getWdec() + $plus_minus * 1);
		if($goal_diff>0 && $oMatch->getDisqualification()==1)$oStat->setWdisq($oStat->getWdisq() + $plus_minus * 1);
		
		if($goal_diff<0 && $oMatch->getKo()==1)$oStat->setLko($oStat->getLko() + $plus_minus * 1);
		if($goal_diff<0 && $oMatch->getTehko()==1)$oStat->setLtko($oStat->getLtko() + $plus_minus * 1);
		if($goal_diff<0 && $oMatch->getSubmission()==1)$oStat->setLsub($oStat->getLsub() + $plus_minus * 1);
		if($goal_diff<0 && $oMatch->getDecision()==1)$oStat->setLdec($oStat->getLdec() + $plus_minus * 1);
		if($goal_diff<0 && $oMatch->getDisqualification()==1)$oStat->setLdisq($oStat->getLdisq() + $plus_minus * 1);
		
		if($oMatch->getEventId()!=0 && $oMatch->getTitul() && $goal_diff>0){
			$this->NullTitul( $oMatch, $oStat->getTeamintournamentId());				
			if($plus_minus=='1'){
				$oStat->setTitul('1');
			}else{
				$oStat->setTitul('0');
			}
			$oStat->setTituls( $oStat->getTituls() +  $plus_minus * 1 );			
		}
			
		$oStat->setPeriods($oStat->getPeriods() + $plus_minus * $oTeamResult->getPeriod());
			
		$oStat->setKd($oStat->getKd() + $plus_minus * $oTeamResult->getKnockdowns());
		$oStat->setKda($oStat->getKda() + $plus_minus * $oSopernikResult->getKnockdowns());
		
		$oStat->setSs($oStat->getSs() + $plus_minus * $oTeamResult->getSigStrikes());
		$oStat->setSsAt($oStat->getSsAt() + $plus_minus * $oTeamResult->getSigStrikesAt());			
		$oStat->setSsa($oStat->getSsa() + $plus_minus * $oSopernikResult->getSigStrikes());
		$oStat->setSsaAt($oStat->getSsaAt() + $plus_minus * $oSopernikResult->getSigStrikesAt());		
		
		$oStat->setTs($oStat->getTs() + $plus_minus * $oTeamResult->getTotalStrikes());
		$oStat->setTsAt($oStat->getTsAt() + $plus_minus * $oTeamResult->getTotalStrikesAt());
		$oStat->setTsa($oStat->getTsa() + $plus_minus * $oSopernikResult->getTotalStrikes());
		$oStat->setTsaAt($oStat->getTsaAt() + $plus_minus * $oSopernikResult->getTotalStrikesAt());			
		
		$oStat->setTd($oStat->getTd() + $plus_minus * $oTeamResult->getTakedowns());
		$oStat->setTdAt($oStat->getTdAt() + $plus_minus * $oTeamResult->getTakedownsAt());
		$oStat->setTda($oStat->getTda() + $plus_minus * $oSopernikResult->getTakedowns());
		$oStat->setTdaAt($oStat->getTdaAt() + $plus_minus * $oSopernikResult->getTakedownsAt());		
					
		$oStat->setSm($oStat->getSm() + $plus_minus * $oTeamResult->getSubmissionAt());
		$oStat->setGp($oStat->getGp() + $plus_minus * $oTeamResult->getGround());
		
		
		
		$oStat->setShots($oStat->getShots()  + $plus_minus *  $oTeamResult->getShots());
		$oStat->setHits($oStat->getHits()  + $plus_minus *  $oTeamResult->getHits());
		$oStat->setPim($oStat->getPim()  + $plus_minus *  $oTeamResult->getPenalty());
		
		$oStat->setSecundeAt($oStat->getSecundeAt()  + $plus_minus *  $oTeamResult->getSecundeAt() + $plus_minus *  $oTeamResult->getMinuteAt()*60);
		$oStat->setPass($oStat->getPass()  + $plus_minus *  $oTeamResult->getPassPrc());
		$oStat->setPowerplayWin($oStat->getPowerplayWin()  + $plus_minus *  $oTeamResult->getPowerplayRealize());
		$oStat->setPowerplayVsego($oStat->getPowerplayVsego()  + $plus_minus *  $oTeamResult->getPp());
		$oStat->setShorthand($oStat->getShorthand()  + $plus_minus *  $oTeamResult->getPkg());
		$oStat->setBullits($oStat->getBullits()  + $plus_minus *  $oTeamResult->getBullits());
		$oStat->setEmptyNet($oStat->getEmptyNet()  + $plus_minus *  $oTeamResult->getEmptyNet());
		
		$oStat->setFaceoffWin($oStat->getFaceoffWin()  + $plus_minus *  $oTeamResult->getFaceoffWin());
		$oStat->setFaceoffVsego($oStat->getFaceoffVsego()  + $plus_minus *  $oTeamResult->getFaceoffWin()  + $plus_minus *  $oSopernikResult->getFaceoffWin() );
		
		$oStat->setPenaltykillLose($oStat->getPenaltykillLose()  + $plus_minus *  $oSopernikResult->getPowerplayRealize());
		$oStat->setPenaltykillVsego($oStat->getPenaltykillVsego()  + $plus_minus *  $oSopernikResult->getPp());
		
		$oStat->setDifWinLose( ($oStat->getHomeW()+$oStat->getHomeWot()+$oStat->getHomeWb() + $oStat->getAwayW()+$oStat->getAwayWot()+$oStat->getAwayWb()) -($oStat->getHomeL()+$oStat->getHomeLot()+$oStat->getHomeLb() + $oStat->getAwayL()+$oStat->getAwayLot()+$oStat->getAwayLb()));
		
		$oMatchRating = $this->PluginVs_Stat_GetMatchRatingByFilter(array(
				'match_id' => $oMatch->getMatchId(),
				'teamintournament_id' => $oStat->getTeamintournamentId()			
				));
		$oStat->setRatingLfrm($oStat->getRatingLfrm()  + $plus_minus *  $oMatchRating->getTournamentRatingLfrm());		
		
		return $oStat;
	}
	
	public function CalcStat($match_id) {
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
		if($oMatch->getTournamentId()!=0){
		
			$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($oMatch->getTournamentId());
			
			if(!$this->PluginVs_Stat_GetTournamentstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId()
					)))
			{
				$this->EventCreateStatTableByTournamentRound($oMatch->getTournamentId(),$oMatch->getRoundId());
			}
			
			if(!$this->PluginVs_Stat_GetTournamentstatByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),
				'teamintournament_id' => $oMatch->getHomeTeamtournament()
				)))
			{
				$this->EventCreateTournamentStatTableByMatchId($match_id);
			}
			if(!$this->PluginVs_Stat_GetTournamentstatByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),
				'teamintournament_id' => $oMatch->getAwayTeamtournament()
				)))
			{
				$this->EventCreateTournamentStatTableByMatchId($match_id);
			}
		
		
			$oHomeResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
					'match_id' => $oMatch->getMatchId(),
					'teamintournament_id' => $oMatch->getHomeTeamtournament()			
					));
			$oAwayResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
					'match_id' => $oMatch->getMatchId(),
					'teamintournament_id' => $oMatch->getAwayTeamtournament()			
					));
			
			$oHomeStat = $this->PluginVs_Stat_GetTournamentstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId(),
					'teamintournament_id' => $oMatch->getHomeTeamtournament()			
					));
			if($oHomeResult && $oAwayResult){
				$oHomeStat = $this->CalcDelStat($oHomeResult, $oAwayResult, $oHomeStat, $oMatch, $oTournament, ($oMatch->getGoalsHome()-$oMatch->getGoalsAway()), 1);
			}
			
			$oHomeStat = $this->CalcLastTen($oHomeStat, $oMatch, $oMatch->getHomeTeamtournament());
			
			$oHomeStat->Save();
			
			$oAwayStat = $this->PluginVs_Stat_GetTournamentstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId(),
					'teamintournament_id' => $oMatch->getAwayTeamtournament()			
					));
			if($oHomeResult && $oAwayResult){
				$oAwayStat = $this->CalcDelStat( $oAwayResult, $oHomeResult, $oAwayStat, $oMatch, $oTournament,($oMatch->getGoalsAway()-$oMatch->getGoalsHome()), 1);
			}
			
			$oAwayStat = $this->CalcLastTen($oAwayStat, $oMatch, $oMatch->getAwayTeamtournament());
			
			$oAwayStat->Save();
			//$this->CalcPosition($match_id);
		}
	}
	public function CalcPosition($match_id) {
	
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
		if($oMatch->getEventId()!='0') return;
		
		$order = array('points'=>'desc', '(home_w+home_wot+away_w+away_wot)'=>'desc', '(gf-ga)'=>'desc');
		$oGame= $this->PluginVs_Stat_GetGameByGameId($oMatch->getGameId());
		if($oGame->getSportId()==3)$order = array( '(home_w + away_w + home_wot + away_wot)'=>'desc', 'points'=>'desc', '(home_l + away_l + home_lot + away_lot)'=>'asc',  '(gf-ga)'=>'desc'
		/*'(home_w + away_w + home_wot + away_wot + home_wb + away_wb - (home_l + away_l + home_lot + away_lot + home_lb + away_lb))/(home_w + away_w + home_wot + away_wot + home_wb + away_wb + (home_l + away_l + home_lot + away_lot + home_lb + away_lb))'=>'desc',*/ 
		);
		$groups=array();
		$aStats = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
			'tournament_id' => $oMatch->getTournamentId(),
			'round_id' => $oMatch->getRoundId(),
			'#order' => $order
		));
		foreach($aStats as $oStats)
		{
			$group_exist=0;
			foreach($groups as $group)
			{
				if($group==$oStats->getGroupId())$group_exist=1;
				$oStats->setGrouplead(0);
				$oStats->setNbalead(0);
			}
			if($group_exist==0){
				$groups[]=$oStats->getGroupId();
				$oStats->setGrouplead(1);
				$oStats->setNbalead(1);
			}
			
			//$oStats->setPosition($position);
			$oStats->Save();
		}
		
		if($oGame->getSportId()==3) {
			$order_basket = array( 'parentgroup_id'=>'desc', '(home_w + away_w + home_wot + away_wot)'=>'desc', 'points'=>'desc',  '(gf-ga)'=>'desc');
			$aStats = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),
				'round_id' => $oMatch->getRoundId(),
				'#order' => $order_basket
			));
			$parentgroup_id=-1;
			$num=0;
			
			foreach($aStats as $oStats)
			{
				if( $parentgroup_id!=$oStats->getParentgroupId()){
					$num=0;
					$parentgroup_id=$oStats->getParentgroupId();
				}				
				if($num==0 && $oStats->getNbalead()==0){
					$oStats->setNbalead(1);
					$oStats->Save();
					$num++;
				}
				
				
			}
		
		}
		
		$aStats = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
			'tournament_id' => $oMatch->getTournamentId(),
			'round_id' => $oMatch->getRoundId(),
			'#order' =>$order,		
		));
		$position=1;
		foreach($aStats as $oStats)
		{
			$oStats->setPosition($position);
			$oStats->Save();
			$position++;
		}
	}

	public function DeleteStat($match_id) {
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
		if($oMatch->getTournamentId()!=0 && $oMatch->getPlayed()==1){
			
			$this->DeletePlayerStatInMatch($match_id);
			$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($oMatch->getTournamentId());
			
			if(!$this->PluginVs_Stat_GetTournamentstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId()
					)))
			{
				$this->EventCreateStatTableByTournamentRound($oMatch->getTournamentId(),$oMatch->getRoundId());
			}
			
			if(!$this->PluginVs_Stat_GetTournamentstatByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),
				'teamintournament_id' => $oMatch->getHomeTeamtournament()
				)))
			{
				$this->EventCreateTournamentStatTableByMatchId($match_id);
			}
			if(!$this->PluginVs_Stat_GetTournamentstatByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),
				'teamintournament_id' => $oMatch->getAwayTeamtournament()
				)))
			{
				$this->EventCreateTournamentStatTableByMatchId($match_id);
			}
			
			$oHomeResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
					'match_id' => $oMatch->getMatchId(),
					'teamintournament_id' => $oMatch->getHomeTeamtournament()			
					));
			$oAwayResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
					'match_id' => $oMatch->getMatchId(),
					'teamintournament_id' => $oMatch->getAwayTeamtournament()			
					));
					
			$oHomeStat = $this->PluginVs_Stat_GetTournamentstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId(),
					'teamintournament_id' => $oMatch->getHomeTeamtournament()			
					));
			
			if($oHomeResult && $oAwayResult){
				$oHomeStat = $this->CalcDelStat($oHomeResult, $oAwayResult, $oHomeStat, $oMatch, $oTournament, ($oMatch->getGoalsHome()-$oMatch->getGoalsAway()),-1);
			}
			
			$oHomeStat = $this->CalcLastTen($oHomeStat, $oMatch, $oMatch->getHomeTeamtournament());
			
			$oHomeStat->Save();
			
			$oAwayStat = $this->PluginVs_Stat_GetTournamentstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId(),
					'teamintournament_id' => $oMatch->getAwayTeamtournament()			
					));
			if($oHomeResult && $oAwayResult){
				$oAwayStat = $this->CalcDelStat( $oAwayResult, $oHomeResult, $oAwayStat, $oMatch, $oTournament, ($oMatch->getGoalsAway()-$oMatch->getGoalsHome()), -1);
			}
			$oAwayStat = $this->CalcLastTen($oAwayStat, $oMatch, $oMatch->getAwayTeamtournament());
			
			$oAwayStat->Save();
			
			$this->CalcPosition($match_id);
		}
	}
	
	public function CalcNewRating($match_id) {
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
		
		if($oMatch->getPlayed()){
			$oPlayerTournamentHome = $this->PluginVs_Stat_GetPlayertournamentByFilter(array(
								'user_id' => $oMatch->getHomePlayer(),
								'tournament_id'  => $oMatch->getTournamentId() ));
								
			$oPlayerTournamentAway = $this->PluginVs_Stat_GetPlayertournamentByFilter(array(
								'user_id' => $oMatch->getAwayPlayer(),
								'tournament_id'  => $oMatch->getTournamentId() ));
			
			$raznica=0;
			$W=0;
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())>0){$W=1; $raznica=$oMatch->getGoalsHome()-$oMatch->getGoalsAway();}
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())==0)$W=0.5;		
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getOt()==1){$W=0.5; $raznica=1;}
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getSo()==1){$W=0.5; $raznica=1;}
			if(($oMatch->getGoalsHome()-$oMatch->getGoalsAway())<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0)$W=0;
			
			$newHomerating = round( ($W + $raznica *0.01 ),2);
			
			//$newHomerating = round($oHomeRating->getRating(),2)+$G*$K * ( $W - 1/(pow(10,(-1)*($oHomeRating->getRating()-$oAwayRating->getRating())/400 ) +1));
			
			$raznica=0;
			$W=0;
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())>0){$W=1; $raznica=$oMatch->getGoalsAway()-$oMatch->getGoalsHome();}
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())==0)$W=0.5;		
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getOt()==1){$W=0.5; $raznica=1;}
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getSo()==1){$W=0.5; $raznica=1;}
			if(($oMatch->getGoalsAway()-$oMatch->getGoalsHome())<0 && $oMatch->getOt()==0 && $oMatch->getSo()==0)$W=0;
			
			$newAwayrating = round( ($W + $raznica *0.01 ),2);
			//$newAwayrating = round($oAwayRating->getRating(),2)+$G*$K * ( $W - 1/(pow(10,(-1)*($oAwayRating->getRating()-$oHomeRating->getRating())/400 ) +1));
			
			$oMatch->setHomeNewRating( number_format(round($newHomerating,2),2, '.', '') );
			$oMatch->setAwayNewRating(   number_format(round($newAwayrating,2),2, '.', '') );
			$oMatch->Save();
			
			$oPlayerTournamentHome->setTournamentRating(  number_format( $oPlayerTournamentHome->getTournamentRating() + $newHomerating, 2, '.', '') );	 
			$oPlayerTournamentHome->Save();	
			
			$oPlayerTournamentAway->setTournamentRating(  number_format( $oPlayerTournamentAway->getTournamentRating() + $newAwayrating, 2, '.', '') );	 
			$oPlayerTournamentAway->Save();
		}				
		
    }
	public function CalcPlayerStat($match_id) {
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
		 
		if( ($oMatch->getGametypeId()==3 || $oMatch->getGametypeId()==7 ) && $oMatch->getPlayed()==1 && $oMatch->getTeh()==0){
		
			if($oMatch->getGoalsHome()>$oMatch->getGoalsAway()){
				$winners=$oMatch->getHome();
				$wingoal=$oMatch->getGoalsAway()+1;
			}else{
				$winners=$oMatch->getAway();
				$wingoal=$oMatch->getGoalsHome()+1;
			}
		 
			if($aGoals = $this->PluginVs_Stat_GetMatchgoalItemsByFilter(array(
					'match_id' => $oMatch->getMatchId(),
					//'team_id <>' => $winners,
					'#order' =>array('period'=>'asc', 'minute'=>'asc','secunde'=>'asc'),
					)))
			{
				$goal_w = 0;
				$goal_l = 0;
				$winner_pl = 0;
				$loser_pl = 0;
				$win_goal_author = 0;
				foreach($aGoals as $oGoal){
				
					if( $oGoal->getTeamId() == $winners ){
						$goal_w++;
						if( $wingoal == $goal_w )$win_goal_author = $oGoal->getGoal();
						if( $wingoal == $goal_w ){
							$oGoal->setWining(1); 
						}elseif( $oGoal->getWining() != 0 ){
							$oGoal->setWining(0);												
						} 
						$oGoal->setRaznica( $goal_w - $goal_l - 1);
						
						if( $oGoal->getType()==0 || $oGoal->getType()==2 ){
							$winner_pl++;
						}
					}else{
						$goal_l++;
						 if( $oGoal->getWining() != 0 ){
							$oGoal->setWining(0); 		
						} 
						$oGoal->setRaznica( $goal_l - $goal_w -1 );
						
						if( $oGoal->getType()==0 || $oGoal->getType()==2 ){
							$loser_pl++;
						}
					
					}					
					$oGoal->Save();
				}
				$plus_minus = $winner_pl - $loser_pl;
				
			}
			
			if($aMatchPlayerstat = $this->PluginVs_Stat_GetMatchplayerstatItemsByFilter(array(
					'match_id' => $oMatch->getMatchId(),
					//'team_id <>' => $winners, 
					)))
			{
				foreach($aMatchPlayerstat as $oMatchPlayerstat){
					if( $oMatchPlayerstat->getTeamId() == $winners  && $oMatchPlayerstat->getPosition() !='G'){
						$oMatchPlayerstat->setPlusMinus($plus_minus);
						$oMatchPlayerstat->setShga(0);
					}elseif( $oMatchPlayerstat->getPosition() !='G' ){
						$oMatchPlayerstat->setPlusMinus($plus_minus*(-1));
						$oMatchPlayerstat->setShga(0);				
					}elseif( $oMatchPlayerstat->getPosition() =='G' ){
					
						$oMatchResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id <>' => $oMatchPlayerstat->getTeamId()	));		
								
						$oMatchPlayerstat->setShga($oMatchResult->getShots());					
					}
					if($win_goal_author == $oMatchPlayerstat->getPlayercardId() && $oMatchPlayerstat->getTeamId() == $winners){
						$oMatchPlayerstat->setWinGoal(1); 
					}else{
						$oMatchPlayerstat->setWinGoal(0); 
					}
					$oMatchPlayerstat->Save();
				}
			
			
			}
			
		}
 
		if($oMatch->getGametypeId()==1 || $oMatch->getGametypeId()==4 || $oMatch->getGametypeId()==6 || $oMatch->getGametypeId()==8 || $oMatch->getGametypeId()==9){
			$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($oMatch->getTournamentId());
			
			if(!$this->PluginVs_Stat_GetPlayerstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId(),
					'game_id' => $oMatch->getGameId(),
					'gametype_id' => $oMatch->getGametypeId(),
					'user_id' => $oMatch->getHomePlayer()
					)))
			{
				$this->EventCreatePlayerStatTableByMatchId($match_id);
			}
			if(!$this->PluginVs_Stat_GetPlayerstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId(),
					'game_id' => $oMatch->getGameId(),
					'gametype_id' => $oMatch->getGametypeId(),
					'user_id' => $oMatch->getAwayPlayer()
					)))
			{
				$this->EventCreatePlayerStatTableByMatchId($match_id);
			}
			
			$oHomeResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
					'match_id' => $oMatch->getMatchId(),
					'teamintournament_id' => $oMatch->getHomeTeamtournament()			
					));
			$oAwayResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
					'match_id' => $oMatch->getMatchId(),
					'teamintournament_id' => $oMatch->getAwayTeamtournament()			
					));
					
			if($oHomeStat = $this->PluginVs_Stat_GetPlayerstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId(),
					'teamintournament_id' => $oMatch->getHomeTeamtournament(),
					'user_id' => $oMatch->getHomePlayer()					
					)) ){
				$oHomeStat = $this->CalcDelStat($oHomeResult, $oAwayResult, $oHomeStat, $oMatch, $oTournament, ($oMatch->getGoalsHome()-$oMatch->getGoalsAway()), 1);
						
				$oHomeStat->Save();
			}
			if($oAwayStat = $this->PluginVs_Stat_GetPlayerstatByFilter(array(
					'tournament_id' => $oMatch->getTournamentId(),
					'round_id' => $oMatch->getRoundId(),
					'teamintournament_id' => $oMatch->getAwayTeamtournament(),
					'user_id' => $oMatch->getAwayPlayer()			
					))){
				$oAwayStat = $this->CalcDelStat( $oAwayResult, $oHomeResult, $oAwayStat, $oMatch, $oTournament,($oMatch->getGoalsAway()-$oMatch->getGoalsHome()), 1);
				
				$oAwayStat->Save();
			}
		}
		//$this->CalcPosition($match_id);
	
	}
	public function DeletePlayerStatInMatch($match_id) {
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
		
		$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($oMatch->getTournamentId());
		
		if(!$this->PluginVs_Stat_GetPlayerstatByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),
				'round_id' => $oMatch->getRoundId(),
				'game_id' => $oMatch->getGameId(),
				'gametype_id' => $oMatch->getGametypeId(),
				'user_id' => $oMatch->getHomePlayer()
				)))
		{
			$this->EventCreatePlayerStatTableByMatchId($match_id);
		}
		if(!$this->PluginVs_Stat_GetPlayerstatByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),
				'round_id' => $oMatch->getRoundId(),
				'game_id' => $oMatch->getGameId(),
				'gametype_id' => $oMatch->getGametypeId(),
				'user_id' => $oMatch->getAwayPlayer()
				)))
		{
			$this->EventCreatePlayerStatTableByMatchId($match_id);
		}
		
		$oHomeResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
				'match_id' => $oMatch->getMatchId(),
				'teamintournament_id' => $oMatch->getHomeTeamtournament()			
				));
		$oAwayResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
				'match_id' => $oMatch->getMatchId(),
				'teamintournament_id' => $oMatch->getAwayTeamtournament()			
				));
				
		if( $oHomeStat = $this->PluginVs_Stat_GetPlayerstatByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),
				'round_id' => $oMatch->getRoundId(),
				'teamintournament_id' => $oMatch->getHomeTeamtournament(),
				'user_id' => $oMatch->getHomePlayer()					
				)) ){
				
			$oHomeStat = $this->CalcDelStat($oHomeResult, $oAwayResult, $oHomeStat, $oMatch, $oTournament, ($oMatch->getGoalsHome()-$oMatch->getGoalsAway()), -1);
			
			$oHomeStat->Save();
		}
		if( $oAwayStat = $this->PluginVs_Stat_GetPlayerstatByFilter(array(
				'tournament_id' => $oMatch->getTournamentId(),
				'round_id' => $oMatch->getRoundId(),
				'teamintournament_id' => $oMatch->getAwayTeamtournament(),
				'user_id' => $oMatch->getAwayPlayer()			
				)) ){
			$oAwayStat = $this->CalcDelStat( $oAwayResult, $oHomeResult, $oAwayStat, $oMatch, $oTournament,($oMatch->getGoalsAway()-$oMatch->getGoalsHome()), -1);
				
			$oAwayStat->Save();
		}
		//$this->CalcPosition($match_id);
	
	}
	
	public function EventCreatePlayerStatTableByMatchId($match_id) {
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
		
		$aTournamentStat = $this->PluginVs_Stat_GetPlayerstatItemsByFilter(array(
			'tournament_id' => $oMatch->getTournamentId(),
			'round_id' => $oMatch->getRoundId(),
			'game_id' => $oMatch->getGameId(),
			'gametype_id' => $oMatch->getGametypeId(),
			'user_id' => $oMatch->getAwayPlayer()
		));
		/*foreach($aTournamentStat as $oTournamentStat) {
			$oTournamentStat->delete();
		}*/
		if(!$aTournamentStat)
		{			
			$Stat_add =  Engine::GetEntity('PluginVs_Stat_Playerstat');
			$Stat_add->setTournamentId($oMatch->getTournamentId());
			$Stat_add->setRoundId($oMatch->getRoundId()); 
			$Stat_add->setTeamId($oMatch->getAway());
			$Stat_add->setTeamintournamentId($oMatch->getAwayTeamtournament());
			$Stat_add->setUserId($oMatch->getAwayPlayer());
			$Stat_add->setGameId($oMatch->getGameId());
			$Stat_add->setGametypeId($oMatch->getGametypeId());
			$Stat_add->Add();
		}
		
		$aTournamentStat = $this->PluginVs_Stat_GetPlayerstatItemsByFilter(array(
			'tournament_id' => $oMatch->getTournamentId(),
			'round_id' => $oMatch->getRoundId(),
			'game_id' => $oMatch->getGameId(),
			'gametype_id' => $oMatch->getGametypeId(),
			'user_id' => $oMatch->getHomePlayer()
		));
		/*foreach($aTournamentStat as $oTournamentStat) {
			$oTournamentStat->delete();
		}*/
		if(!$aTournamentStat)
		{			
			$Stat_add =  Engine::GetEntity('PluginVs_Stat_Playerstat');
			$Stat_add->setTournamentId($oMatch->getTournamentId());
			$Stat_add->setRoundId($oMatch->getRoundId()); 
			$Stat_add->setTeamId($oMatch->getHome());
			$Stat_add->setTeamintournamentId($oMatch->getHomeTeamtournament());
			$Stat_add->setUserId($oMatch->getHomePlayer());
			$Stat_add->setGameId($oMatch->getGameId());
			$Stat_add->setGametypeId($oMatch->getGametypeId());
			$Stat_add->Add();
		}
		
	}
	
	public function EventCreateTournamentStatTableByMatchId($match_id) {
		$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
		
		$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($oMatch->getTournamentId());
		
		$aTournamentStat = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
			'tournament_id' => $oMatch->getTournamentId(),
			'teamintournament_id' => $oMatch->getAwayTeamtournament()
		));
		
		if(!$aTournamentStat)
		{	
			$oTeamInTournament = $this->PluginVs_Stat_GetTeamsintournamentById($oMatch->getAwayTeamtournament());
			
			$position = 0;
			$sql="select max(position) as num from tis_stat_tournamentstat where tournament_id='".$oMatch->getTournamentId()."' union select 0 as num";
			if ($aNum=$this->PluginVs_Stat_GetAll($sql)){
				if($aNum[0]['num']>0){
					$position = $aNum[0]['num'] + 1; 
				}
			}
			
			$Stat_add =  Engine::GetEntity('PluginVs_Stat_Tournamentstat');

			$Stat_add->setTournamentId($oTeamInTournament->getTournamentId());
			$Stat_add->setRoundId($oTeamInTournament->getRoundId());
			$Stat_add->setGroupId($oTeamInTournament->getGroupId());
			$Stat_add->setParentgroupId($oTeamInTournament->getParentgroupId());
			if($oTournament->getKnownTeams()==3){
				$Stat_add->setTeamId(0);
			}else{
				$Stat_add->setTeamId($oTeamInTournament->getTeamId());
			}
			$Stat_add->setTeamintournamentId($oTeamInTournament->getId());
			$Stat_add->setPosition($position);
			$Stat_add->Add();		
					
		}
		
		$aTournamentStat = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
			'tournament_id' => $oMatch->getTournamentId(),
			'teamintournament_id' => $oMatch->getHomeTeamtournament()
		));
		
		if(!$aTournamentStat)
		{			
			$oTeamInTournament = $this->PluginVs_Stat_GetTeamsintournamentById($oMatch->getHomeTeamtournament());
			
			$position = 0;
			$sql="select max(position) as num from tis_stat_tournamentstat where tournament_id='".$oMatch->getTournamentId()."' union select 0 as num";
			if ($aNum=$this->PluginVs_Stat_GetAll($sql)){
				if($aNum[0]['num']>0){
					$position = $aNum[0]['num'] + 1; 
				}
			}
			
			$Stat_add =  Engine::GetEntity('PluginVs_Stat_Tournamentstat');

			$Stat_add->setTournamentId($oTeamInTournament->getTournamentId());
			$Stat_add->setRoundId($oTeamInTournament->getRoundId());
			$Stat_add->setGroupId($oTeamInTournament->getGroupId());
			$Stat_add->setParentgroupId($oTeamInTournament->getParentgroupId());
			if($oTournament->getKnownTeams()==3){
				$Stat_add->setTeamId(0);
			}else{
				$Stat_add->setTeamId($oTeamInTournament->getTeamId());
			}
			$Stat_add->setTeamintournamentId($oTeamInTournament->getId());
			$Stat_add->setPosition($position);
			$Stat_add->Add();
		}
		
	}
	
	
	public function EventCreateStatTableByTournamentRound($tournament_id,$round_id) {
		
		$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($tournament_id);
		
		$aTournamentStat = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
			'tournament_id' => $tournament_id,
			'round_id' => $round_id
		));
		/*foreach($aTournamentStat as $oTournamentStat) {
			$oTournamentStat->delete();
		}*/
		if(!$aTournamentStat)
		{
			if($round_id != 100)
			{
				$aTeamInTournament = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
					'tournament_id' => $tournament_id,
					'round_id' => $round_id
				));
				foreach($aTeamInTournament as $oTeamInTournament) {
					$Stat_add =  Engine::GetEntity('PluginVs_Stat_Tournamentstat');
					$Stat_add->setTournamentId($oTeamInTournament->getTournamentId());
					$Stat_add->setRoundId($oTeamInTournament->getRoundId());
					$Stat_add->setGroupId($oTeamInTournament->getGroupId());
					$Stat_add->setParentgroupId($oTeamInTournament->getParentgroupId());
					if($oTournament->getKnownTeams()==3){
						$Stat_add->setTeamId(0);
					}else{
						$Stat_add->setTeamId($oTeamInTournament->getTeamId());
					}
					$Stat_add->setTeamintournamentId($oTeamInTournament->getId());
					$Stat_add->Add();
				}
			}	
			if($round_id == 100)
			{
				$aTeamInTournament = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
					'tournament_id' => $tournament_id
				));
				foreach($aTeamInTournament as $oTeamInTournament) {
					$Stat_add =  Engine::GetEntity('PluginVs_Stat_Tournamentstat');
					$Stat_add->setTournamentId($oTeamInTournament->getTournamentId());
					$Stat_add->setRoundId('100');
					$Stat_add->setGroupId($oTeamInTournament->getGroupId());
					$Stat_add->setParentgroupId($oTeamInTournament->getParentgroupId());
					if($oTournament->getKnownTeams()==3){
						$Stat_add->setTeamId(0);
					}else{
						$Stat_add->setTeamId($oTeamInTournament->getTeamId());
					}					
					$Stat_add->setTeamintournamentId($oTeamInTournament->getId());
					$Stat_add->Add();
				}
			}
		}
	}
	
	
}
?>