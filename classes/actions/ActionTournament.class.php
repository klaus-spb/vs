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

class PluginVs_ActionTournament extends ActionPlugin
{
    /**
     * Главное меню
     */
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
     * Текущий пользователь
     */
    protected $oUserCurrent = null;
    protected $oTournament = null;
    protected $oGame = null;
	protected $myTeam = 0;
	protected $myTeamTournament = 0;
	protected $isAdmin = null;
    
    /**
     * Инициализация
     */
    public function Init()
    {
        $this->SetDefaultEvent('');
        $this->oUserCurrent = $this->User_GetUserCurrent();
        $this->oTournament  = $this->PluginVs_Stat_GetTournamentByUrl(Router::GetActionEvent());
		if(!$this->oTournament) {
			return $this->EventDenied();
		}
		if(!$this->oTournament->getBlog()){ 
			return Router::Action('error');
		}
		if ($this->oTournament->getBlog() && $this->oTournament->getBlog()->getType() == 'close') {
            if (!$this->oUserCurrent || !in_array($this->oTournament->getBlog()->getId(), $this->Blog_GetAccessibleBlogsByUser($this->oUserCurrent))) {
                $this->Message_AddErrorSingle($this->Lang_Get('blog_close_show'), $this->Lang_Get('not_access'));
                return Router::Action('error');
            }
        }
		
		
        if($this->oTournament)$this->oGame = $this->oTournament->getGame();
		
		$this->myTeam = $this->PluginVs_Stat_GetMyTeam($this->oTournament);
		$this->myTeamTournament = $this->PluginVs_Stat_GetMyTeamtournament($this->oTournament);
		
		
		/*if($this->oUserCurrent){
			$oTeamTournament = $this->PluginVs_Stat_GetTeamsintournamentByFilter(array('tournament_id' => $this->oTournament->getTournamentId(),'player_id' => $this->oUserCurrent->getUserId()));
			if($oTeamTournament)$this->myTeamTournament = $oTeamTournament->getId();
		}*/
		
		$this->isAdmin=	$this->PluginVs_Stat_IsTournamentAdmin($this->oTournament);
		
		$this->Viewer_AddWidget('right','tournamentdescription',array('plugin'=>'vs', 'oTournament'=>$this->oTournament),204);	
		$this->Viewer_AddWidget('right','tournamentsheduleloader',array('plugin'=>'vs', 'oTournament'=>$this->oTournament,'myteam'=>$this->myTeam ),203);
		$this->Viewer_AddWidget('right','tournamentteamtable',array('plugin'=>'vs', 'oTournament'=>$this->oTournament),202);
		
		$this->Viewer_Assign('oGame',$this->oGame);
		$this->Viewer_Assign('oTournament',$this->oTournament);
		if($this->oUserCurrent && ($this->oUserCurrent->isAdministrator() || $this->isAdmin))$this->Viewer_Assign('admin','yes');
		$sql="select distinct 1 from tis_stat_playoff where tournament_id=".$this->oTournament->getTournamentId();
		if($this->PluginVs_Stat_GetAll($sql))$this->Viewer_Assign('po',1);
		
		$this->Viewer_AddHtmlTitle($this->oTournament->getName());
    }
    
    /**
     * Регистрация событий
     */
    protected function RegisterEvent()
    {
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^players$/', 'EventPlayers');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^shedule$/', 'EventShedule');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^rules$/', 'EventRules');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^events$/', 'EventEvents');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^admin$/', 'EventAdmin');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^stats$/', 'EventStats');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^po/', 'EventPo');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^stats_sh$/', 'EventStatsSh');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^player_stats$/', 'EventPlayerStats');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^match_comment$/', 'EventMatchComment');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^match_insert$/', 'EventMatchInsert');
		$this->AddEventPreg('/^[\w\-\_]+$/i', '/^match/', 'EventMatch');
        $this->AddEventPreg('/^[\w\-\_]+$/i', 'EventMainPageTournament');
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^[\w\-\_]+$/i', 'EventMainPageTournament');
    }
	protected function EventMatch()
	{
		$this->Viewer_AddHtmlTitle('Match');
		$this->SetTemplateAction('tournament_match');
		if (func_check($this->GetParam(1),'id',1,7))
		{ 
			$match_id = $this->GetParam(1);
		}else{
			return $this->EventDeniedMatch('');
		}
		if (!$this->User_IsAuthorization()) {
            return $this->EventDeniedNotRegister();
        }
		$oMatch=$this->PluginVs_Stat_GetMatchesByFilter(array(
			'match_id' => $match_id,	
			'#with'         => array('hometeam','awayteam')
		)); 
		if($oMatch && ($this->myTeamTournament==0 || ( $oMatch->getHomeTeamtournament()!=$this->myTeamTournament && $oMatch->getAwayTeamtournament()!=$this->myTeamTournament)) && !($this->oUserCurrent->isAdministrator() || $this->isAdmin))return $this->EventDeny('Вход запрещен','Вы не владелец команды. <a href="javascript:history.go(-1)">Вернитесь назад</a>');
				
		$this->Viewer_Assign('oMatch',$oMatch);	
		$this->Viewer_Assign('myteam',$this->myTeam);	
		
		$aMatchtime=$this->PluginVs_Stat_GetMatchtimeItemsByFilter(array(
			'match_id' => $match_id,
			//'#where' => array('(team_id = (?d) or team2_id = (?d) )' => array($myteam, $myteam)),							
			'#with'         => array('user1','user2')
		));
		$this->Viewer_Assign('aMatchtime',$aMatchtime);
		$this->Viewer_Assign('oUser',$this->oUserCurrent);
		
		$before = strtotime($oMatch->getDates());
		$later = strtotime($oMatch->getDates());
		$before = strtotime('-2 day',$before);
		$later = strtotime('+2 day',$later);
		
		$this->Viewer_Assign('before',$before);	
		$this->Viewer_Assign('later',$later);
	}
  protected function EventMatchInsert()
   {
		$this->Viewer_AddHtmlTitle('Insert match result');
		$this->sMenuSubItemSelect = "shedule";
		
		
		
		//echo getRequest('pp',0,'post');
		
		if (func_check($this->GetParam(1),'id',1,7))
		{ 
			$match_id = $this->GetParam(1);
		}else{
			return $this->EventDeniedMatch('');
		}
		if (!$this->User_IsAuthorization()) {
            return $this->EventDeniedNotRegister();
        }
		$oMatch=$this->PluginVs_Stat_GetMatchesByMatchId( $match_id );
		$this->Viewer_Assign('oMatch',$oMatch);
		
		if($oMatch->getGametypeId()==8 ){
			$this->SetTemplateAction('tournament_match_insert_mma');
		}else{
			$this->SetTemplateAction('tournament_match_insert');
		}
		
		if ($this->isAdmin || $this->oUserCurrent->isAdministrator()) 	
		{
			$isAdmin=1; 
		}else{
			$isAdmin=0;
		}				
			
		$test=0;
		if (func_check($this->GetParam(2),'id',1,7))
		{ 
			if ($isAdmin) {		
				$teamtournament_result = $this->GetParam(2);					
			}else{
				return $this->EventDenied();
			}				
		}else{
			$teamtournament_result=$this->myTeamTournament;
		}
			
		
		
		$oTeaminTournament = $this->PluginVs_Stat_GetTeamsintournamentById($teamtournament_result);
		$team_result=$oTeaminTournament->getTeamId();
		
		$this->Viewer_Assign('oTeaminTournament',$oTeaminTournament);
		
		if($oMatch->getGametypeId()==8 ){
		
			if(getRequest('submit',null,'post')){
				foreach($_POST as $key=>$value) {
					if(($key<>'comment')&&($key<>'submit')){
						if($_POST[$key]<>''){
							if(!is_numeric($_POST[$key])){$test=$test+1;}			   
						}else{
							$_POST[$key]=0;
						}			   
				   }
				} 
				if($test>0)Router::Location($this->oTournament->getUrlFull()."/shedule/");
								
												
				


				
				/*------------------------------------------------------------------------------*/
				$comment="";
				$team_id=0;
				$result=0;
				$issue=0;
				$period=0;
				
				
				if (func_check(getRequest('team_id',null,'post'),'id',1,11))$team_id=getRequest('team_id',null,'post');
				if (func_check(getRequest('result',null,'post'),'id',1,11))$result=getRequest('result',null,'post');
				if (func_check(getRequest('issue',null,'post'),'id',1,11))$issue=getRequest('issue',null,'post');
				if (func_check(getRequest('period',null,'post'),'id',1,11))$period=getRequest('period',null,'post');
				if (func_check(getRequest('knockdowns',null,'post'),'id',1,11))$knockdowns=getRequest('knockdowns',null,'post');
				if (func_check(getRequest('sig_strikes',null,'post'),'id',1,11))$sig_strikes=getRequest('sig_strikes',null,'post');
				if (func_check(getRequest('sig_strikes_at',null,'post'),'id',1,11))$sig_strikes_at=getRequest('sig_strikes_at',null,'post');
				if (func_check(getRequest('total_strikes',null,'post'),'id',1,11))$total_strikes=getRequest('total_strikes',null,'post');
				if (func_check(getRequest('total_strikes_at',null,'post'),'id',1,11))$total_strikes_at=getRequest('total_strikes_at',null,'post');
				if (func_check(getRequest('takedowns',null,'post'),'id',1,11))$takedowns=getRequest('takedowns',null,'post');
				if (func_check(getRequest('takedowns_at',null,'post'),'id',1,11))$takedowns_at=getRequest('takedowns_at',null,'post');
				if (func_check(getRequest('submission_at',null,'post'),'id',1,11))$submission_at=getRequest('submission_at',null,'post');
				if (func_check(getRequest('ground',null,'post'),'id',1,11))$ground=getRequest('ground',null,'post');
								
				if (func_check(getRequest('comment',null,'post'),'text',1,3000))$comment=getRequest('comment',null,'post');
				
				if($result==0){
					$away_goals = 2;
					$home_goals = 0;
				}elseif($result==1){
					$away_goals = 1;
					$home_goals = 1;
				}elseif($result==2){
					$away_goals = 0;
					$home_goals = 2;
				}
				if($issue == 0){$ko=1;}else{$ko=0;}
				if($issue == 1){$tehko=1;}else{$tehko=0;}
				if($issue == 2){$submission=1;}else{$submission=0;}
				if($issue == 3){$decision=1;}else{$decision=0;}
				if($issue == 4){$disqualification=1;}else{$disqualification=0;}
				
				$good=1;
				if( ($away_goals + $home_goals) != 2)$good=0;

				if($oMatch->getPlayed()==1){			
					$this->PluginVs_Stat_DeleteStat($match_id);
					$oMatch->setPlayed(0);
					$oMatch->Save();
				}
				
				if ($oMatchResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $teamtournament_result			
					)) ){
					$oMatchResult->Delete();
				}
				
				if($good==1){		
					
					$user_id = $oTeaminTournament->getPlayerId();

					$oMatchResult_add =  Engine::GetEntity('PluginVs_Stat_Matchresult');
					$oMatchResult_add->setMatchId($match_id);
					$oMatchResult_add->setUserId($user_id);
					$oMatchResult_add->setTeamId($team_id);
					$oMatchResult_add->setTeamintournamentId($teamtournament_result);
					$oMatchResult_add->setAway($away_goals);
					$oMatchResult_add->setHome($home_goals);
					$oMatchResult_add->setComment($this->Text_Parser($comment));
					$oMatchResult_add->setDates(date("Y-m-d H:i:s"));
					
					
					$oMatchResult_add->setKo($ko);
					$oMatchResult_add->setTehko($tehko);
					$oMatchResult_add->setSubmission($submission);
					$oMatchResult_add->setDecision($decision);
					$oMatchResult_add->setDisqualification($disqualification);
					
					
					$oMatchResult_add->setPeriod($period);
					$oMatchResult_add->setKnockdowns($knockdowns);
					$oMatchResult_add->setSigStrikes($sig_strikes);
					$oMatchResult_add->setSigStrikesAt($sig_strikes_at);
					$oMatchResult_add->setTotalStrikes($total_strikes);
					$oMatchResult_add->setTotalStrikesAt($total_strikes_at);
					$oMatchResult_add->setTakedowns($takedowns);
					$oMatchResult_add->setTakedownsAt($takedowns_at);
					$oMatchResult_add->setSubmissionAt($submission_at);
					$oMatchResult_add->setGround($ground);
					
					
					//if(isset($zhaloba))$oMatchResult_add->setHome($zhaloba);
				/*	
					$oMatchResult_add->setStar1(getRequest('star1',-1,'post'));
					$oMatchResult_add->setStar2(getRequest('star2',-1,'post'));
					$oMatchResult_add->setStar3(getRequest('star3',-1,'post'));
					
					$oMatchResult_add->setMinuteAt(getRequest('minute_at',0,'post'));
					$oMatchResult_add->setSecundeAt(getRequest('secunde_at',0,'post'));
					
					$oMatchResult_add->setPp(getRequest('pp',0,'post'));
					$oMatchResult_add->setPowerplayRealize(getRequest('pp_r',0,'post'));
					$oMatchResult_add->setPk(getRequest('pk',0,'post'));
					$oMatchResult_add->setFaceoffWin(getRequest('faceoff_win',0,'post'));
					$oMatchResult_add->setPassPrc(getRequest('pass_prc',0,'post'));
				*/
					//$oMatchResult_add->setShots(getRequest('shots',null,'post'));
					//$oMatchResult_add->setPenalty(getRequest('penalties',null,'post'));
						
					
					if($teamtournament_result!=0){
						if($oMatch->getHomeTeamtournament()==$teamtournament_result){
							$oMatch->setHomeInsert(1);
							$oMatch->setHome($team_id);
							$oMatch->Save();
						}
						if($oMatch->getAwayTeamtournament()==$teamtournament_result){
							$oMatch->setAwayInsert(1);
							$oMatch->setAway($team_id);
							$oMatch->Save();
						}
					} 
					
					$oMatchResult_add->Add();		
					$this->PluginVs_Stat_CheckResult($match_id);

					Router::Location($this->oTournament->getUrlFull()."shedule");
					 
				}
	/*-------------------------------------------------------------------------------------*/			
			}
		
		/* */
		$sql="select distinct lt.team_id from tis_stat_leagueteams lt, tis_stat_tournament t where t.league_id=lt.league_id and t.tournament_id=".$this->oTournament->getTournamentId();
		$aLeagueTeams=$this->PluginVs_Stat_GetAll($sql); 
		foreach($aLeagueTeams as $oLeagueTeam){
			$teams[] = $oLeagueTeam['team_id'];					
		}
		/* */
		if($this->oTournament->getLeagueId()!=0){				
				$aTeams=$this->PluginVs_Stat_GetTeamItemsByFilter(array(
							'sport_id' => $this->oTournament->getGame()->getSportId(),							
							//'league_id' => $this->oTournament->getLeagueId(),
							'team_id in ' =>$teams,
							//'#with'         => array('league'),
							'#order'         => array("name"=>"asc") 						
						));
			}else{
				$aTeams=$this->PluginVs_Stat_GetTeamItemsByFilter(array(
							'sport_id' => $this->oTournament->getGame()->getSportId(),
							'#with'         => array('league'),
							'#order'         => array("league_id"=>"asc","name"=>"asc") 						
						));			
			}
			$this->Viewer_Assign('aTeams',$aTeams);
			
			if ($oMatchResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
							'match_id' => $oMatch->getMatchId(),
							'teamintournament_id' => $teamtournament_result	
				)) ){					
				$this->Viewer_Assign('oMatchResult',$oMatchResult);
			}
			$this->Viewer_Assign('team_result',$team_result);
			$this->Viewer_Assign('teamtournament_result',$teamtournament_result);
		}
		if($oMatch->getGametypeId()==3){
			/*		
			if ($this->isAdmin || $this->oUserCurrent->isAdministrator()) 	
			{
				$isAdmin=1; 
			}else{
				$isAdmin=0;
			}
				
				
			$test=0;
			if (func_check($this->GetParam(2),'id',1,7))
			{ 
				if ($isAdmin) {		
					$team_result = $this->GetParam(2);					
				}else{
					return $this->EventDenied();
				}				
			}else{
				$team_result=$this->myTeam;
			}
			*/
			if(getRequest('submit',null,'post')){
				foreach($_POST as $key=>$value) {
					if(($key<>'comment')&&($key<>'submit')){
						if($_POST[$key]<>''){
							if(!is_numeric($_POST[$key])){$test=$test+1;}			   
						}else{
							$_POST[$key]=0;
						}			   
				   }
				} 
				if($test>0)Router::Location($this->oTournament->getUrlFull()."/shedule/");
								
				
				if ($isAdmin) {		
					//if(getRequest('team_id',null,'post') != 0)$team_result=getRequest('team_id',null,'post');					
				}
				
				if($oMatch->getPlayed()==1){			
					$this->PluginVs_Stat_DeleteStat($match_id);
					$oMatch->setPlayed(0);
					$oMatch->Save();
				}
				
				if ($oMatchResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $teamtournament_result			
					)) ){
					$oMatchResult->Delete();
				}
				
				if($aMatchplayerstat = $this->PluginVs_Stat_GetMatchplayerstatItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $teamtournament_result			
					)) ){
					foreach($aMatchplayerstat as $oMatchplayerstat){
						$oMatchplayerstat->Delete();
					}			
				}
				if($aMatchgoal = $this->PluginVs_Stat_GetMatchgoalItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $teamtournament_result			
					)) ){
					foreach($aMatchgoal as $oMatchgoal){
						$oMatchgoal->Delete();
					}			
				}
				
				/*------------------------------------------------------------------------------*/
				$comment="";
				//if (func_check(getRequest('match_id',null,'post'),'id',1,11))$match_id=getRequest('match_id',null,'post');
				$ot=0;
				$so=0;
				if (func_check(getRequest('inputaway_teamplay',null,'post'),'id',1,11))$away_goals=getRequest('inputaway_teamplay',null,'post');
				if (func_check(getRequest('inputhome_teamplay',null,'post'),'id',1,11))$home_goals=getRequest('inputhome_teamplay',null,'post');
				if (func_check(getRequest('ot_teamplay',0,'post'),'id',1,2))$ot=getRequest('ot_teamplay',0,'post');
				if (func_check(getRequest('so_teamplay',0,'post'),'id',1,2))$so=getRequest('so_teamplay',0,'post');
				//if (func_check(getRequest('team_id',null,'post'),'id',1,11))$team_id=getRequest('team_id',null,'post');//prava dodelat
				if (func_check(getRequest('user_id',null,'post'),'id',1,11))$user_id=getRequest('user_id',null,'post');
				if (func_check(getRequest('zhaloba',null,'post'),'id',1,2))$zhaloba=getRequest('zhaloba',null,'post');
				if (func_check(getRequest('comment',null,'post'),'text',1,3000))$comment=getRequest('comment',null,'post');
				
				$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
				
				$good=1;
				if($ot!=0 && $so!=0)$good=0;
				if(($ot!=0 || $so!=0) && abs($away_goals-$home_goals)!=1)$good=0;
				If( $oMatch->getMiniturnirId()!=0 && abs($away_goals-$home_goals)==0)$good=2;
				
					
				if($good==1){		
						
					if ($isAdmin) {								
						$Playert = $this->PluginVs_Stat_GetPlayertournamentByFilter(array(
								'tournament_id' => $oMatch->getTournamentId(),
								'teamintournament_id' => $teamtournament_result,
								'cap' => '2'
 						));
						$user_id = $Playert->getUserId(); 
					}else{
						$user_id = $this->oUserCurrent->GetUserId();
					}
					$oMatchResult_add =  Engine::GetEntity('PluginVs_Stat_Matchresult');
					$oMatchResult_add->setMatchId($match_id);
					$oMatchResult_add->setUserId($user_id);
					$oMatchResult_add->setTeamId($team_result);
					$oMatchResult_add->setTeamintournamentId($teamtournament_result);
					$oMatchResult_add->setAway($away_goals);
					$oMatchResult_add->setHome($home_goals);
					$oMatchResult_add->setComment($this->Text_Parser($comment));
					$oMatchResult_add->setDates(date("Y-m-d H:i:s"));
					if(isset($ot))$oMatchResult_add->setOt($ot);
					if(isset($so))$oMatchResult_add->setSo($so);
					//if(isset($zhaloba))$oMatchResult_add->setHome($zhaloba);
					
					$oMatchResult_add->setStar1(getRequest('star1',-1,'post'));
					$oMatchResult_add->setStar2(getRequest('star2',-1,'post'));
					$oMatchResult_add->setStar3(getRequest('star3',-1,'post'));
					
					$oMatchResult_add->setMinuteAt(getRequest('minute_at',0,'post'));
					$oMatchResult_add->setSecundeAt(getRequest('secunde_at',0,'post'));
					
					$oMatchResult_add->setPp(getRequest('pp',0,'post'));
					$oMatchResult_add->setPowerplayRealize(getRequest('pp_r',0,'post'));
					$oMatchResult_add->setPk(getRequest('pk',0,'post'));
					$oMatchResult_add->setFaceoffWin(getRequest('faceoff_win',0,'post'));
					$oMatchResult_add->setPassPrc(getRequest('pass_prc',0,'post'));
					//$oMatchResult_add->setShots(getRequest('shots',null,'post'));
					//$oMatchResult_add->setPenalty(getRequest('penalties',null,'post'));
					
					
					
					if($teamtournament_result!=0){
						if($oMatch->getHomeTeamtournament()==$teamtournament_result){
							$oMatch->setHomeInsert(1);
							$oMatch->Save();
						}
						if($oMatch->getAwayTeamtournament()==$teamtournament_result){
							$oMatch->setAwayInsert(1);
							$oMatch->Save();
						}
					}elseif($user_id!=0){
						if($oMatch->getHomePlayer()==$user_id){
							$oMatch->setHomeInsert(1);
							$oMatch->Save();
						}
						if($oMatch->getAwayPlayer()==$user_id){
							$oMatch->setAwayInsert(1);
							$oMatch->Save();
						}
					
					}
					
					$ibp=0;
					if(getRequest('id',null,'post')==0)$ibp=1;
					$ppg=0;
					$pkg=0;	
					$shots=0;
					$hits=0;
					$penalties=0;
					$pp_g=0;
					$pk_g=0;
					$rs_g=0;
					$e_net=0;
					$bullits=0;



					for ( $k=1; $k<=7; $k++) { 
						$goal_list[$k]=0;
						$assist_list[$k]=0;
						$rs_list[$k]=0;
						$pp_list[$k]=0;
						$pk_list[$k]=0;
						$bullit_list[$k]=0;
						$e_net_list[$k]=0;
						$star1[$k]=0;
						$star2[$k]=0;
						$star3[$k]=0;
						$win_goal[$k]=0;
					}
					for ( $k=1; $k<=7; $k++) { 
						if($k==1)$player='LW';
						if($k==2)$player='C';
						if($k==3)$player='RW';
						if($k==4)$player='LD';
						if($k==5)$player='RD';
						if($k==6)$player='Bot';
						if($k==7)$player='G';

						if($_POST[$player]==$_POST['star1']) {$star1[$k]=1;}else{$star1[$k]=0;}
						if($_POST[$player]==$_POST['star2']){$star2[$k]=1;}else{$star2[$k]=0;}
						if($_POST[$player]==$_POST['star3']){$star3[$k]=1;}else{$star3[$k]=0;}
					}

					if(getRequest('id',null,'post')>=0){



						for ( $i=1; $i<=$_POST['id']; $i++) { 
						
							if(getRequest('PSH'.$i,null,'post') ==1){
								$PSH=1;
							}else{
								$PSH=0;
							}
							$period = getRequest('period'.$i,null,'post');
							if($ot==0){ 
								if($period==4){
									$period=3;
								}
							}
							if(getRequest('sostav'.$i,null,'post')==1)$ppg=$ppg+1;
							if(getRequest('sostav'.$i,null,'post')==2)$pkg=$pkg+1;
							


							for ( $k=1; $k<=7; $k++) { 
								if($k==1)$player='LW';
								if($k==2)$player='C';
								if($k==3)$player='RW';
								if($k==4)$player='LD';
								if($k==5)$player='RD';
								if($k==6)$player='Bot';
								if($k==7)$player='G';
 
								if($_POST[$player]==getRequest('goal'.$i,null,'post')) $goal_list[$k]=$goal_list[$k]+1;
								if($_POST[$player]==getRequest('assist_'.$i,null,'post')) $assist_list[$k]=$assist_list[$k]+1;
								if($_POST[$player]==getRequest('assist__'.$i,null,'post')) $assist_list[$k]=$assist_list[$k]+1;
								if($_POST[$player]==getRequest('goal'.$i,null,'post') && getRequest('sostav'.$i,null,'post')==0) $rs_list[$k]=$rs_list[$k]+1;
								if($_POST[$player]==getRequest('goal'.$i,null,'post') && getRequest('sostav'.$i,null,'post')==1) $pp_list[$k]=$pp_list[$k]+1;
								if($_POST[$player]==getRequest('goal'.$i,null,'post') && getRequest('sostav'.$i,null,'post')==2) $pk_list[$k]=$pk_list[$k]+1;
								if($_POST[$player]==getRequest('goal'.$i,null,'post') && getRequest('sostav'.$i,null,'post')==3) $bullit_list[$k]=$bullit_list[$k]+1;
								if($_POST[$player]==getRequest('goal'.$i,null,'post') && $PSH==1) $e_net_list[$k]=$e_net_list[$k]+1;
								/*if($oMatch->getAway()==$team_result){
									if( $_POST[$player]==getRequest('goal'.$i,null,'post') && ($i-1)==($_POST['inputhome_teamplay']-1) ){$win_goal[$k]=$win_goal[$k]+1;}
								
								}
								if($oMatch->getHome()==$team_result){
									if($_POST[$player]==getRequest('goal'.$i,null,'post') && $_POST['inputhome_teamplay']>$_POST['inputaway_teamplay'] && ($i-1)==$_POST['inputhome_teamplay']){$win_goal[$k]=$win_goal[$k]+1;}
								
								}*/
							//if($_POST[$player]==getRequest('goal'.$i,null,'post') && $_POST['number']>$_POST['number2'] && ($i-1)==$_POST['number2']){$win_goal[$k]=$win_goal[$k]+1;}
							}	
							$oMatchgoal_add =  Engine::GetEntity('PluginVs_Stat_Matchgoal');
							$oMatchgoal_add->setMatchId($match_id);
							$oMatchgoal_add->setTeamId($team_result);
							$oMatchgoal_add->setTeamintournamentId($teamtournament_result);
							$oMatchgoal_add->setPeriod($period);
							$oMatchgoal_add->setMinute(getRequest('minute'.$i,null,'post'));
							$oMatchgoal_add->setSecunde(getRequest('secunde'.$i,null,'post'));
							$oMatchgoal_add->setGoal(getRequest('goal'.$i,null,'post'));
							$oMatchgoal_add->setAssist(getRequest('assist_'.$i,null,'post'));
							$oMatchgoal_add->setAssist2(getRequest('assist__'.$i,null,'post'));
							$oMatchgoal_add->setType(getRequest('sostav'.$i,null,'post'));
							$oMatchgoal_add->setEmptyNet($PSH); 
							$oMatchgoal_add->Add();
						}	
							
							
						for ( $i=1; $i<=7; $i++) { 
							if($i==1)$player='LW';
							if($i==2)$player='C';
							if($i==3)$player='RW';
							if($i==4)$player='LD';
							if($i==5)$player='RD';
							if($i==6)$player='Bot';
							if($i==7)$player='G';
							
							$oMatchplayerstat_add =  Engine::GetEntity('PluginVs_Stat_Matchplayerstat');
							$oMatchplayerstat_add->setMatchId($match_id);
							$oMatchplayerstat_add->setTeamId($team_result);
							$oMatchplayerstat_add->setTeamintournamentId($teamtournament_result);
							$oMatchplayerstat_add->setPlayercardId(getRequest($player,null,'post'));
							$oMatchplayerstat_add->setPosition($player);
							$oMatchplayerstat_add->setShots(getRequest('shots'.$i,null,'post'));
							$oMatchplayerstat_add->setPenalty(getRequest('penalty'.$i,null,'post'));
							$oMatchplayerstat_add->setHits(getRequest('hits'.$i,null,'post'));
							$oMatchplayerstat_add->setGoals($goal_list[$i]);
							$oMatchplayerstat_add->setAssists($assist_list[$i]);
							$oMatchplayerstat_add->setRs($rs_list[$i]);
							$oMatchplayerstat_add->setPp($pp_list[$i]);
							$oMatchplayerstat_add->setPk($pk_list[$i]);
							$oMatchplayerstat_add->setBullit($bullit_list[$i]);
							$oMatchplayerstat_add->setEmptyNet($e_net_list[$i]);
							$oMatchplayerstat_add->setStar1($star1[$i]);
							$oMatchplayerstat_add->setStar2($star2[$i]);
							$oMatchplayerstat_add->setStar3($star3[$i]);
							$oMatchplayerstat_add->setWinGoal($win_goal[$i]);
							$oMatchplayerstat_add->Add();	
							
							$shots=$shots+getRequest('shots'.$i,null,'post');
							$hits=$hits+getRequest('hits'.$i,null,'post');
							$penalties=$penalties+getRequest('penalty'.$i,null,'post');
							$rs_g=$rs_g+$rs_list[$i];
							$pp_g=$pp_g+$pp_list[$i];
							$pk_g=$pk_g+$pk_list[$i];
							$e_net=$e_net+$e_net_list[$i];
							$bullits=$bullits+$bullit_list[$i];
						}
						
						
						
						 

					}
					$oMatchResult_add->setShots($shots);
					$oMatchResult_add->setPenalty($penalties);
					$oMatchResult_add->setHits($hits);
					
					$oMatchResult_add->setPpg($pp_g);
					$oMatchResult_add->setPkg($pk_g);
					$oMatchResult_add->setRsg($rs_g);
					$oMatchResult_add->setEmptyNet($e_net);
					$oMatchResult_add->setBullits($bullits);
					
					//$oMatchResult_add->Save();
					$oMatchResult_add->Add();
					//$oMatchResult_add->setPenalty(getRequest('penalties',null,'post'));
					//$plugins=new PluginVs_ActionAjax($this->oEngine,'Ajax');			
					$this->PluginVs_Stat_CheckResult($match_id);
					
					
					//if($oMatch->getMiniturnirId()!=0 && $oMatch->getPlayed()==1){
					//	$this->ActionAjax_CheckMiniTurnir($match_id); 
					//}

					Router::Location($this->oTournament->getUrlFull()."shedule");
					 
				}
	/*-------------------------------------------------------------------------------------*/			
			}
			
			if($oMatchResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $teamtournament_result			
					)) ){
				//if(!$isAdmin)return $this->EventDenied();
			}
			
			
			//$this->oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($oMatch->getTournamentId());				
			$oPlayercard=$this->PluginVs_Stat_GetPlayercardByFilter(array(
						'user_id' => $this->oUserCurrent->GetUserId(),
						'sport_id' => $this->oTournament->getGame()->getSportId(),
						'platform_id' => $this->oTournament->getGame()->getPlatformId()							
					));
			if($oPlayercard)
			if($oPlayertournament=$this->PluginVs_Stat_GetPlayertournamentByFilter(array(
						'playercard_id' => $oPlayercard->getPlayercardId(), 
						'tournament_id' => $this->oTournament->getTournamentId(),
						'cap in' => array('1','2')
					)) )
			{ 
					$sql="select pt.playercard_id, pc.family from tis_stat_playertournament pt , tis_stat_playercard pc where pt.tournament_id='".$oMatch->getTournamentId()."' and pt.team_id = '".$oPlayertournament->getTeamId()."' 
												and pt.playercard_id = pc.playercard_id order by family";
					$aPlayers=$this->PluginVs_Stat_GetAll($sql);
					$players=array();
					if($aPlayers){
						foreach($aPlayers as $oPlayers){
							$players[]=$oPlayers['playercard_id'];
						}
						$sort_text = implode(",", $players);
						$aPlayercards=$this->PluginVs_Stat_GetPlayercardItemsByFilter(array(
							'playercard_id in' => $players,
							'#with'         => array('user'),
							'#order'         => array("FIELD(playercard_id,".$sort_text.")") 						
						));
						$this->Viewer_Assign('aPlayercards',$aPlayercards);
					}	
				 
			}
				if ($this->isAdmin || $this->oUserCurrent->isAdministrator()) {		
				 
					//$sql="select playercard_id from tis_stat_playertournament where tournament_id='".$oMatch->getTournamentId()."' and team_id = '".$team_result."'";
					$sql="select pt.playercard_id, pc.family from tis_stat_playertournament pt , tis_stat_playercard pc where pt.tournament_id='".$oMatch->getTournamentId()."' and pt.teamintournament_id = '".$teamtournament_result."' 
												and pt.playercard_id = pc.playercard_id order by family";
					$aPlayers=$this->PluginVs_Stat_GetAll($sql);
					
					$players=array();
					if($aPlayers){
						foreach($aPlayers as $oPlayers){
							$players[]=$oPlayers['playercard_id'];
						}
						$sort_text = implode(",", $players);
						$aPlayercards=$this->PluginVs_Stat_GetPlayercardItemsByFilter(array(
							'playercard_id in' => $players,
							'#with'         => array('user')	,
						'#order'         => array("FIELD(playercard_id,".$sort_text.")") 	
						));
						$this->Viewer_Assign('aPlayercards',$aPlayercards);
					
					}
						
				}			
				
				
				$this->Viewer_Assign('positions',Config::Get('plugin.vs.teamplay_nhl'));  
				$this->Viewer_Assign('oMatch',$oMatch); 
				
				if ($oMatchResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $teamtournament_result			
					)) ){
					
					$aMatchplayerstat = $this->PluginVs_Stat_GetMatchplayerstatItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $teamtournament_result			
					));
					$aMatchgoal = $this->PluginVs_Stat_GetMatchgoalItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $teamtournament_result			
					));
					
					$this->Viewer_Assign('oMatchResult',$oMatchResult);
					
					$this->Viewer_Assign('aMatchplayerstat',$aMatchplayerstat);
					$this->Viewer_Assign('aMatchgoal',$aMatchgoal);
				}
				//$sTextResult=$oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__)."match_teamplay_hockey.tpl");
				//$this->Viewer_AssignAjax('Teamplay',$sTextResult);
				$this->Viewer_Assign('team_result',$team_result);
				$this->Viewer_Assign('teamtournament_result',$teamtournament_result);
				
			
		
			
		}
		if($oMatch->getGametypeId()==7){

			
			if(getRequest('submit',null,'post')){
				foreach($_POST as $key=>$value) {
					if(($key<>'comment')&&($key<>'submit')){
						if($_POST[$key]<>''){
							if(!is_numeric($_POST[$key])){$test=$test+1;}			   
						}else{
							$_POST[$key]=0;
						}			   
				   }
				} 
				if($test>0)Router::Location($this->oTournament->getUrlFull()."shedule");
								
				
				if ($isAdmin) {		
					if(getRequest('team_id',null,'post') != 0)$team_result=getRequest('team_id',null,'post');					
				}
				
				if ($oMatchResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $team_result			
					)) ){
					$oMatchResult->Delete();
				}
				
				if($aMatchplayerstat = $this->PluginVs_Stat_GetMatchplayerstatItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $team_result			
					)) ){
					foreach($aMatchplayerstat as $oMatchplayerstat){
						$oMatchplayerstat->Delete();
					}			
				}
				if($aMatchgoal = $this->PluginVs_Stat_GetMatchgoalItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $team_result			
					)) ){
					foreach($aMatchgoal as $oMatchgoal){
						$oMatchgoal->Delete();
					}			
				}
				
				/*------------------------------------------------------------------------------*/
				$comment="";
				//if (func_check(getRequest('match_id',null,'post'),'id',1,11))$match_id=getRequest('match_id',null,'post');
				$ot=0;
				$so=0;
				if (func_check(getRequest('inputaway_teamplay',null,'post'),'id',1,11))$away_goals=getRequest('inputaway_teamplay',null,'post');
				if (func_check(getRequest('inputhome_teamplay',null,'post'),'id',1,11))$home_goals=getRequest('inputhome_teamplay',null,'post');
				if (func_check(getRequest('ot_teamplay',0,'post'),'id',1,2))$ot=getRequest('ot_teamplay',0,'post');
				if (func_check(getRequest('so_teamplay',0,'post'),'id',1,2))$so=getRequest('so_teamplay',0,'post');
				if (func_check(getRequest('user_id',null,'post'),'id',1,11))$user_id=getRequest('user_id',null,'post');
				if (func_check(getRequest('zhaloba',null,'post'),'id',1,2))$zhaloba=getRequest('zhaloba',null,'post');
				if (func_check(getRequest('comment',null,'post'),'text',1,3000))$comment=getRequest('comment',null,'post');
				
				$oMatch = $this->PluginVs_Stat_GetMatchesByMatchId($match_id);
				
				$good=1;
				if($ot!=0 && $so!=0)$good=0;
				if(($ot!=0 || $so!=0) && abs($away_goals-$home_goals)!=1)$good=0;
				If( $oMatch->getMiniturnirId()!=0 && abs($away_goals-$home_goals)==0)$good=2;
				
				if($oMatch->getPlayed()==1){
					//$plugins=new PluginVs_ActionAjax($this->oEngine,'Ajax');			
					$this->PluginVs_Stat_DeleteStat($match_id);
					$oMatch->setPlayed(0);
					$oMatch->Save();
				}	
				if($good==1){		
						
					if ($isAdmin) {								
						$Playert = $this->PluginVs_Stat_GetTeamsintournamentByFilter(array(
								'tournament_id' => $oMatch->getTournamentId(),
								'team_id' => $team_result
 						));
						$user_id = $Playert->getPlayerId(); 
					}else{
						$user_id = $this->oUserCurrent->GetUserId();
					}
					$oMatchResult_add =  Engine::GetEntity('PluginVs_Stat_Matchresult');
					$oMatchResult_add->setMatchId($match_id);
					$oMatchResult_add->setUserId($user_id);
					$oMatchResult_add->setTeamId($team_result);
					$oMatchResult_add->setAway($away_goals);
					$oMatchResult_add->setHome($home_goals);
					$oMatchResult_add->setComment($this->Text_Parser($comment));
					$oMatchResult_add->setDates(date("Y-m-d H:i:s"));
					if(isset($ot))$oMatchResult_add->setOt($ot);
					if(isset($so))$oMatchResult_add->setSo($so);
					//if(isset($zhaloba))$oMatchResult_add->setHome($zhaloba);
					
					$oMatchResult_add->setStar1(getRequest('star1',-1,'post'));
					$oMatchResult_add->setStar2(getRequest('star2',-1,'post'));
					$oMatchResult_add->setStar3(getRequest('star3',-1,'post'));
					
					$oMatchResult_add->setMinuteAt(getRequest('minute_at',0,'post'));
					$oMatchResult_add->setSecundeAt(getRequest('secunde_at',0,'post'));
					
					$oMatchResult_add->setPp(getRequest('pp',0,'post'));
					$oMatchResult_add->setPowerplayRealize(getRequest('pp_r',0,'post'));
					$oMatchResult_add->setPk(getRequest('pk',0,'post'));
					$oMatchResult_add->setFaceoffWin(getRequest('faceoff_win',0,'post'));
					$oMatchResult_add->setPassPrc(getRequest('pass_prc',0,'post')); 
					
					
					if($team_result!=0){
						if($oMatch->getHome()==$team_result){
							$oMatch->setHomeInsert(1);
							$oMatch->Save();
						}
						if($oMatch->getAway()==$team_result){
							$oMatch->setAwayInsert(1);
							$oMatch->Save();
						}
					}elseif($user_id!=0){
						if($oMatch->getHomePlayer()==$user_id){
							$oMatch->setHomeInsert(1);
							$oMatch->Save();
						}
						if($oMatch->getAwayPlayer()==$user_id){
							$oMatch->setAwayInsert(1);
							$oMatch->Save();
						}
					
					}
					
					$ibp=0;
					if(getRequest('id',null,'post')==0)$ibp=1;
					$ppg=0;
					$pkg=0;	
					$shots=0;
					$hits=0;
					$penalties=0;
					$pp_g=0;
					$pk_g=0;
					$rs_g=0;
					$e_net=0;
					$bullits=0;

					$aPlayercards=$this->PluginVs_Stat_GetNhlplayercardItemsByFilter(array(
							'team_id' => $team_result 	
						));

					for ( $k=0; $k<count($aPlayercards); $k++) { 
						$goal_list[$k]=0;
						$assist_list[$k]=0;
						$rs_list[$k]=0;
						$pp_list[$k]=0;
						$pk_list[$k]=0;
						$bullit_list[$k]=0;
						$e_net_list[$k]=0;
						$star1[$k]=0;
						$star2[$k]=0;
						$star3[$k]=0;
						$win_goal[$k]=0;
					}
					for ( $k=0; $k<count($aPlayercards); $k++) { 
						/*if($k==1)$player='LW';
						if($k==2)$player='C';
						if($k==3)$player='RW';
						if($k==4)$player='LD';
						if($k==5)$player='RD';
						if($k==6)$player='Bot';
						if($k==7)$player='G';*/
//print_r($aPlayercards);
						$Player=$aPlayercards[$k];
						if($Player->getNhlplayercardId()==$_POST['star1']) {$star1[$k]=1;}else{$star1[$k]=0;}
						if($Player->getNhlplayercardId()==$_POST['star2']){$star2[$k]=1;}else{$star2[$k]=0;}
						if($Player->getNhlplayercardId()==$_POST['star3']){$star3[$k]=1;}else{$star3[$k]=0;}
					} 

					if(getRequest('id',null,'post')>=0){



						for ( $i=1; $i<=$_POST['id']; $i++) { 
						
							if(getRequest('PSH'.$i,null,'post') ==1){
								$PSH=1;
							}else{
								$PSH=0;
							}
							$period = getRequest('period'.$i,null,'post');
							if($ot==0){ 
								if($period==4){
									$period=3;
								}
							}
							if(getRequest('sostav'.$i,null,'post')==1)$ppg=$ppg+1;
							if(getRequest('sostav'.$i,null,'post')==2)$pkg=$pkg+1;
							


							for ( $k=0; $k<count($aPlayercards); $k++) { 
								/*if($k==1)$player='LW';
								if($k==2)$player='C';
								if($k==3)$player='RW';
								if($k==4)$player='LD';
								if($k==5)$player='RD';
								if($k==6)$player='Bot';
								if($k==7)$player='G';*/
								$Player=$aPlayercards[$k];
								
								if($Player->getNhlplayercardId()==getRequest('goal'.$i,null,'post')) $goal_list[$k]=$goal_list[$k]+1;
								if($Player->getNhlplayercardId()==getRequest('assist_'.$i,null,'post')) $assist_list[$k]=$assist_list[$k]+1;
								if($Player->getNhlplayercardId()==getRequest('assist__'.$i,null,'post')) $assist_list[$k]=$assist_list[$k]+1;
								if($Player->getNhlplayercardId()==getRequest('goal'.$i,null,'post') && getRequest('sostav'.$i,null,'post')==0) $rs_list[$k]=$rs_list[$k]+1;
								if($Player->getNhlplayercardId()==getRequest('goal'.$i,null,'post') && getRequest('sostav'.$i,null,'post')==1) $pp_list[$k]=$pp_list[$k]+1;
								if($Player->getNhlplayercardId()==getRequest('goal'.$i,null,'post') && getRequest('sostav'.$i,null,'post')==2) $pk_list[$k]=$pk_list[$k]+1;
								if($Player->getNhlplayercardId()==getRequest('goal'.$i,null,'post') && getRequest('sostav'.$i,null,'post')==3) $bullit_list[$k]=$bullit_list[$k]+1;
								if($Player->getNhlplayercardId()==getRequest('goal'.$i,null,'post') && $PSH==1) $e_net_list[$k]=$e_net_list[$k]+1;
								if($oMatch->getAway()==$team_result){
									if( $Player->getNhlplayercardId()==getRequest('goal'.$i,null,'post') && ($i-1)==($_POST['inputhome_teamplay']-1) ){$win_goal[$k]=$win_goal[$k]+1;}
								
								}
								if($oMatch->getHome()==$team_result){
									if($Player->getNhlplayercardId()==getRequest('goal'.$i,null,'post') && $_POST['inputhome_teamplay']>$_POST['inputaway_teamplay'] && ($i-1)==$_POST['inputhome_teamplay']){$win_goal[$k]=$win_goal[$k]+1;}
								
								}
							//if($_POST[$player]==getRequest('goal'.$i,null,'post') && $_POST['number']>$_POST['number2'] && ($i-1)==$_POST['number2']){$win_goal[$k]=$win_goal[$k]+1;}
							}	
							$oMatchgoal_add =  Engine::GetEntity('PluginVs_Stat_Matchgoal');
							$oMatchgoal_add->setMatchId($match_id);
							$oMatchgoal_add->setTeamId($team_result);
							$oMatchgoal_add->setPeriod($period);
							$oMatchgoal_add->setMinute(getRequest('minute'.$i,null,'post'));
							$oMatchgoal_add->setSecunde(getRequest('secunde'.$i,null,'post'));
							$oMatchgoal_add->setGoal(getRequest('goal'.$i,null,'post'));
							$oMatchgoal_add->setAssist(getRequest('assist_'.$i,null,'post'));
							$oMatchgoal_add->setAssist2(getRequest('assist__'.$i,null,'post'));
							$oMatchgoal_add->setType(getRequest('sostav'.$i,null,'post'));
							$oMatchgoal_add->setEmptyNet($PSH); 
							$oMatchgoal_add->Add();
						}	
							
							
						for ( $i=0; $i<count($aPlayercards); $i++) { 
							/*if($i==1)$player='LW';
							if($i==2)$player='C';
							if($i==3)$player='RW';
							if($i==4)$player='LD';
							if($i==5)$player='RD';
							if($i==6)$player='Bot';
							if($i==7)$player='G';*/
							$Player=$aPlayercards[$i];
							
							if($Player->getLw())$player='LW';
							if($Player->getC())$player='C';
							if($Player->getRw())$player='RW';
							if($Player->getLd())$player='LD';
							if($Player->getRd())$player='LD';
							if($Player->getG())$player='G';
							
							if($goal_list[$i]>0 || 
								$assist_list[$i]>0 || 
								$_POST["G"]==$Player->getNhlplayercardId() ||
								$star1[$i]>0 || $star2[$i]>0 || $star3[$i]>0
							){
								$oMatchplayerstat_add =  Engine::GetEntity('PluginVs_Stat_Matchplayerstat');
								$oMatchplayerstat_add->setMatchId($match_id);
								$oMatchplayerstat_add->setTeamId($team_result);
								$oMatchplayerstat_add->setPlayercardId($Player->getNhlplayercardId());
								$oMatchplayerstat_add->setPosition($player);
								$oMatchplayerstat_add->setShots(getRequest('shots'.$i,null,'post'));
								$oMatchplayerstat_add->setPenalty(getRequest('penalty'.$i,null,'post'));
								$oMatchplayerstat_add->setHits(getRequest('hits'.$i,null,'post'));
								$oMatchplayerstat_add->setGoals($goal_list[$i]);
								$oMatchplayerstat_add->setAssists($assist_list[$i]);
								$oMatchplayerstat_add->setRs($rs_list[$i]);
								$oMatchplayerstat_add->setPp($pp_list[$i]);
								$oMatchplayerstat_add->setPk($pk_list[$i]);
								$oMatchplayerstat_add->setBullit($bullit_list[$i]);
								$oMatchplayerstat_add->setEmptyNet($e_net_list[$i]);
								$oMatchplayerstat_add->setStar1($star1[$i]);
								$oMatchplayerstat_add->setStar2($star2[$i]);
								$oMatchplayerstat_add->setStar3($star3[$i]);
								$oMatchplayerstat_add->setWinGoal($win_goal[$i]);
								$oMatchplayerstat_add->Add();	
							}
							$shots=$shots+getRequest('shots'.$i,null,'post');
							$hits=$hits+getRequest('hits'.$i,null,'post');
							$penalties=$penalties+getRequest('penalty'.$i,null,'post');
							$rs_g=$rs_g+$rs_list[$i];
							$pp_g=$pp_g+$pp_list[$i];
							$pk_g=$pk_g+$pk_list[$i];
							$e_net=$e_net+$e_net_list[$i];
							$bullits=$bullits+$bullit_list[$i];
						}
						
						
						
						 

					}
					$oMatchResult_add->setShots($shots);
					$oMatchResult_add->setPenalty($penalties); 
					$oMatchResult_add->Add(); 
					//$plugins=new PluginVs_ActionAjax($this->oEngine,'Ajax');			
					$this->PluginVs_Stat_CheckResult($match_id);
					
					Router::Location($domain.Router::GetAction()."/".Router::GetActionEvent()."/shedule/");
					 
				}
	/*-------------------------------------------------------------------------------------*/			
			}
			
			if($oMatchResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $team_result			
					)) ){
			}
			
			/*
			$oPlayercard=$this->PluginVs_Stat_GetPlayercardByFilter(array(
						'user_id' => $this->oUserCurrent->GetUserId(),
						'sport_id' => $this->oTournament->getGame()->getSportId(),
						'platform_id' => $this->oTournament->getGame()->getPlatformId()							
					));
			*/
			if($oPlayertournament=$this->PluginVs_Stat_GetTeamsintournamentByFilter(array(
						'player_id' => $this->oUserCurrent->GetUserId(), 
						'tournament_id' => $this->oTournament->getTournamentId() 
					)) )
			{ 
				$aPlayercards=$this->PluginVs_Stat_GetNhlplayercardItemsByFilter(array(
							'team_id' => $oPlayertournament->getTeamId()	
						));
				$this->Viewer_Assign('aPlayercards',$aPlayercards);
			
			}
				if (isTournamentAdmin($oMatch->getTournamentId(),$this->User_IsAuthorization(), $this->oUserCurrent->GetUserId()) || $this->oUserCurrent->isAdministrator()) {		
				 	$aPlayercards=$this->PluginVs_Stat_GetNhlplayercardItemsByFilter(array(
							'team_id' => $team_result 	
						));
						
					$this->Viewer_Assign('aPlayercards',$aPlayercards);
				} 
				$this->Viewer_Assign('positions',Config::Get('plugin.vs.teamplay_nhl'));  
				$this->Viewer_Assign('oMatch',$oMatch); 
				
				if ($oMatchResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $team_result			
					)) ){
					
					$aMatchplayerstat = $this->PluginVs_Stat_GetMatchplayerstatItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $team_result			
					));
					$aMatchgoal = $this->PluginVs_Stat_GetMatchgoalItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $team_result			
					));
					
					$this->Viewer_Assign('oMatchResult',$oMatchResult);
					
					$this->Viewer_Assign('aMatchplayerstat',$aMatchplayerstat);
					$this->Viewer_Assign('aMatchgoal',$aMatchgoal);
				}
				$this->Viewer_Assign('team_result',$team_result);
			
		}	

    }
  protected function EventPo()
   {
		$this->Viewer_AddHtmlTitle('Playoff');
		$this->sMenuSubItemSelect = "po";
	
		
		//if($this->oUserCurrent && $this->oUserCurrent->getLogin()=='Klaus'){
		if(1==1) {
			$aPlayoff=$this->PluginVs_Stat_PlayoffTreePairs($this->oTournament->getTournamentId());
			foreach($aPlayoff as $key => $oPlayoff){
				if($oPlayoff['team_id']!=0)$aPlayoff[$key]['team']=$this->PluginVs_Stat_GetTeamByTeamId($oPlayoff['team_id']);
				if($oPlayoff['team_id']==0 && $oPlayoff['teamintournament_id']!=0) {
					$oTeamintournament = $this->PluginVs_Stat_GetTeamsintournamentById($oPlayoff['teamintournament_id']);
					$aPlayoff[$key]['user']=$oTeamintournament->getUser1();
				}
				
				if($oPlayoff['team_id_2']!=0)$aPlayoff[$key]['team_2']=$this->PluginVs_Stat_GetTeamByTeamId($oPlayoff['team_id_2']);
				if($oPlayoff['team_id_2']==0 && $oPlayoff['teamintournament_id_2']!=0) {
					$oTeamintournament = $this->PluginVs_Stat_GetTeamsintournamentById($oPlayoff['teamintournament_id_2']);
					$aPlayoff[$key]['user_2']=$oTeamintournament->getUser1();
				}
				
				
				//$goals = explode(";", $oPlayoff['goals']);
				$matches = explode(";", $oPlayoff['matches']);
				//$results = explode(";", $oPlayoff['results']);				
				$results_converted = explode(";", $oPlayoff['results_converted']);
				$results_goals = explode(";", $oPlayoff['results_goals']);
				
				for($i=0;$i<count($matches);$i++){
					//$aPlayoff[$key]['matches_played'][$i]['goals'] = $goals[$i];
					$aPlayoff[$key]['matches_played'][$i]['match_id'] = $matches[$i];
					$aPlayoff[$key]['matches_played'][$i]['results_converted'] = $results_converted[$i];
					
					$goals_converted = explode("-", $results_goals[$i]);
					if(count($goals_converted)>1){ 
						$aPlayoff[$key]['matches_played'][$i]['goals_l'] = $goals_converted[0];
						$aPlayoff[$key]['matches_played'][$i]['goals_r'] = $goals_converted[1];
					}
				}
			} 
			$this->Viewer_Assign('aPlayoff',$aPlayoff); 
			//print_r($aPlayoff);
			
			$this->SetTemplateAction('tournament_po_new');
		}else{
			$aPlayoff=$this->PluginVs_Stat_PlayoffTree($this->oTournament->getTournamentId());
			foreach($aPlayoff as $key => $oPlayoff){
				if($oPlayoff['team_id']!=0)$aPlayoff[$key]['team']=$this->PluginVs_Stat_GetTeamByTeamId($oPlayoff['team_id']);
				if($oPlayoff['team_id']==0 && $oPlayoff['teamintournament_id']!=0) {
					$oTeamintournament = $this->PluginVs_Stat_GetTeamsintournamentById($oPlayoff['teamintournament_id']);
					$aPlayoff[$key]['user']=$oTeamintournament->getUser1();
				}
				$goals = explode(";", $oPlayoff['goals']);
				$matches = explode(";", $oPlayoff['matches']);
				$results = explode(";", $oPlayoff['results']);
				for($i=0;$i<count($goals);$i++){
					$aPlayoff[$key]['matches_played'][$i]['goals'] = $goals[$i];
					$aPlayoff[$key]['matches_played'][$i]['match_id'] = $matches[$i];
					$aPlayoff[$key]['matches_played'][$i]['result'] = $results[$i];
				
				}
			} 
			$this->Viewer_Assign('aPlayoff',$aPlayoff); 
			$this->SetTemplateAction('tournament_po');
		}
    }
	protected function EventStatsSh()
	{
		$this->sMenuSubItemSelect = "stats_sh";
		$this->Viewer_AddHtmlTitle('Table');
		$this->SetTemplateAction('tournament_shahmatka'); 
	 
		$loses = array();
		$wins = array();
		$loses_svod = array();
		$wins_svod = array();
		
		$sql=" select distinct tt.group_id
				from tis_stat_teamsintournament tt , tis_stat_tournamentstat ts
				where  tt.tournament_id = ".$this->oTournament->getTournamentId()."
					and ts.tournament_id = tt.tournament_id
					and ts.round_id=0
					order by tt.group_id";				 
		if( $aGroups=$this->PluginVs_Stat_GetAll($sql) ){	 
			foreach($aGroups as $aGroup){ 
	 
				$groups[]=$aGroup['group_id'];
			} 
			foreach($groups as $group){  
				
				$sql=" select tt.team_id , t.name, t.logo, tt.group_id, tt.id,
						u.user_login as user_login,
						ifnull(u.user_profile_avatar, 'http://virtualsports.ru/templates/skin/btch/images/avatar_male_100x100.png') as user_avatar
						from tis_stat_teamsintournament tt 
							left join tis_stat_team t 
								on tt.team_id=t.team_id
							left join tis_user u
								on tt.player_id = u.user_id
							inner join tis_stat_tournamentstat ts
								on ts.tournament_id = tt.tournament_id
									and ts.round_id=0
									and tt.id=ts.teamintournament_id
						where  tt.tournament_id = ".$this->oTournament->getTournamentId()."							
							and tt.group_id = '".$group."'
						order by ts.position";				 
				$teams[$group]=$this->PluginVs_Stat_GetAll($sql);
				
				$sql=" select t.name as team, tt.team_id, tt.id, tt.parentgroup_id, tt.group_id, m.home_teamtournament, m.away_teamtournament, 
						m.goals_home, m.goals_away,
						concat(m.goals_away, '-', m.goals_home, 
								case when m.ot=1 then ' OT' else '' end, 
								case when m.so=1 then ' SO' else ''end, 
								case when m.teh=1 then ' тех' else ''end) as result,
						concat(m.goals_home, '-', m.goals_away, 
								case when m.ot=1 then ' OT' else '' end, 
								case when m.so=1 then ' SO' else ''end, 
								case when m.teh=1 then ' тех' else ''end) as result_zerkalo,
						case when m.goals_home> m.goals_away then home_teamtournament else away_teamtournament end as winner,
						case when m.goals_home<= m.goals_away then home_teamtournament else away_teamtournament end as loser
						
						from tis_stat_teamsintournament tt

						left join tis_stat_matches m
						on (
							m.home_teamtournament = tt.id 
							or 
							m.away_teamtournament =  tt.id 
							)
							and m.played = 1
							and m.tournament_id = tt.tournament_id
							and m.round_id=0

						left join tis_stat_team t
						on t.team_id = tt.team_id
						where tt.tournament_id = ".$this->oTournament->getTournamentId()."						
							and tt.group_id = '".$group."'
							order by t.name"
						;
						 
				$results=$this->PluginVs_Stat_GetAll($sql);
				
				$wins[$group] = array_fill(0,sizeof($teams[$group]),array_fill(0,sizeof($teams[$group]),''));
				
				for($i=0,$n=sizeof($results);$i<$n;$i++){
					$rs = $results[$i];
					$home_teamtournament = $rs['home_teamtournament'];
					$away_teamtournament = $rs['away_teamtournament'];
					$team_id = $rs['team_id'];
					$id = $rs['id'];
					$winner = $rs['winner'];
					$loser = $rs['loser'];
					$rss= $rs['result'];
					$rss_z= $rs['result_zerkalo'];
					if($id==$winner){
						if($winner==$home_teamtournament){
							$wins[$group][$winner][$loser][] = 'H '.$rss_z ; 
							$loses[$group][$loser][$winner][] = 'A '.$rss;
						}else{
							$wins[$group][$winner][$loser][] = 'A '.$rss ; 
							$loses[$group][$loser][$winner][] = 'H '.$rss_z;
						}
					}
				} 
			}
		
			if( $oGroups = $this->PluginVs_Stat_GetGroupItemsByFilter(array(
				'group_id in' => $groups
			)) ){
				$aGroups = null;
				foreach($oGroups as $oGroup){
					$aGroups[$oGroup->getGroupId()] = $oGroup;					
				}
			}
			if(count($groups)>1 && $this->oTournament->getShowFullStatTable()!=0){
				$groups_svod=array('0');
				foreach($groups_svod as $group){  
				
					$sql=" select tt.team_id , t.name, t.logo, tt.group_id, tt.id,
							u.user_login as user_login,
							ifnull(u.user_profile_avatar, 'http://virtualsports.ru/templates/skin/btch/images/avatar_male_100x100.png') as user_avatar
							from tis_stat_teamsintournament tt 
								left join tis_stat_team t 
									on tt.team_id=t.team_id
								left join tis_user u
									on tt.player_id = u.user_id
								inner join tis_stat_tournamentstat ts
									on ts.tournament_id = tt.tournament_id
										and ts.round_id=0
										and tt.id=ts.teamintournament_id
							where  tt.tournament_id = ".$this->oTournament->getTournamentId()."							
							
							order by ts.position";				 
					$teams_svod[$group]=$this->PluginVs_Stat_GetAll($sql);
					
					$sql=" select t.name as team, tt.team_id, tt.id, tt.parentgroup_id, tt.group_id, m.home_teamtournament, m.away_teamtournament, 
							m.goals_home, m.goals_away,
							concat(m.goals_away, '-', m.goals_home, 
									case when m.ot=1 then ' OT' else '' end, 
									case when m.so=1 then ' SO' else ''end, 
									case when m.teh=1 then ' тех' else ''end) as result,
							concat(m.goals_home, '-', m.goals_away, 
									case when m.ot=1 then ' OT' else '' end, 
									case when m.so=1 then ' SO' else ''end, 
									case when m.teh=1 then ' тех' else ''end) as result_zerkalo,
							case when m.goals_home> m.goals_away then home_teamtournament else away_teamtournament end as winner,
							case when m.goals_home<= m.goals_away then home_teamtournament else away_teamtournament end as loser
							
							from tis_stat_teamsintournament tt

							left join tis_stat_matches m
							on (
								m.home_teamtournament = tt.id 
								or 
								m.away_teamtournament =  tt.id 
								)
								and m.played = 1
								and m.tournament_id = tt.tournament_id
								and m.round_id=0

							left join tis_stat_team t
							on t.team_id = tt.team_id
							where tt.tournament_id = ".$this->oTournament->getTournamentId()."						
								
								order by t.name"
							;
							 
					$results=$this->PluginVs_Stat_GetAll($sql);
					
					$wins_svod[$group] = array_fill(0,sizeof($teams_svod[$group]),array_fill(0,sizeof($teams_svod[$group]),''));
					
					for($i=0,$n=sizeof($results);$i<$n;$i++){
						$rs = $results[$i];
						$home_teamtournament = $rs['home_teamtournament'];
						$away_teamtournament = $rs['away_teamtournament'];
						$team_id = $rs['team_id'];
						$id = $rs['id'];
						$winner = $rs['winner'];
						$loser = $rs['loser'];
						$rss= $rs['result'];
						$rss_z= $rs['result_zerkalo'];
						if($id==$winner){
							if($winner==$home_teamtournament){
								$wins_svod[$group][$winner][$loser][] = 'H '.$rss_z ; 
								$loses_svod[$group][$loser][$winner][] = 'A '.$rss;
							}else{
								$wins_svod[$group][$winner][$loser][] = 'A '.$rss ; 
								$loses_svod[$group][$loser][$winner][] = 'H '.$rss_z;
							}
						}
					} 
				}
				$this->Viewer_Assign('teams_svod', $teams_svod);
				$this->Viewer_Assign('loses_svod', $loses_svod);
				$this->Viewer_Assign('wins_svod', $wins_svod);
				$this->Viewer_Assign('groups_svod', $groups_svod);
				
			}
			$this->Viewer_Assign('teams', $teams);
			$this->Viewer_Assign('loses', $loses);
			$this->Viewer_Assign('wins', $wins);
			$this->Viewer_Assign('groups', $groups);
			$this->Viewer_Assign('aGroups', $aGroups);
		}
	}
    protected function EventPlayerStats()
    {
		$this->sMenuSubItemSelect = "player_stats";
		$this->Viewer_AddHtmlTitle('Player stats');
		$this->SetTemplateAction('tournament_player_stats');
		
		$aFilter['who']='all';
		
		/*if( Router::GetParam(1) !='' )$aFilter['who']=Router::GetParam(1);
		
		
		if(getRequestStr('start')){
			$dateInfo = date_parse_from_format("d.m.Y", getRequestStr('start'));
			$unixTimestamp = mktime(
				$dateInfo['hour'], $dateInfo['minute'], $dateInfo['second'],
				$dateInfo['month'], $dateInfo['day'], $dateInfo['year']
			);
			$aFilter['date_start'] = $unixTimestamp;
		}
		if(getRequestStr('end')){
			$dateInfo = date_parse_from_format("d.m.Y", getRequestStr('end'));
			$unixTimestamp = mktime(
				$dateInfo['hour'], $dateInfo['minute'], $dateInfo['second'],
				$dateInfo['month'], $dateInfo['day'], $dateInfo['year']
			);
			$aFilter['date_end'] = $unixTimestamp;
		}
		*/
		if(isset($_GET['f'])){		
			
			if(isset($_GET['teams'])){ 
				foreach ($_GET['teams'] as $selectedTeam){
					$aFilter['teams'][] =  intval($selectedTeam);
				}
			}else{
				//$aFilter['teams'][] = $this->myTeam;
			}
			
			if(isset($_GET['dates'])){
				$_GET['dates'] = strip_tags($_GET['dates']);
				if( strlen($_GET['dates'])==23 ){
					$aFilter['date_start'] = substr($_GET['dates'], 0,10);
					
					// $dateInfo = date_parse_from_format("Y-m-d", substr($_GET['dates'], 0,10));
					// $unixTimestamp = mktime(
						// $dateInfo['hour'], $dateInfo['minute'], $dateInfo['second'],
						// $dateInfo['month'], $dateInfo['day'], $dateInfo['year']
					// );
					// $aFilter['date_start'] = $unixTimestamp;
			
			
					$aFilter['date_end'] = substr($_GET['dates'], 13,10);
					
					// $dateInfo = date_parse_from_format("Y-m-d", substr($_GET['dates'], 13,10));
					// $unixTimestamp = mktime(
						// $dateInfo['hour'], $dateInfo['minute'], $dateInfo['second'],
						// $dateInfo['month'], $dateInfo['day'], $dateInfo['year']
					// );
					// $aFilter['date_end'] = $unixTimestamp;
					
					$aFilter['dates'] = $_GET['dates'];
				}
			}
			
			if(isset($_GET['not_played'])){
				$aFilter['not_played'] = 1;
			}
			
			if(isset($_GET['who'])){
				$aFilter['who'] = $_GET['who'];
			}
			if(isset($_GET['round'])){
				$aFilter['round_id'] = $_GET['round'];
			}
			
			//print_r($aFilter);
		}
		
		//if(getRequestStr('end'))$aFilter['date_end'] = date_parse_from_format("d.m.Y", getRequestStr('end'));
		//echo date('Y-m-d', $aFilter['date_start']);
		//print_r($date);
		
		$aFilter['tournament_id'] = $this->oTournament->getTournamentId();
		$aFilter['gametype_id'] = $this->oTournament->getGametypeId();
		$aFilter['group_by'] = array('s.tournament_id');
		
		$this->Viewer_AddWidget('right','filterplayerstat',array('plugin'=>'vs', 'oTournament'=>$this->oTournament, 'aFilter'=>$aFilter),205);	
		
		//print_r($aFilter);
		$this->Viewer_Assign('who',$aFilter['who']);
		
		if($aFilter['gametype_id'] == 7 ) {
			$aFilter['get_team'] = 'pc';
		}
		
		if($aFilter['who']=='situation'){
			$aStats=$this->PluginVs_Stat_SituationStats($aFilter);
		}else{
			$aStats=$this->PluginVs_Stat_PlayerStats($aFilter);
		}
		$this->Viewer_Assign('aStats',$aStats);
		
		foreach($aStats as $oStat){
			$teams[] = $oStat['team_id'];
		}
		if(isset($teams)){
			$oTeams = $this->PluginVs_Stat_GetTeamItemsByFilter(array(
				'team_id in' => $teams
			));
			foreach($oTeams as $oTeam){
				$aTeams[$oTeam->getTeamId()] = $oTeam;
			}
			$this->Viewer_Assign('aTeams', $aTeams);
		}
		
	}
	protected function EventMatchComment()
    {
		$this->sMenuSubItemSelect = "events";
		$this->Viewer_AddHtmlTitle('Match Comment');
		//$this->Viewer_AddWidget('right','shedulefilter',array('plugin'=>'vs', 'oTournament'=>$this->oTournament),205);
		$this->SetTemplateAction('tournament_match_comment');
		
		$match_id = $this->GetParam(1);
		/**
		 * Достаём комменты к сообщению
		 */		
		$aReturn=$this->Comment_GetCommentsByTargetId($match_id,'match');
		$iMaxIdComment=$aReturn['iMaxIdComment'];	
		$aComments=$aReturn['comments'];
		$this->Viewer_Assign('aComments',$aComments);
		$this->Viewer_Assign('iMaxIdComment',$iMaxIdComment);
		
		$oMatch=$this->PluginVs_Stat_GetMatchesByFilter(array(
			'match_id' => $match_id
		));
		if(!$oMatch)return $this->EventDenied();
		if($oMatch)$this->Viewer_AddHtmlTitle('Game report №'.$oMatch->getNumber().' between 
		'.($oMatch->getAway()!=0?$oMatch->getAwayteam()->getName():$oMatch->getAwayteamtournament()->getUser1()->getLogin()).' 
		and '.($oMatch->getHome()!=0?$oMatch->getHometeam()->getName():$oMatch->getHometeamtournament()->getUser1()->getLogin()).'');
/*		
		$aFilter=array(
			'topic_publish' => 1,
			'match_id' => $match_id,
		);
		if($aMatchVideos=$this->Topic_GetTopicsByFilter($aFilter)){
			$this->Viewer_Assign('aMatchVideos',$aMatchVideos['collection']);
		}
*/
		if($this->User_IsAuthorization())
		{
			if (!($oMatchUser=$this->PluginVs_Stat_GetMatchcommentByFilter(array(
				'match_id' => $match_id,
				'user_id' => $this->oUserCurrent->getId()))
				) && $this->User_IsAuthorization()){
				
				$MatchComment_add =  Engine::GetEntity('PluginVs_Stat_Matchcomment');
				$MatchComment_add->setMatchId($match_id);
				$MatchComment_add->setUserId($this->oUserCurrent->getId()); 
				$MatchComment_add->setDateLast(date("Y-m-d H:i:s"));
				$MatchComment_add->setCommentIdLast($iMaxIdComment);
				$MatchComment_add->setCommentCountNew(0);			
				$MatchComment_add->Add();
				
				$oMatchUser=$this->PluginVs_Stat_GetMatchcommentByFilter(array(
				'match_id' => $match_id,
				'user_id' => $this->oUserCurrent->getId() ) );
			} 		

			$this->Viewer_Assign('oMatchUser',$oMatchUser);
			
			if($oMatchUser->getCommentIdLast()==$iMaxIdComment){
				$oMatchUser->setCommentCountNew(0);
				$oMatchUser->setDateLast(date("Y-m-d H:i:s"));
			}
			
			$oMatchUser->setCommentIdLast($iMaxIdComment);			
			$oMatchUser->Save(); 
		}
		$this->Viewer_Assign('oMatch',$oMatch);	
		$this->Viewer_Assign('myteam',$this->myTeam);	
		
		
		 
		$this->Viewer_Assign('oUser',$this->oUserCurrent);
		if($oMatch){
			if ($oAwayResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $oMatch->getAwayTeamtournament()	
					)) ){					
					$this->Viewer_Assign('oAwayResult',$oAwayResult);
				}
			if ($oHomeResult = $this->PluginVs_Stat_GetMatchresultByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $oMatch->getHomeTeamtournament()
					)) ){					
					$this->Viewer_Assign('oHomeResult',$oHomeResult);
				}
			if ($oAwayRating = $this->PluginVs_Stat_GetMatchRatingByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $oMatch->getAwayTeamtournament()	
					)) ){					
					$this->Viewer_Assign('oAwayRating',$oAwayRating);
				}
			if ($oHomeRating = $this->PluginVs_Stat_GetMatchRatingByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'teamintournament_id' => $oMatch->getHomeTeamtournament()
					)) ){					
					$this->Viewer_Assign('oHomeRating',$oHomeRating);
				}
			if ($aMatchVideos = $this->PluginVs_Stat_GetMatchVideoItemsByFilter(array(
								'match_id' => $oMatch->getMatchId()
					)) ){					
					$this->Viewer_Assign('aMatchVideos',$aMatchVideos);
				}
		}	
		if($oMatch && $oMatch->getGametypeId()==3 && $oMatch->getPlayed()==1){
		
			$players=array();
		
			$sql="SELECT 
				lower(mp.position) as position, 
				case when ifnull(pc.family,'')='' then ifnull(pc.fio,'Bot') else pc.family end as family, 
				ifnull(pc.number,'00') as number,
				ifnull(u.user_login,'Bot') as user_login,
				mp.team_id as team_id,
				mp.playercard_id as playercard_id
			FROM tis_stat_matchplayerstat mp

			left join tis_stat_playercard pc
			on mp.playercard_id=pc.playercard_id

			left join tis_user u
			on pc.user_id=u.user_id

			where mp.match_id = '".$oMatch->getMatchId()."'
			and mp.position <> 'Bot' ";
			
			$aPlayers=$this->PluginVs_Stat_GetAll($sql);
			if($aPlayers)
			foreach ($aPlayers as $oPlayer){
				if($oPlayer['team_id'] == $oMatch->getAway())$home_away='away'; else $home_away='home';
				$players[$home_away][$oPlayer['position']]['family']=$oPlayer['family'];
				$players[$home_away][$oPlayer['position']]['number']=$oPlayer['number'];
				$players[$home_away][$oPlayer['position']]['user_login']=$oPlayer['user_login']; 
				$players[$home_away][$oPlayer['position']]['playercard_id']=$oPlayer['playercard_id']; 
			}
			
			
			$this->Viewer_Assign('players',$players);
			
			$sql="SELECT  
				case when mr.star1<>-1 then mr.star1 else mr2.star1 end as star1,
				case when mr.star2<>-1 then mr.star2 else mr2.star2 end as star2,
				case when mr.star3<>-1 then mr.star3 else mr2.star3 end as star3

				 FROM tis_stat_matchresult mr, tis_stat_matchresult mr2
				where mr.match_id='".$oMatch->getMatchId()."'
				and mr.match_id=mr2.match_id
				and mr.team_id<>mr2.team_id 
				LIMIT 0,1";
			$aStar=$this->PluginVs_Stat_GetAll($sql);
			
			$this->Viewer_Assign('aStar',$aStar);
			
				if($aMatchplayerstat = $this->PluginVs_Stat_GetMatchplayerstatItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $oMatch->getAway(),
								'#with'         => array('team'),  
								'#order'         => array("FIELD(position,'LW','C','RW','LD','RD','G','Bot')") 
					)) ){
						 
					foreach($aMatchplayerstat as $oPlayer){
						$aMatchplayerstat_away[$oPlayer->getPlayercardId()]=$oPlayer;
					}
					$this->Viewer_Assign('aMatchplayerstat_away',$aMatchplayerstat_away);	
				}
				if($aMatchplayerstat = $this->PluginVs_Stat_GetMatchplayerstatItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $oMatch->getHome(),
								'#with'         => array('team') ,  
								'#order'         => array("FIELD(position,'LW','C','RW','LD','RD','G','Bot')")
					)) ){
					foreach($aMatchplayerstat as $oPlayer){
						$aMatchplayerstat_home[$oPlayer->getPlayercardId()]=$oPlayer;
					}
					$this->Viewer_Assign('aMatchplayerstat_home',$aMatchplayerstat_home);		
				}
				if($aMatchgoal = $this->PluginVs_Stat_GetMatchgoalItemsByFilter(array(
						'match_id' => $oMatch->getMatchId(),
						'#with'         => array('team'),
						'#order'         => array('period', 'minute', 'secunde') 						
					)) ){
					$this->Viewer_Assign('aMatchgoal',$aMatchgoal);				
				}
				$players=array();
				
				if($aMatchgoal)
				foreach ($aMatchgoal as $oMatchgoal){
					$players[]=$oMatchgoal->getGoal();
					$players[]=$oMatchgoal->getAssist();
					$players[]=$oMatchgoal->getAssist2();
				}
				if(isset($aMatchplayerstat_home) && $aMatchplayerstat_home)
				foreach ($aMatchplayerstat_home as $oMatchplayerstat){
					$players[]=$oMatchplayerstat->getPlayercardId(); 
				}
				if(isset($aMatchplayerstat_away) && $aMatchplayerstat_away)
				foreach ($aMatchplayerstat_away as $oMatchplayerstat){
					$players[]=$oMatchplayerstat->getPlayercardId(); 
				}
				if($players)
				$aPlayers = $this->PluginVs_Stat_GetPlayercardItemsByFilter(array(
								'playercard_id in ' => $players, 
								'#with'         => array('user') 
					));
				$aPlayer=array();
				if($aPlayers)
				foreach($aPlayers as $oPlayer){
					$aPlayer[$oPlayer->getPlayercardId()]=$oPlayer;
				}
				$this->Viewer_Assign('aPlayer',$aPlayer);
/*goalkeeper */				
		$aFilter['who']='goalkeeper';		
		$aFilter['tournament_id'] = $this->oTournament->getTournamentId();
		$aFilter['gametype_id'] = $this->oTournament->getGametypeId();
		$aFilter['match_id'] = array($oMatch->getMatchId());
		$aFilter['group_by'] = array('s.tournament_id');
		
		$aStats=$this->PluginVs_Stat_PlayerStats($aFilter);

		if($aStats){		
			foreach($aStats as $oStat){
				$teams[] = $oStat['team_id'];
			}
			if(isset($teams)){
				$oTeams = $this->PluginVs_Stat_GetTeamItemsByFilter(array(
					'team_id in' => $teams
				));
				foreach($oTeams as $oTeam){
					$aTeams[$oTeam->getTeamId()] = $oTeam;
				}
				$this->Viewer_Assign('aTeams', $aTeams);
			}
			$this->Viewer_Assign('aStats',$aStats);
			
		}
/*goalkeeper */		
		
			}
			
		if($oMatch->getGametypeId()==7 && $oMatch->getPlayed()==1){
		
			$players=array();
		
			$sql="SELECT 
				lower(mp.position) as position, 
				pc.family as family, 
				ifnull(pc.number,'00') as number,
				'' as user_login,
				mp.team_id as team_id,
				mp.playercard_id as playercard_id
			FROM tis_stat_matchplayerstat mp

			left join tis_stat_nhlplayercard pc
			on mp.playercard_id=pc.nhlplayercard_id
 

			where mp.match_id = '".$oMatch->getMatchId()."'
			and mp.position <> 'Bot' ";
			
			$aPlayers=$this->PluginVs_Stat_GetAll($sql);
			if($aPlayers)
			foreach ($aPlayers as $oPlayer){
				if($oPlayer['team_id'] == $oMatch->getAway())$home_away='away'; else $home_away='home';
				$players[$home_away][$oPlayer['position']]['family']=$oPlayer['family'];
				$players[$home_away][$oPlayer['position']]['number']=$oPlayer['number'];
				$players[$home_away][$oPlayer['position']]['user_login']=$oPlayer['user_login']; 
				$players[$home_away][$oPlayer['position']]['playercard_id']=$oPlayer['playercard_id']; 
			}
			
			
			$this->Viewer_Assign('players',$players);
			
			$sql="SELECT  
				case when mr.star1<>-1 then mr.star1 else mr2.star1 end as star1,
				case when mr.star2<>-1 then mr.star2 else mr2.star2 end as star2,
				case when mr.star3<>-1 then mr.star3 else mr2.star3 end as star3

				 FROM tis_stat_matchresult mr, tis_stat_matchresult mr2
				where mr.match_id='".$oMatch->getMatchId()."'
				and mr.match_id=mr2.match_id
				and mr.team_id<>mr2.team_id 
				LIMIT 0,1";
			$aStar=$this->PluginVs_Stat_GetAll($sql);
			
			$this->Viewer_Assign('aStar',$aStar);
			 
				if($aMatchplayerstat = $this->PluginVs_Stat_GetMatchplayerstatItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $oMatch->getAway(),
								'#with'         => array('team'),  
								'#order'         => array("FIELD(position,'LW','C','RW','LD','RD','G','Bot')") 
					)) ){
						 
					foreach($aMatchplayerstat as $oPlayer){
						$aMatchplayerstat_away[$oPlayer->getPlayercardId()]=$oPlayer;
					}
					$this->Viewer_Assign('aMatchplayerstat_away',$aMatchplayerstat_away);	
				}
				
				if($aMatchplayerstat = $this->PluginVs_Stat_GetMatchplayerstatItemsByFilter(array(
								'match_id' => $oMatch->getMatchId(),
								'team_id' => $oMatch->getHome(),
								'#with'         => array('team') ,  
								'#order'         => array("FIELD(position,'LW','C','RW','LD','RD','G','Bot')")
					)) ){
					foreach($aMatchplayerstat as $oPlayer){
						$aMatchplayerstat_home[$oPlayer->getPlayercardId()]=$oPlayer;
					}
					$this->Viewer_Assign('aMatchplayerstat_home',$aMatchplayerstat_home);		
				}
				 
				if($aMatchgoal = $this->PluginVs_Stat_GetMatchgoalItemsByFilter(array(
						'match_id' => $oMatch->getMatchId(),
						'#with'         => array('team'),
						'#order'         => array('period', 'minute', 'secunde') 						
					)) ){
					$this->Viewer_Assign('aMatchgoal',$aMatchgoal);				
				}
				$players=array();
				
				if($aMatchgoal)
				foreach ($aMatchgoal as $oMatchgoal){
					$players[]=$oMatchgoal->getGoal();
					$players[]=$oMatchgoal->getAssist();
					$players[]=$oMatchgoal->getAssist2();
				}
				if(isset($aMatchplayerstat_home))
				foreach ($aMatchplayerstat_home as $oMatchplayerstat){
					$players[]=$oMatchplayerstat->getPlayercardId(); 
				}
				if(isset($aMatchplayerstat_away))
				foreach ($aMatchplayerstat_away as $oMatchplayerstat){
					$players[]=$oMatchplayerstat->getPlayercardId(); 
				}
				if(isset($players))
				$aPlayers = $this->PluginVs_Stat_GetNhlplayercardItemsByFilter(array(
								'nhlplayercard_id in ' => $players 
					));
				$aPlayer=array();
				foreach($aPlayers as $oPlayer){
					$aPlayer[$oPlayer->getNhlplayercardId()]=$oPlayer;
				}
				$this->Viewer_Assign('aPlayer',$aPlayer);
				
			}
		
	}
	
	protected function EventStats()
    {
		$this->sMenuSubItemSelect = "stats";
		$this->Viewer_AddHtmlTitle('Stats');
		
		$this->Viewer_AddHtmlTitle('Team stats');
		
		
		if($this->oTournament->getShowFullStatTable()==1){
			$table_type='full';
		}elseif($this->oTournament->getShowParentStatTable()==1){
			$table_type='conf';
		}else{
			$table_type='group';
		}
			
		if (func_check(Router::GetParam(1),'text',3,30))$table_type=htmlspecialchars( Router::GetParam(1), ENT_QUOTES); 
		
		$order = array('position'=>'asc','team_id'=>'asc');
		//if($this->oGame->getSportId()==3)$order = array('(home_w + away_w + home_wot + away_wot + home_wb + away_wb - (home_l + away_l + home_lot + away_lot + home_lb + away_lb))/(home_w + away_w + home_wot + away_wot + home_wb + away_wb + (home_l + away_l + home_lot + away_lot + home_lb + away_lb))'=>'desc','team_id'=>'asc');
		if($this->oGame->getSportId()==3)array('position'=>'asc','points'=>'desc','team_id'=>'asc');
		if($this->oGame->getSportId()==5)$order = array('position'=>'desc','(home_w + away_w + home_wot + away_wot + home_wb + away_wb )'=>'desc');
		
		if($table_type=='full'){
			$Tournamentstat = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
					'tournament_id' => $this->oTournament->getTournamentId(),
					'round_id <>' => '100',
					'#with'         => array('team','round','teamtournament'),
					'#order' => $order
				));
			$this->Viewer_Assign('Tournamentstat',$Tournamentstat);	
		}
		
		if($table_type=='conf'){
			if($this->oGame->getSportId()==5){
				$aTournamentstatparentgroup = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
						'tournament_id' => $this->oTournament->getTournamentId(),
						'round_id <>' => '100',				
						'#with'         => array('team','round','group','parentgroup','teamtournament'),
						'#order' =>array('round_id'=>'desc','parentgroup_id'=>'asc', 'position' => 'asc','points'=>'desc') 
					));			
			}else{
				$aTournamentstatparentgroup = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
						'tournament_id' => $this->oTournament->getTournamentId(),
						'round_id <>' => '100',				
						'#with'         => array('team','round','group','parentgroup','teamtournament'),
						'#order' =>array('round_id'=>'desc','parentgroup_id'=>'asc', 'nbalead'=>'desc','position' => 'asc','team_id'=>'asc')
					));
			}
			if($this->oGame->getSportId()==3){
				$group_record = array();
				
				if($aTournamentstatparentgroup)
				foreach($aTournamentstatparentgroup as $oTournamentstat){
					if (!array_key_exists($oTournamentstat->getParentgroupId(), $group_record)) {
						$group_record[$oTournamentstat->getParentgroupId()]=$oTournamentstat->getDifWinLose();
					}
					if($oTournamentstat->getDifWinLose() > $group_record[$oTournamentstat->getParentgroupId()])$group_record[$oTournamentstat->getParentgroupId()]=$oTournamentstat->getDifWinLose();
				}
				$this->Viewer_Assign('group_record',$group_record);
			}
			$this->Viewer_Assign('aTournamentstatparentgroup',$aTournamentstatparentgroup);	
		}
		
		if($table_type=='group'){
			if($this->oGame->getSportId()==5){
				$aTournamentstatgroup = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
					'tournament_id' => $this->oTournament->getTournamentId(),
					'round_id <>' => '100',				
					'#with'         => array('team','round','group','parentgroup','teamtournament'),
					'#order' =>array('round_id'=>'desc','parentgroup_id'=>'asc','group_id'=>'asc', 'position' => 'asc','points'=>'desc')
				));
				
			}else{
				$aTournamentstatgroup = $this->PluginVs_Stat_GetTournamentstatItemsByFilter(array(
					'tournament_id' => $this->oTournament->getTournamentId(),
					'round_id <>' => '100',				
					'#with'         => array('team','round','group','parentgroup','teamtournament'),
					'#order' =>array('round_id'=>'desc','parentgroup_id'=>'asc','group_id'=>'asc', 'position' => 'asc','team_id'=>'asc')
				));
				
			}
			if($this->oGame->getSportId()==3){
				$group_record = array();
				if($aTournamentstatgroup)
				foreach($aTournamentstatgroup as $oTournamentstat){
					if (!array_key_exists($oTournamentstat->getGroupId(), $group_record)) {
						$group_record[$oTournamentstat->getGroupId()]=$oTournamentstat->getDifWinLose();
					}
					if($oTournamentstat->getDifWinLose() > $group_record[$oTournamentstat->getGroupId()])$group_record[$oTournamentstat->getGroupId()]=$oTournamentstat->getDifWinLose();
				}
				$this->Viewer_Assign('group_record',$group_record);
			}
			$this->Viewer_Assign('aTournamentstatgroup',$aTournamentstatgroup);	
		}
		
		$this->Viewer_Assign('table_type',$table_type);	
		
		if($this->oGame->getSportId()==1){
			if($this->oTournament->getGametypeId()==3){
				$this->SetTemplateAction('tournament_stats_hockey_teamplay');
			}elseif($this->oTournament->getGametypeId()==3){
				$this->SetTemplateAction('tournament_stats_hockey_teamplay');
			}{
				$this->SetTemplateAction('tournament_stats');
			}				
		}elseif($this->oGame->getSportId()==2){
			$this->SetTemplateAction('tournament_stats_football');
		}elseif($this->oGame->getSportId()==3){
			$this->SetTemplateAction('tournament_stats_nba');
		}elseif($this->oGame->getSportId()==4){
			$this->SetTemplateAction('tournament_stats_gonka');
		}elseif($this->oGame->getSportId()==5){
			$this->SetTemplateAction('tournament_stats_nfl');
		}elseif($this->oGame->getSportId()==6){
			$this->SetTemplateAction('tournament_stats_mma');
			
			if( $TitulTournamentStat = $this->PluginVs_Stat_GetTournamentstatByFilter(array(
				'tournament_id' => $this->oTournament->getTournamentId(),
				'round_id <>' => '100',
				'titul' => '1',
				'#with'         => array('team','round') 
			))){
				$this->Viewer_Assign('TitulTournamentStat',$TitulTournamentStat);	
			}
		}else{
			$this->SetTemplateAction('tournament_stats');
		}
	}
	
	
	protected function EventAdmin()
    {
		$this->sMenuSubItemSelect = "admin";
		$this->Viewer_AddHtmlTitle('Admin');
		//$this->Viewer_AddWidget('right','shedulefilter',array('plugin'=>'vs', 'oTournament'=>$this->oTournament),205);
		
		$this->SetTemplateAction('tournament_admin');
		if($this->oUserCurrent && ($this->oUserCurrent->isAdministrator() || $this->isAdmin)){		
			$this->SetTemplateAction('tournament_admin');			
		}else{
			$this->SetTemplateAction('tournament_events');
		}	
	
	}
	
	protected function EventEvents()
    {
		$this->sMenuSubItemSelect = "events";
		$this->Viewer_AddHtmlTitle('Events');
		//$this->Viewer_AddWidget('right','shedulefilter',array('plugin'=>'vs', 'oTournament'=>$this->oTournament),205);
		
		$this->SetTemplateAction('tournament_events');
		$aEvents = $this->PluginVs_Stat_StreamRead(null, 0,$this->oTournament->getTournamentId());
		//$this->Viewer_Assign('aStreamEvents', $aEvents); 
		if (count($aEvents)) {
			$oEvenLast=end($aEvents);
			$this->Viewer_Assign('iStreamLastId', $oEvenLast->getId());
		}
		
		$oViewer=$this->Viewer_GetLocalViewer();
		$oViewer->Assign('aStreamEvents',$aEvents);
		$sTextResult=$oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__)."actions/ActionTournament/events.tpl");
		$this->Viewer_Assign('sTextEvents',$sTextResult);
	
	
	}
	
	
	protected function EventRules()
    {
		$this->sMenuSubItemSelect = "rules";
		$this->Viewer_AddHtmlTitle('Rules');
		//$this->Viewer_AddWidget('right','shedulefilter',array('plugin'=>'vs', 'oTournament'=>$this->oTournament),205);
		
		
		$can_edit=0;
		$oTournamentReglament=$this->PluginVs_Stat_GetTournamentreglamentByTournamentId($this->oTournament->getTournamentId());
		if( $this->oUserCurrent && ($this->oUserCurrent->isAdministrator() || $this->isAdmin)){
			$can_edit=1;
			$this->Viewer_Assign('link_reglament_edit', $this->oTournament->getUrlFull()."rules/edit/");
		}
		if(Router::GetParam(1)=='edit' && (  $this->oUserCurrent && ($this->oUserCurrent->isAdministrator() || $this->isAdmin) ) ){
			if(isPost('submit_topic_publish')){
			
				$oTournamentReglament->setReglamentSource(getRequestStr('topic_text'));
				$oTournamentReglament->setReglamentText( $this->Text_Parser(getRequestStr('topic_text')) );
				$oTournamentReglament->Save();
			}
			
			$this->Viewer_Assign('oTournamentReglament',$oTournamentReglament);
			$this->SetTemplateAction('tournament_rules_edit');
		}else{
			$this->Viewer_Assign('can_edit',$can_edit);
			$this->SetTemplateAction('tournament_rules');
			
			if($oTournamentReglament) $this->Viewer_Assign('Reglament',$oTournamentReglament->getReglamentText());
		}
		
		 
	}
	protected function EventShedule()
    {
		$this->sMenuSubItemSelect = "shedule";
		$this->Viewer_AddHtmlTitle('Shedule');
		
		$aFilter = array();
		
		if(isset($_GET['f'])){		
			
			if(isset($_GET['teams'])){ 
				foreach ($_GET['teams'] as $selectedTeam){
					$aFilter['teams'][] =  intval($selectedTeam);
				}
			}else{
				//$aFilter['teams'][] = $this->myTeam;
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
			if(isset($_GET['round_po'])){
				$aFilter['round_po'] = $_GET['round_po'];
			}
			if(isset($_GET['event'])){
				$aFilter['event_id'] = $_GET['event'];
			}
			//print_r($aFilter);
		}else{			
			if($this->User_IsAuthorization() && $this->myTeamTournament){
				
				if($this->oTournament->getKnownTeams()!= 3 && $this->oTournament->getGametypeId()!= 3) {
					$aFilter['teams'][] = $this->myTeam;
					$aFilter['not_played'] = 1;
				}else{
					if(!$aEvents = $this->PluginVs_Stat_GetEventItemsByFilter(array(
					'tournament_id'=>$this->oTournament->getTournamentId(),
					'#order' =>array('id'=>'desc'),
					'#limit' =>array('0',1) ))
					) {
						$aFilter['players'][] =  $this->oUserCurrent->getId();
						$aFilter['not_played'] = 1;
					}
				}
			}
		}
		
		// if(!isset($_GET['f']) && $this->myTeam != 0 && $this->oTournament->getGametypeId()!= 8 ){
			// $aFilter['teams'][] = $this->myTeam;
			// $aFilter['not_played'] = 1;			
		// }
		$aFilter['month'] =0;
		$aFilter['my_team_id'] = $this->myTeam;
		$aFilter['my_teamintournament_id'] = $this->myTeamTournament;
		$aFilter['tournament_id'] = $this->oTournament->getTournamentId();
			
		if ($this->User_IsAuthorization()) {
			$aFilter['user_id'] = $this->oUserCurrent->getId();
		}else{
			$aFilter['user_id'] = 0;
		}
		if(!isset($_GET['f']) && ($this->myTeam == 0 || isset($aEvents))){
			
			$month_start = strtotime('first day of this month', time());
			$month_end = strtotime('last day of this month', time());
			$week_start = strtotime('last Sunday', time());
			$week_end = strtotime('next Sunday', time()+ (7 * 24 * 60 * 60));
			
			$aFilter['date_start'] = date('Y-m-d', $week_start);
			$aFilter['date_end'] = date('Y-m-d', $week_end);
			$aFilter['dates'] = $aFilter['date_start'].' - '.$aFilter['date_end'];
		}
		
		$this->Viewer_AddWidget('right','filterschedule',array('plugin'=>'vs', 'oTournament'=>$this->oTournament, 'aFilter'=>$aFilter),205);	
		
		
		if($this->oGame->getSportId()==4){
		
			$this->SetTemplateAction('tournament_raspisanie_gonki');
			
			$Setmonth = 0;
			$Setcurrentweek = 0;
			$Setteam = 0;
			$Setyear = 0;
			$userid=0;
			$week=0;
			$month=0;
			$teambrief='';
			$sql="select id as map_now 
			      from tis_stat_mapsintournament where  
				  tournament_id='".$this->oTournament->getTournamentId()."'
				  and dates=(select min(dates) from `tis_stat_mapsintournament` 
							where  '".date("Y-m-d")."'<DATE_ADD(dates,  INTERVAL 3 DAY))";

			$ids=$this->PluginVs_Stat_GetAll($sql);
			$map_now=$ids[0]['map_now'];
			
			$aMapsInTournament = $this->PluginVs_Stat_GetMapsintournamentItemsByFilter(array(
					'tournament_id' => $this->oTournament->getTournamentId(), 
					'#with'         => array('map') 
				));
			$aZaezd_kval = $this->PluginVs_Stat_GetZaezdItemsByFilter(array(
					'mapintournament_id' => $map_now, 
					'kval_gonka' => '0',
					'#with'         => array('user','team'), 
					'#order' => array('prioritet' => 'asc')
				));	
			$aZaezd_gonka = $this->PluginVs_Stat_GetZaezdItemsByFilter(array(
					'mapintournament_id' => $map_now, 
					'kval_gonka' => '1',
					'#with'         => array('user','team'), 
					'#order' =>array('prioritet'=>'asc')
				));	 
			$oViewer=$this->Viewer_GetLocalViewer(); 
			$oViewer->Assign('admin',$this->isAdmin);
			$oViewer->Assign('currentweek',date('W', time()));
			$oViewer->Assign('month',$month);
			$oViewer->Assign('myteam',$this->myTeam);
			if(isset($this->myTeam) && $this->myTeam!=0){
				$oTeam=$this->PluginVs_Stat_GetTeamByTeamId($this->myTeam);
				$this->Viewer_Assign('oTeam',$oTeam); 
				//echo $oTeam->getName();
			}
			$oViewer->Assign('aZaezd_kval',$aZaezd_kval);
			$oViewer->Assign('aZaezd_gonka',$aZaezd_gonka);
			
			$oViewer->Assign('tournament_id',$this->oTournament->getTournamentId());
			$oViewer->Assign('mapintournament_id',$map_now);
			$oViewer->Assign('oGame',$this->oGame);
			$oViewer->Assign('oUserCurrent',$this->oUserCurrent);

			$oViewer->Assign('link_match', Router::GetAction()."/".Router::GetActionEvent()."/_match/");
			$oViewer->Assign('link_match_insert', Router::GetAction()."/".Router::GetActionEvent()."/_match_insert/");
			$sTextResult=$oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__)."actions/ActionTournament/gameday.tpl");
			$this->Viewer_Assign('sRaspisanie',$sTextResult);
			$this->Viewer_Assign('aMapsInTournament',$aMapsInTournament);
			$this->Viewer_Assign('mapintournament_id',$map_now);
			
		}else{
			$this->SetTemplateAction('tournament_shedule');
				
			
			$oMatches=$this->PluginVs_Stat_MatchesSQLNew($aFilter);
				
			
	
			$oViewer=$this->Viewer_GetLocalViewer();
			$admin='no';
			if ($this->isAdmin) {$admin='yes';}
			if($this->oUserCurrent && $this->oUserCurrent->isAdministrator())$admin='yes';
			$oViewer->Assign('admin',$admin);
			
			$oViewer->Assign('oMatches',$oMatches);
			$oViewer->Assign('isAdmin',$this->isAdmin);
			$oViewer->Assign('currentweek',date('W', time()));
			$oViewer->Assign('month',$aFilter['month']);
			$oViewer->Assign('myteam',$this->myTeam);
			if(isset($this->myTeam) && $this->myTeam!=0){
				$oTeam=$this->PluginVs_Stat_GetTeamByTeamId($this->myTeam);
				$this->Viewer_Assign('oTeam',$oTeam);
			}
			$oViewer->Assign('tournament_id',$this->oTournament->getTournamentId());
			$oViewer->Assign('oGame',$this->oGame);
			
			$oViewer->Assign('oUserCurrent', $this->oUserCurrent);
			$sTextResult=$oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__)."actions/ActionTournament/shedule.tpl");
			$this->Viewer_Assign('sRaspisanie',$sTextResult);
		}
	}
    protected function EventPlayers()
    {	
		$this->sMenuSubItemSelect = "players";
		$platfroms=array('pc'=>'EA', 'ps3'=>'psn', 'ps4'=>'psn', 'xbox'=>'xbox' );
		$oPlatform = $this->PluginVs_Stat_GetPlatformByPlatformId($this->oGame->getPlatformId());
		$this->Viewer_Assign('tournament_contact_name', $platfroms[$oPlatform->getBrief()]);
		
	
		if(Router::GetParam(1)=='enter')
		{				
			
			if (!$this->User_IsAuthorization()) {
					return $this->EventDeniedNotRegister('');
				}
			
				if($this->oTournament->getKnownTeams()==1 || $this->oTournament->getKnownTeams()==3)
				{
					
								
					$this->oUserCurrent=$this->User_GetUserCurrent();			
					$aTeamPrioritet = $this->PluginVs_Stat_GetZayavkiItemsByFilter(array(
						'user_id' => $this->oUserCurrent->GetUserId(),
						'tournament_id' =>$this->oTournament->getTournamentId(),
						'#with'         => array('team'),
						'#order' =>array('prioritet'=>'asc')
						
					));
					
					$this->Viewer_Assign('aTeamPrioritet',$aTeamPrioritet);
					
					$arr_teams = array();
					$arr_teams[0]='';
					
					$aTempTeamInTournament = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
						'tournament_id' => $this->oTournament->getTournamentId(),
						'player_id != '    => '0'
					));
					$zanytue=array();
					$zanytue[0]='';			
					foreach($aTempTeamInTournament as $oTempTeamInTournament) {
							array_push($zanytue, $oTempTeamInTournament->getTeamId());
					}	
							$this->Viewer_Assign('zanytue',$zanytue);	
							
					foreach($aTeamPrioritet as $oTeamPrioritet) {
							array_push($arr_teams, $oTeamPrioritet->getTeamId());
					}			

					if($this->oTournament->getGametypeId()!=4){ //ut
						$aTeamInTournament = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
							'tournament_id' => $this->oTournament->getTournamentId(),
							'player_id '    => '0',
							//'players_id '   => '0',
							'#where' => array('team_id not in (?a)' => array( $arr_teams)),				
							//'team_id not in'=>$arr_teams,
							'#with'         => array('team')
						));
						$this->SetTemplateAction('tournament_players_enter');
						$this->Viewer_Assign('ut',0);
						
					}else{
						$aTeamUtInTournament = $this->PluginVs_Stat_GetTeamItemsByFilter(array(						 
							'owner_id '    => $this->oUserCurrent->GetUserId(), 
							'gametype_id' => $this->oTournament->getGametypeId(),
							'#where' => array('team_id not in (?a)' => array( $arr_teams)),	
							'game_id' => $this->oTournament->getGameId()  
						));
						$this->SetTemplateAction('tournament_players_enter');
						$this->Viewer_Assign('ut',1);
						$oGameType= $this->PluginVs_Stat_GetGametypeByGametypeId($this->oTournament->getGametypeId());
						
						
						if($aTeams = $this->PluginVs_Stat_GetTeamItemsByFilter(array(
							'sport_id' => $this->oGame->getSportId(),
							'gametype_id' => $oGameType->getGametypeId(),
							'game_id' => $this->oGame->getGameId(),
							'owner_id' => $this->oUserCurrent->GetUserId()		
						))
						){
							$this->Viewer_Assign('aTeams',$aTeams);					
						}
						if($oGameType->getGametypeId()=='4'){
							$sql="select distinct logo from `tis_stat_team` where ltrim(rtrim(logo)) <>'' and sport_id=".$this->oGame->getSportId()." and gametype_id=1 order by logo";						 
							$aLogos=$this->PluginVs_Stat_GetAll($sql);
							$this->Viewer_Assign('aLogos',$aLogos);
						}
						
						
						$Identifier=$this->User_getUserFieldValueByName($this->oUserCurrent->GetUserId(), $platfroms[$oPlatform->getBrief()]);
						
						$this->Viewer_Assign('Identifier',$Identifier);
						$this->Viewer_Assign('game_id',$this->oGame->getGameId());
						$this->Viewer_Assign('oGame',$this->oGame);
						
						$this->Viewer_Assign('gametype_id',$oGameType->getGametypeId());
						
						$this->Viewer_Assign('authorise',1);
						
						//$this->Viewer_Assign('link_nastroiki',Config::Get('path.root.web')."/".Router::GetAction()."/".Router::GetActionEvent()."/".$this->GetParam(0)."/_nastroiki/");
					}
					
					$vsego=isset($aTeamInTournament)?count($aTeamInTournament):0+count($aTeamPrioritet);
					$this->Viewer_Assign('Vsego',$vsego);
					$this->Viewer_Assign('Vsego_css',$vsego*37);
					
					$oPlayerTournament = $this->PluginVs_Stat_GetPlayertournamentByFilter(array(
						'user_id' => $this->oUserCurrent->GetUserId(),
						'tournament_id'         => $this->oTournament->getTournamentId()					
					)); 
		 	 /*
					if($oPlatform->getBrief()=='pc'){
						$what_identifier = 'EA';
					}else{
						$what_identifier = $oPlatform->getBrief();
					}
			*/		
					$what_identifier = $platfroms[$oPlatform->getBrief()];
					
					$Tag='';
					if($what_identifier=='psn')$Tag='PSN ID';
					if($what_identifier=='xbox')$Tag='GameTag';
					if($what_identifier=='EA')$Tag='EA';
					$this->Viewer_Assign('Tag',$Tag);
					$Identifier=$this->User_getUserFieldValueByName($this->oUserCurrent->GetUserId(), $what_identifier);
					
					$this->Viewer_Assign('Tournament',$this->oTournament->getTournamentId());
					if(isset($aTeamInTournament))$this->Viewer_Assign('aTeamInTournament',$aTeamInTournament);					
					if(isset($aTeamUtInTournament))$this->Viewer_Assign('aTeamUtInTournament',$aTeamUtInTournament);
					$this->Viewer_Assign('oPlayerTournament',$oPlayerTournament);
					
					$this->Viewer_Assign('Identifier',$Identifier);
					
					$Oplatil = 'no';
					$aFilter = array(
							'user_id' => $this->oUserCurrent->GetUserId(),
							'operation_subject_type' => 'tournament',
							'operation_subject_id' => $this->oTournament->getTournamentId()
						);
					if( $aResult = $this->PluginLspurse_Purse_GetOperationByFilter($aFilter, 1, 1) ){
						$aOperations = $aResult['collection'];  
						//print_r($aOperations);
						$oOperation = array_shift($aOperations);
						if( $oOperation && abs($oOperation->getSumma()) >= $this->oTournament->getVznos() ){						
							$Oplatil = 'yes'; 
						}
						if($oOperation)$this->Viewer_Assign('oOperation', $oOperation);
					}
					$this->Viewer_Assign('Oplatil', $Oplatil);
				
			}
		}else{
		  
			
			$this->Viewer_AddHtmlTitle('Players');
			
			if (/*$this->oTournament->getGametypeId() != 4 &&*/ $this->oTournament->getGametypeId() != 3 && $this->oGame->getSportId() != 4) {
				$this->SetTemplateAction('tournament_players');
			/*} elseif ($this->oTournament->getGametypeId() == 4) {
				$this->SetTemplateAction('tournament_players_hut');*/
			} elseif ($this->oGame->getSportId() == 4) {
				$this->SetTemplateAction('tournament_players_gonki');
			} elseif ($this->oTournament->getGametypeId() == 3) {
				$this->SetTemplateAction('tournament_players_teamplay');
			}
			
			if ($this->oTournament->getGametypeId() == 3 /*&& $this->oTournament->getKnownTeams() == 0*/) {
				if ($this->oTournament->getGametypeId() == 3 && $this->oTournament->getKnownTeams() == 0) {
					$sql = "SELECT  pc.*, u.user_login, u.user_profile_city, pt.cap, ifnull(t.name,'') as team_name, ifnull(t.team_id,0) as team_id,
					case when pc.foto='' then 'http://virtualsports.ru/templates/skin/virtsports/images/Arshavin.png' else pc.foto end as user_profile_avatar
						FROM `tis_stat_playercard` pc 
						inner join `tis_stat_playertournament` pt
							on pt.playercard_id = pc.playercard_id
								and pt.otozvan=0
						left join `tis_user` u
							on u.user_id=pc.user_id
						left join `tis_stat_team` t
							on t.team_id=pt.team_id
						where pt.tournament_id='" . $this->oTournament->getTournamentId() . "'	
						order by team_name, user_login
						";
				}
				if ($this->oTournament->getGametypeId() == 3 && $this->oTournament->getKnownTeams() != 0) {
					$sql = "SELECT  pc.*, u.user_login, u.user_profile_city, pt.cap, ifnull(t.name,'') as team_name, ifnull(t.team_id,0) as team_id,
					case when pc.foto='' then 'http://virtualsports.ru/templates/skin/virtsports/images/Arshavin.png' else pc.foto end as user_profile_avatar
						FROM `tis_stat_playercard` pc 
						inner join `tis_stat_playertournament` pt
							on pt.playercard_id = pc.playercard_id
								and pt.otozvan=0
						left join `tis_user` u
							on u.user_id=pc.user_id
						left join `tis_stat_team` t
							on t.team_id=pt.team_id
						inner join tis_stat_teamsintournament tt
							on pt.team_id=tt.team_id
							and tt.tournament_id=pt.tournament_id
						where pt.tournament_id='" . $this->oTournament->getTournamentId() . "'	
						order by team_name, user_login
						";
				}
				$aPlayercard = $this->PluginVs_Stat_GetAll($sql);
				$this->Viewer_Assign('aPlayercard', $aPlayercard);
				$this->Viewer_Assign('count_aPlayercard', count($aPlayercard));
				//print_r($aPlayercard);
			}
			
			if($this->oTournament->getKnownTeams()!=3){
				$sql          = "select t.team_id from tis_stat_teamsintournament tt, tis_stat_team t where tt.tournament_id='" . $this->oTournament->getTournamentId() . "' and tt.team_id=t.team_id order by t.name";
				$aTeams_order = $this->PluginVs_Stat_GetAll($sql);
				$teams_order  = array();
				if ($aTeams_order)
					foreach ($aTeams_order as $oTeam_order) {
						$teams_order[] = $oTeam_order['team_id'];
					} else {
					$teams_order[0] = 0;
				}
				
				
				$aTeamInTournament = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
					'tournament_id' => $this->oTournament->getTournamentId(),
					'#where' => array(
						' 1=1 order by FIELD(team_id,?a)' => array(
							$teams_order
						)
					),
					'#with' => array(
						'user1',
						'team'
					)
				));
			}else{
				$sql          = "select u.user_id, case when tt.team_id=0 then 0 else 1 end as have_team from tis_stat_teamsintournament tt, tis_user u where tt.tournament_id='" . $this->oTournament->getTournamentId() . "' and tt.player_id=u.user_id order by have_team desc, u.user_login";
				$aUsers_order = $this->PluginVs_Stat_GetAll($sql);
				//print_r($aUsers_order);
				$users_order  = array();
				if ($aUsers_order)
					foreach ($aUsers_order as $oUser_order) {
						$users_order[] = $oUser_order['user_id'];
					} else {
					$users_order[0] = 0;
				}
				
				
				$aTeamInTournament = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
					'tournament_id' => $this->oTournament->getTournamentId(),
					'#where' => array(
						' 1=1 order by FIELD(player_id,?a)' => array(
							$users_order
						)
					),
					'#with' => array(
						'user1',
						'team'
					)
				));
			
			
			}
			
			if (!$aTeamInTournament) {
				$sql    = "select distinct team_id from tis_stat_zayavki where tournament_id='" . $this->oTournament->getTournamentId() . "'";
				$aTeams = $this->PluginVs_Stat_GetAll($sql);
				$teams  = array();
				if ($aTeams)
					foreach ($aTeams as $oTeam) {
						$teams[] = $oTeam['team_id'];
					}
				if (count($teams) > 0)
					$aTeamTournament = $this->PluginVs_Stat_GetTeamItemsByFilter(array(
						'team_id in ' => $teams
					));
				
				if (isset($aTeamTournament))
					$this->Viewer_Assign('aTeamTournament', $aTeamTournament);
			}
			
			$aObjects = array();
			$element  = 0;
			foreach ($aTeamInTournament as $oTeamInTournament) {
				$aObjects[$element]['oTeamInTournament'] = $oTeamInTournament;
				if ($aUserFields = $this->User_getUserFieldsValues($oTeamInTournament->getPlayerId())){
					$aObjects[$element]['aUserFields'] = $aUserFields;
				}
				if ($oPlayerTournament = $this->PluginVs_Stat_GetPlayertournamentByFilter(array(
					'user_id' => $oTeamInTournament->getPlayerId(),
					'tournament_id' => $this->oTournament->getTournamentId()
				))) {
					$aObjects[$element]['oPlayerTournament'] = $oPlayerTournament;
				}
				$element++;
			}
			
			$this->Viewer_Assign('aObjects', $aObjects);
			
			$oPlatform = $this->PluginVs_Stat_GetPlatformByPlatformId($this->oGame->getPlatformId());
			if ($oPlatform->getBrief() == 'ps3')
				$platforms = 'ps3';
			if ($oPlatform->getBrief() == 'ps4')
				$platforms = 'ps4';
			if ($oPlatform->getBrief() == 'xbox')
				$platforms = 'xbox';
			if ($oPlatform->getBrief() == 'pc')
				$platforms = 'EA';
			$this->Viewer_Assign('platforms', $platforms);
			
			$Tag = '';
			if ($platforms == 'ps3')
				$Tag = 'PSN ID';
			if ($platforms == 'ps4')
				$Tag = 'PSN ID';
			if ($platforms == 'xbox')
				$Tag = 'GameTag';
			if ($platforms == 'EA')
				$Tag = 'EA';
			$this->Viewer_Assign('Tag', $Tag);
			
			$aZayvkok = $this->PluginVs_Stat_Zayavok($this->oTournament->getTournamentId());
			$this->Viewer_Assign('Zayavok', $aZayvkok);
			$aTeamZayvkok = $this->PluginVs_Stat_TeamZayavok($this->oTournament->getTournamentId());
			$this->Viewer_Assign('TeamZayavok', $aTeamZayvkok);
			
			
			if ($this->oTournament->getKnownTeams()==3){
				$aTeamInTournament = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
					'tournament_id' => $this->oTournament->getTournamentId(),
					'#with' => array('user1')
				));
				$this->Viewer_Assign('aTeamInTournament', $aTeamInTournament);
			}
			
			
			if ($this->User_IsAuthorization()) {
				if ($HasTeams = $this->PluginVs_Stat_GetTeamsintournamentItemsByFilter(array(
					'tournament_id' => $this->oTournament->getTournamentId(),
					'player_id' => $this->oUserCurrent->GetUserId()
				))) {
					$this->Viewer_Assign('HasTeam', 1);
				}
			}
		}
    }
    protected function EventMainPageTournament()
    {
        $this->sMenuSubItemSelect = "index";
        $iPage                    = 1;
        if (Router::GetParam(0)) {
            if (substr(Router::GetParam(0), 0, 4) == 'page') {
                $iPage = substr(Router::GetParam(0), 4, strlen(Router::GetParam(0)) - 4);
            }
        }
        $aResult = $this->PluginVs_Stat_GetTopicsByTournament($iPage, 10, $this->oTournament->getTournamentId());
        
        $aTopics = $aResult['collection'];
        /**
         * Формируем постраничность
         */
        
        $aPaging = $this->Viewer_MakePaging($aResult['count'], $iPage, 10, 4, $this->oTournament->getUrlFull());
        /**
         * Загружаем переменные в шаблон
         */
        $this->Viewer_Assign('aTopics', $aTopics);
        $this->Viewer_Assign('aPaging', $aPaging);
		
		$Indexmatches = $this->PluginVs_Stat_StreamReadMainPage( 10, 0, $this->oTournament->getTournamentId() , 0, 0,  /*1*/ 0, 0); 
		$this->Viewer_Assign('Indexmatches', $Indexmatches);
		
		
		
        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('tournament_main');
    }
    protected function EventDenied() {
        $this->Message_AddErrorSingle('Something wrong', 'Hmm');
        return Router::Action('error');
    }
	protected function EventDeniedNotRegister() {
        $this->Message_AddErrorSingle('Вам необходимо зайти под свои логином. Если вы не зарегистрированы пройдите сначала регистрацию.', 'Вы не авторизованны');
        return Router::Action('error');
    }
	
    /**
     * При завершении экшена загружаем в шаблон необходимые переменные
     *
     */
    public function EventShutdown()
    {
        /**
         * Загружаем переменные в шаблон
         */
        $this->Viewer_Assign('sMenuHeadItemSelect', $this->sMenuHeadItemSelect);
        $this->Viewer_Assign('sMenuItemSelect', $this->sMenuItemSelect);
        $this->Viewer_Assign('sMenuSubItemSelect', $this->sMenuSubItemSelect);
        $this->Viewer_Assign('oTournament', $this->oTournament);
		$this->Viewer_Assign('oBlog', $this->oTournament->getBlog());
		$this->Viewer_Assign('oGame', $this->oGame);
		$this->Viewer_Assign('tournament_id', $this->oTournament->getTournamentId());
		$this->Viewer_Assign('myteam', $this->myTeam);
		$this->Viewer_Assign('myteamtournament', $this->myTeamTournament);		
		$this->Viewer_Assign('oUserCurrent', $this->oUserCurrent);
		
		if ($this->oUserCurrent) {
			$login=$this->oUserCurrent->getLogin();
		} else {
			$login='';
		}
		$this->Viewer_Assign('login',$login);
		
    }
}