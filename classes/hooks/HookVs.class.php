<?php
/*
 * Пример файла хуков
 *
 */

class PluginVs_HookVs extends Hook { 
	
	
	public function RegisterHook() {
		 
		$this->AddHook('template_profile_whois_item', 'ProfileTournamentInfo', __CLASS__,103); 
		$this->AddHook('template_profile_whois_item', 'ProfileTournamentInfoTeamplay', __CLASS__,102);
	//	$this->AddHook('template_topic_show_before', 'BeforeTopic', __CLASS__,1); 
		$this->AddHook('template_profile_whois_item_medals', 'ProfileMedalsInfo', __CLASS__,101); 
	//	$this->AddHook('template_second_menu', 'SecondMenu', __CLASS__,1); 
	//	$this->AddHook('template_turnir_menu', 'TurnirMenu', __CLASS__,1); 
	//	$this->AddHook('template_spisok_turnirov', 'SpisokTurnirov', __CLASS__,1); 
	//	$this->AddHook('template_form_settings_tuning_end', 'SiteSettings', __CLASS__,1); 
	//	$this->AddHook('template_spisok_igr', 'SpisokIgr', __CLASS__,1); 
		$this->AddHook('topic_show', 'TopicShow', __CLASS__,1); 
		$this->AddHook('topic_add_after', 'TopicSave', __CLASS__);
		$this->AddHook('topic_edit_after', 'TopicSave', __CLASS__);
		$this->AddHook('team_show', 'TeamShow', __CLASS__,1); 
		$this->AddHook('forum_show', 'ForumShow', __CLASS__,1); 
		$this->AddHook('forum_topic_show', 'ForumTopicShow', __CLASS__,1); 
		$this->AddHook('init_action', 'InitAction');
		
		$this->AddHook('template_form_add_blog_end', 'AddBlogChoose', __CLASS__);
		$this->AddHook('template_form_add_blog_end_bottom', 'AddBlogLogos', __CLASS__);
		//$this->AddHook('template_leagues_top_right', 'AddLeaguesLogosOnTop', __CLASS__);
		$this->AddHook('blog_add_after','SaveBlog');
		$this->AddHook('blog_edit_after','SaveBlog');
		//$this->AddHook('template_write_item','WriteItem');

		$this->AddHook('template_block_stream_nav_item','BlockStreamNav', __CLASS__,-1);
		
		$this->AddHook('template_admin_menu_items_end', 'hook_admin_menu');
		$this->AddHook('template_form_add_topic_topic_end', 'AddTopicForm', __CLASS__);
		$this->AddHook('topic_edit_show', 'TopicEdit', __CLASS__);
		$this->AddHook('comment_add_after', 'CommentAdd', __CLASS__,110 );
		
		$this->AddHook('template_game_menu', 'GameMenu', __CLASS__,1);
		$this->AddHook('template_alert', 'Alert', __CLASS__,1); 
		
		$this->AddHook('template_profile_sidebar_menu_item_first', 'ProfileSidebarMenuFirst', __CLASS__,1); 
		
		$this->AddHook('engine_init_complete', 'Initer');
		

	}
	public function Initer(){
		$login = '';
		$this->oUserCurrent=$this->User_GetUserCurrent();
		if($this->oUserCurrent){
			$login=$this->oUserCurrent->getUserLogin();
		}
		$sql="insert tis_visit select NULL, '".date("Y-m-d H:i:s")."', '".F::GetUserIp()."', '".$login."', 'http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]', '$_SERVER[HTTP_USER_AGENT]'";
		$this->PluginVs_Stat_GetAll($sql);
	}
	
	public function ProfileSidebarMenuFirst($aVars) {
		$oUserProfile = $aVars['oUserProfile'];
		if( $aTopicInterviews = $this->PluginVs_Stat_GetTopicInterviewItemsByFilter(array(
			'user_id' => $oUserProfile->getUserId(),
			'site' => Config::Get('sys.site')
		//	'#with' => array('topic')
			))
		) {  
			$this->Viewer_Assign('aTopicInterviews',$aTopicInterviews);				
		}
		if($aPlayercards=$this->PluginVs_Stat_GetPlayercardItemsByFilter(array(
			'user_id' => $oUserProfile->getId(),
			//'#with'         => array('platform'),
			//'#order'         => array('playercard_id'=>'desc') 						
			)) 
		) {
			$this->Viewer_Assign('aPlayercards',$aPlayercards);
		}
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject.profile.menu.tpl');
	}
	
		
		
	public function CommentAdd($aVars) {
		$oCommentNew = $aVars['oCommentNew'];
		$oTopic = $aVars['oTopic'];
		$this->Comment_SetCommentNum($oCommentNew, ($oTopic->getCountComment()+1) );
		$this->Topic_SetLastComment($oTopic->getId(), $oCommentNew->getId() );
	}
	
	public function AddTopicForm() { 
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject.topic.form.tpl');
	}
	public function TopicEdit($aVars) {
		$oTopic=$aVars['oTopic'];
		
		if( $aTopicInterviews = $this->PluginVs_Stat_GetTopicInterviewItemsByFilter(array(
				'topic_id' => $oTopic->getTopicId(),
				'#with' => array('user')
				))
			) {  
				$this->Viewer_Assign('aTopicInterviews',$aTopicInterviews);				
			}
			
		$this->Viewer_Assign('oTopicEdit',$oTopic);
	}
	
	public function hook_admin_menu() { 
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'admin_menu.tpl');
    }
	
	public function  AddLeaguesLogosOnTop() {
		//print_r( Config::Get('plugin.vs.ligi') );
		$aBlogs = $this->Blog_GetBlogsByFilter(array('in_url'=>Config::Get('plugin.vs.ligi')),array('blog_rating'=>'desc'),1,20);
		$this->Viewer_Assign('aBlogs',$aBlogs['collection']);

		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'leagues_top_right.tpl');
	}
	public function  AddBlogLogos($aParams) {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'blog_form_bottom.tpl');
	}
	public function SaveBlog($aParams) {
		$oBlog=$aParams['oBlog'];
		
		if (isset($_REQUEST['blog_team'])) {
			$oBlog->setTeam(1); 
		} else {
			$oBlog->setTeam(0); 
		}
		
		if (isset($_REQUEST['blog_league'])) {
			$oBlog->setLeague(1); 
		} else {
			$oBlog->setLeague(0); 
		}		
		$this->Blog_SetTeamLeague($oBlog);
		
		$sql="select blog_url from ".Config::Get('db.table.blog')."  where team=1";
		$teams=$this->PluginVs_Stat_GetAll($sql); 
		$to_text_array=array();
		foreach($teams as $team){
			$to_text_array[]=strtolower($team['blog_url']);
		}
		if(Config::Get('sys.site')=='vs')$file = '/www/virtualsports.ru/plugins/vs/config/teams.ttp';
		if(Config::Get('sys.site')=='ch')$file = '/www/consolehockey.com/plugins/vs/config/teams.ttp';
		if (file_exists($file)) { 
			$fp = fopen($file,'w');  
			fwrite($fp, implode(",", $to_text_array));
			fclose($fp);
		}
		
		$sql="select blog_url from ".Config::Get('db.table.blog')."  where league=1";
		$leagues=$this->PluginVs_Stat_GetAll($sql);
		$to_text_array=array();
		foreach($leagues as $league){
			$to_text_array[]=strtolower($league['blog_url']);
		}
		if(Config::Get('sys.site')=='vs')$file = '/www/virtualsports.ru/plugins/vs/config/leagues.ttp';
		if(Config::Get('sys.site')=='ch')$file = '/www/consolehockey.com/plugins/vs/config/leagues.ttp';
		if (file_exists($file)) { 
			$fp = fopen($file,'w');  
			fwrite($fp, implode(",", $to_text_array));
			fclose($fp);
		}
		
		return;
	}
	public function AddBlogChoose(){
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'blog_form.tpl');
	}
	public function WriteItem() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'write_item.tpl');
	}
	public function BlockStreamNav() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'stream_nav.tpl');
	}
	public function InitAction()
    {
		If (Router::GetActionEvent() && substr(Router::GetActionEvent(),0,4)=='page'){
			$nomer = substr(Router::GetActionEvent(), 4, strlen(Router::GetActionEvent())-4);
			if($nomer>1)$this->Viewer_AddHtmlTitle("Страница ".$nomer); 
		}
		If (Router::GetParam(0) && substr(Router::GetParam(0),0,4)=='page'){
			$nomer = substr(Router::GetParam(0), 4, strlen(Router::GetParam(0))-4);
			if($nomer>1)$this->Viewer_AddHtmlTitle("Страница ".$nomer); 
		}	
	}
	
	public function TopicSave($aVars)
    {
		$oTopic = $aVars['oTopic'];
		$tournament_id = 0;
		if (isset($_REQUEST['tournament_id'])) {
			 $tournament_id = intval($_REQUEST['tournament_id']);
		}
		
		$Result = $this->Topic_UpdateTopicTournament($oTopic, $tournament_id);
		
		$slider_add=0;
		$sticky=0;
		$faq=0;
		
		if (getRequest('topic_slider_add')) {
			$slider_add = 1;
		}
		if (getRequest('topic_sticky')) {
			$sticky = 1;
		}
		if (getRequest('topic_faq')) {
			$faq = 1;
		}
		if (getRequest('topic_interviews') || getRequest('topic_interviews')=='') {
			if( $aTopicInterviews = $this->PluginVs_Stat_GetTopicInterviewItemsByFilter(array(
				'topic_id' => $oTopic->getTopicId()
				))
			) {  
				foreach($aTopicInterviews as $oTopicInterview){
					$oTopicInterview->Delete();
				}				
			}
			$sUsers = getRequest('topic_interviews');
			$aUsers = explode(',', (string)$sUsers);
			foreach ($aUsers as $sUser) {
				$sUser = trim($sUser);
				
				if ($oUser = $this->User_GetUserByLogin($sUser)) {
					$oTopicInterview =  Engine::GetEntity('PluginVs_Stat_TopicInterview');
					$oTopicInterview->setTopicId($oTopic->getTopicId());
					$oTopicInterview->setUserId($oUser->getUserId());
					$oTopicInterview->setSite(Config::Get('sys.site'));					
					$oTopicInterview->Add();					
				}
			}		
		}
		if( ($oTopic->getSliderAdd()?1:0) != $slider_add){		
			$Result = $this->Topic_UpdateTopicSetSlider($oTopic,$slider_add);
		}
		if( $oTopic->getSticky() != $sticky ){		
			$Result = $this->Topic_UpdateTopicSetSticky($oTopic,$sticky);
		}
		if( $oTopic->getFaq() != $faq ){		
			$Result = $this->Topic_UpdateTopicSetFaq($oTopic,$faq);
		}
		$Result = $this->Topic_UpdateTopicSetTopBlogId($oTopic, $this->Blog_GetTopParentId($oTopic->getBlogId()) );
		/*$aTopics = $this->Topic_GetTopicsByFilter(array('not_blog_id'=>0), 1, 1000);
		$aTopics  = $aTopics['collection'];
		foreach($aTopics as $oTopic){
			if(isset($oTopic) && $oTopic  )
			$Result = $this->Topic_UpdateTopicSetTopBlogId($oTopic, $this->Blog_GetTopParentId($oTopic->getBlogId()) );
		}
		$aTopics = $this->Topic_GetTopicsByFilter(array(), 2, 1000);
		foreach($aTopics as $oTopic){
			if(is_object($oTopic))$Result = $this->Topic_UpdateTopicSetTopBlogId($oTopic, $this->Blog_GetTopParentId($oTopic->getBlogId()) );
		}
		$aTopics = $this->Topic_GetTopicsByFilter(array(), 3, 1000);
		foreach($aTopics as $oTopic){
			if(is_object($oTopic))$Result = $this->Topic_UpdateTopicSetTopBlogId($oTopic, $this->Blog_GetTopParentId($oTopic->getBlogId()) );
		}
		$aTopics = $this->Topic_GetTopicsByFilter(array(), 4, 1000);
		foreach($aTopics as $oTopic){
			if(is_object($oTopic))$Result = $this->Topic_UpdateTopicSetTopBlogId($oTopic, $this->Blog_GetTopParentId($oTopic->getBlogId()) );
		}
		$aTopics = $this->Topic_GetTopicsByFilter(array(), 5, 1000);
		foreach($aTopics as $oTopic){
			if(is_object($oTopic))$Result = $this->Topic_UpdateTopicSetTopBlogId($oTopic, $this->Blog_GetTopParentId($oTopic->getBlogId()) );
		}
		$aTopics = $this->Topic_GetTopicsByFilter(array(), 6, 1000);
		foreach($aTopics as $oTopic){
			if(is_object($oTopic))$Result = $this->Topic_UpdateTopicSetTopBlogId($oTopic, $this->Blog_GetTopParentId($oTopic->getBlogId()) );
		}
		$aTopics = $this->Topic_GetTopicsByFilter(array(), 7, 1000);
		foreach($aTopics as $oTopic){
			if(is_object($oTopic))$Result = $this->Topic_UpdateTopicSetTopBlogId($oTopic, $this->Blog_GetTopParentId($oTopic->getBlogId()) );
		}
		*/
    }
	public function ForumShow($aVars){
		if(isset($aVars['oForum'])){
			$oForum=$aVars['oForum'];	
			if($oForum->getTeamId()<>0){
				$oTeam=$this->PluginVs_Stat_GetTeamByTeamId($oForum->getTeamId());
				if(Config::Get('sys.site')=='vs' )$oBlog=$this->Blog_GetBlogById($oTeam->getBlogVsId());
				if(Config::Get('sys.site')=='ch' )$oBlog=$this->Blog_GetBlogById($oTeam->getBlogChId());
				$this->Viewer_Assign('oBlog',$oBlog);
				$this->Viewer_Assign('team_page',1);			
			}
		}		
	}
	public function ForumTopicShow($aVars){
		if(isset($aVars['oTopic'])){
			$oForum=$aVars['oTopic']->getForum();	
			if($oForum->getTeamId()<>0){
				$oTeam=$this->PluginVs_Stat_GetTeamByTeamId($oForum->getTeamId());
				$oBlog=$this->Blog_GetBlogById($oTeam->getBlogId());
				$this->Viewer_Assign('oBlog',$oBlog);
				$this->Viewer_Assign('team_page',1);			
			}
		}		
	}
	public function TeamShow($aVars){

		if(isset($aVars['oBlog'])){
			$oBlog=$aVars['oBlog'];			
			$tournament_id=65; 
		}
			
		
		$this->oUserCurrent=$this->User_GetUserCurrent();
		$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($tournament_id); 
		
		$team_id=0;
		if($oBlog && $oBlog->getTeamId()!=0)$team_id=$oBlog->getTeamId();	 
		if($team_id){
			$oTeam=$this->PluginVs_Stat_GetTeamByTeamId($team_id);
			
			$sql="select max(tournament_id) as tournament_id from tis_stat_teamsintournament where team_id='".$team_id."'";
			$tournaments=$this->PluginVs_Stat_GetAll($sql);
			if($tournaments){
				$tournament_id=$tournaments[0]['tournament_id'];	 
			}
			$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($tournament_id); 
		}
		if(isset($oTeam)){
			$this->Viewer_Assign('oTeam', $oTeam );
			$this->Viewer_Assign('oBlog',$oBlog);
		} 
		if($oTournament){ 
			$this->Viewer_Assign('tournament',1);
			$this->Viewer_Assign('no_opisanie',1);
			
			$this->Viewer_Assign('tournament_id',$tournament_id);	 
			$domain='';
			$sPrimaryHost=str_replace('http://','',DIR_WEB_ROOT);
			if (SUBDOMAIN!=''){
				$domain="http://".SUBDOMAIN.".".$sPrimaryHost.'/';
			}else{
				$domain=DIR_WEB_ROOT;
			}
			
			$this->Viewer_Assign('link_zayavki', $domain."tournament/".$oTournament->getUrl()."/_uchastniki/zayavki/");
			
			//$this->Viewer_AddBlock('right','tournamentdescription',array('plugin'=>'vs', 'oTournament'=>$oTournament),999);	
			$this->Viewer_AddWidget('right','tournamentsheduleloader',array('plugin'=>'vs', 'oTournament'=>$oTournament,'myteam'=>$team_id),203);
			
			$this->Viewer_AddWidget('right','tournamentteamtable',array('plugin'=>'vs', 'oTournament'=>$oTournament),202);

		}
		$this->Viewer_AddWidget('right','stream',array(),200);
		
	}
	
	public function TopicShow($aVars){
		$this->oUserCurrent = $this->User_GetUserCurrent();
		$oTopic=$aVars['oTopic']; 
		$tournament_id=$oTopic->GetTournamentId();
		$oBlog = $oTopic->getBlog();
		
		$this->Viewer_Assign('oBlog', $oBlog);
		
		if($tournament_id){
			$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($tournament_id);
			$this->Viewer_AddWidget('main','tournamentmenu',array('plugin'=>'vs', 'oTournament'=>$oTournament),999);
		
		$this->Viewer_Assign('oTournament', $oTournament);
		/*
		$this->Viewer_Assign('sMenuHeadItemSelect', 'tournament');
        $this->Viewer_Assign('sMenuItemSelect', 'tournament');
        $this->Viewer_Assign('sMenuSubItemSelect', 'all');
        $this->Viewer_Assign('oTournament', $oTournament);
		
		$this->sMenuHeadItemSelect = 'tournament';
        $this->sMenuItemSelect = 'tournament';
        $this->sMenuSubItemSelect = 'all';
		*/
		
			$this->Viewer_AddWidget('right','tournamentdescription',array('plugin'=>'vs', 'oTournament'=>$oTournament),999);	
			$this->Viewer_AddWidget('right','tournamentsheduleloader',array('plugin'=>'vs', 'oTournament'=>$oTournament),203);
			$this->Viewer_AddWidget('right','tournamentteamtable',array('plugin'=>'vs', 'oTournament'=>$oTournament),202);
			
			if($this->oUserCurrent && ($this->oUserCurrent->isAdministrator() || $this->PluginVs_Stat_IsTournamentAdmin($oTournament)))$this->Viewer_Assign('admin','yes');
		
		
			$sql="select distinct 1 from tis_stat_playoff where tournament_id=".$oTournament->getTournamentId();
			if($this->PluginVs_Stat_GetAll($sql))$this->Viewer_Assign('po',1);
		}
		/*$oBlog=$oTopic->getBlog();
	 
		$oTournament=$this->PluginVs_Stat_GetTournamentByTournamentId($tournament_id);
		
		
		$team_id=0;
		if($oBlog && $oBlog->getTeamId()!=0)$team_id=$oBlog->getTeamId();	 
		if($team_id)$oTeam=$this->PluginVs_Stat_GetTeamByTeamId($team_id);	
		if(isset($oTeam)){
			$this->Viewer_Assign('oTeam', $oTeam );
			$this->Viewer_Assign('oBlog',$oBlog);
		}
		
		if($oTournament){ 
			$this->Viewer_Assign('tournament_id',$tournament_id);	 
			$domain='';
			$sPrimaryHost=str_replace('http://','',DIR_WEB_ROOT);
			if (SUBDOMAIN!=''){
				$domain="http://".SUBDOMAIN.".".$sPrimaryHost.'/';
			}else{
				$domain=DIR_WEB_ROOT;
			}
			
			$this->Viewer_Assign('link_zayavki', $domain."turnir/".$oTournament->getUrl()."/_uchastniki/zayavki/");
			
			$this->Viewer_AddBlock('right','tournamentdescription',array('plugin'=>'vs', 'oTournament'=>$oTournament),999);	
			$this->Viewer_AddBlock('right','tournamentsheduleloader',array('plugin'=>'vs', 'oTournament'=>$oTournament),203);
			$this->Viewer_AddBlock('right','tournamentteamtable',array('plugin'=>'vs', 'oTournament'=>$oTournament),202);

		}
		*/
		
	}
	public function SpisokIgr(){
	
		$aGames= $this->PluginVs_Stat_GetGameItemsByFilter(array(
			'on_front_page' => '1', 
			'#order' =>array('game_id'=>'desc'),
			'#limit' =>array('0','10')));
			
		$this->Viewer_Assign('aGames',$aGames);					
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'spisok_igr.tpl');
	}
	
	

	public function TurnirMenu(){
		$this->oUserCurrent=$this->User_GetUserCurrent();
		if($this->User_IsAuthorization()){
			
			if (false === ($aTournaments = $this->Cache_Get("my_turnirs_".$this->oUserCurrent->GetUserId()))) {
				$sql="SELECT t.tournament_id
				FROM tis_stat_teamsintournament tt, tis_stat_tournament t
				WHERE tt.player_id =  '".$this->oUserCurrent->GetUserId()."'
					AND t.zavershen =  '0'
					AND t.tournament_id = tt.tournament_id
				union
				SELECT t.tournament_id
				FROM tis_stat_playertournament pt, tis_stat_tournament t
				WHERE pt.user_id =  '".$this->oUserCurrent->GetUserId()."'
					AND pt.team_id <> 0
					AND t.zavershen =  '0'
					AND t.tournament_id = pt.tournament_id
				union
				SELECT t.tournament_id
				FROM tis_stat_tournamentadmin ta, tis_stat_tournament t
				WHERE ta.user_id =  '".$this->oUserCurrent->GetUserId()."'
					AND t.zavershen =  '0'
					AND t.tournament_id = ta.tournament_id";
				$aTournaments=$this->PluginVs_Stat_GetAll($sql);
				$this->Cache_Set($aTournaments, "my_turnirs_".$this->oUserCurrent->GetUserId(), array("PluginVs_ModuleStat_EntityPlayertournament_save","PluginVs_ModuleStat_EntityTeamsintournament_save"), 60*60*6);
			}	
			$tournament=array();
			if($aTournaments){
				foreach($aTournaments as $oTournament){
					$tournament[]=$oTournament['tournament_id'];
				}
				$mytournaments=1;
				if( $Tournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array(
					'tournament_id in' => $tournament,
					'zavershen' => '0',
					'#with'         => array('blog'),
					'#order' =>array('datestart'=>'asc'),
					'#limit' =>array('0','10')
				))
					)
				{  	
					$this->Viewer_Assign('Tournaments',$Tournaments);
					$this->Viewer_Assign('li_elements',count($Tournaments)); 
					$this->Viewer_Assign('sTournaments',$sTextResult);
					$this->Viewer_Assign('mytournaments',$mytournaments); 
					return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'turnir_menu.tpl');
				}				
			}
		}
	}
	
	public function SpisokTurnirov(){
		$this->oUserCurrent=$this->User_GetUserCurrent();
		if($this->User_IsAuthorization()){
			
			if (false === ($aTournaments = $this->Cache_Get("my_turnirs_".$this->oUserCurrent->GetUserId()))) {
				$sql="SELECT t.tournament_id
				FROM tis_stat_teamsintournament tt, tis_stat_tournament t
				WHERE tt.player_id =  '".$this->oUserCurrent->GetUserId()."'
					AND t.zavershen =  '0'
					AND t.tournament_id = tt.tournament_id
				union
				SELECT t.tournament_id
				FROM tis_stat_playertournament pt, tis_stat_tournament t
				WHERE pt.user_id =  '".$this->oUserCurrent->GetUserId()."'
					AND pt.team_id <> 0
					AND t.zavershen =  '0'
					AND t.tournament_id = pt.tournament_id
				union
				SELECT t.tournament_id
				FROM tis_stat_tournamentadmin ta, tis_stat_tournament t
				WHERE ta.user_id =  '".$this->oUserCurrent->GetUserId()."'
					AND t.zavershen =  '0'
					AND t.tournament_id = ta.tournament_id";
				$aTournaments=$this->PluginVs_Stat_GetAll($sql);
				$this->Cache_Set($aTournaments, "my_turnirs_".$this->oUserCurrent->GetUserId(), array("PluginVs_ModuleStat_EntityPlayertournament_save","PluginVs_ModuleStat_EntityTeamsintournament_save"), 60*60*6);
			}	
			$tournament=array();
			if($aTournaments){
				foreach($aTournaments as $oTournament){
					$tournament[]=$oTournament['tournament_id'];
				}
				$mytournaments=1;
				if( $Tournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array(
					'tournament_id in' => $tournament,
					'zavershen' => '0',
					'#with'         => array('blog'),
					'#order' =>array('datestart'=>'asc'),
					'#limit' =>array('0','10')
				))
					)
				{  	
					$this->Viewer_Assign('Tournaments',$Tournaments);
					$this->Viewer_Assign('li_elements',count($Tournaments)); 
					$this->Viewer_Assign('sTournaments',$sTextResult);
					$this->Viewer_Assign('mytournaments',$mytournaments); 
					return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'spisok_turnirov.tpl');
				}				
			}
		}
	}
	
	public function GameMenu(){
		
		$this->oUserCurrent=$this->User_GetUserCurrent();
		
		if(Config::Get('sys.site')=='vs') {
			$sports = array();
			$sports[1]='1007';
			$sports[2]='1011';
			$sports[5]='1014';
			$sports[6]='1221';
			
			$sports[3]='718';
			
			
			$sports_name = array();
			$sports_name[1]='Хоккей';
			$sports_name[2]='Футбол';
			$sports_name[5]='НФЛ';
			$sports_name[6]='ММА';
			$sports_name[3]='НБА';
			
			if($this->User_IsAuthorization()){		
				$key_tournaments = "aMenuss_user_".$this->oUserCurrent->GetUserId();
			}else{
				$key_tournaments = "aMenuss_user_0";
			}
			$key_topics = "aMenuss_topics";
			
			// if (false === ($aMenus = $this->Cache_Get($key))) {		
				
			if (false === ($aMenus_topics = $this->Cache_Get($key_topics))) {
				$aMenus_topics = array();
				
				foreach($sports as $key=>$value){
					$aTopics_faq = null;
					$aFilter = array('top_blog_id' => $value, 'faq'=>1, 'order'=> array('rand()') );
					
					$aTopics = $this->Topic_GetTopicsByFilter($aFilter, 1, 6, array('blog'));
					//$aMenus_topics[$key]['faq'][] = $aTopics['collection'];
					
					foreach($aTopics['collection'] as $oTopic){
						$aTopics_faq[] = array('url'=>$oTopic->getUrl(), 'title'=> $oTopic->getTitle());
					}
					$aMenus_topics[$key]['faq_topics'][] = $aTopics_faq;
				}
				$this->Cache_Set($aMenus_topics, $key_topics, array("PluginVs_ModuleStat_EntityTournament_save"), 60*60*24);
			}	
			ksort($aMenus_topics);
			
			if (false === ($aMenus_tournaments = $this->Cache_Get($key_tournaments))) {
			
				$myTournaments = $this->PluginVs_Stat_GetMyTournaments();
				
				$aTournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array( 
					'zavershen' => '0',
					'site' => Config::Get('sys.site'),
					'#with' => array('game'),
					'#order' =>array('datestart'=>'asc')) );
				
				
				foreach($aTournaments as $oTournament){
					if(in_array($oTournament->getGame()->getSportId(), array(1,2,5,6,3)))
					{
						if($oTournament->getDatestart() > date('Y-m-d')){
							$aMenus_tournaments[$oTournament->getGame()->getSportId()]['future'][]=$oTournament;
						}else{
							$aMenus_tournaments[$oTournament->getGame()->getSportId()]['actual'][]=$oTournament;
						}

						if(in_array( $oTournament->getTournamentId(),$myTournaments) ){
							$aMenus_tournaments[$oTournament->getGame()->getSportId()]['my'][]=$oTournament;			
						}	
					}
				}
				$this->Cache_Set($aMenus_tournaments, $key_tournaments, array("PluginVs_ModuleStat_EntityTournament_save"), 60*60*24);
			}
			//$aMenus = array_merge($aMenus_tournaments, $aMenus_topics);
				//$this->Cache_Set($aMenus, $key, array("PluginVs_ModuleStat_EntityTournament_save"), 60*60*24);
			// }
		}else{
			$sports = array();
			$sports[1]='6';
			$sports[2]='7';
			
			$sports_name = array();
			$sports_name[1]='Playstation 3';
			$sports_name[2]='Xbox 360'; 
			
			if($this->User_IsAuthorization()){		
				$key_tournaments ="aMenuss_user_".$this->oUserCurrent->GetUserId();
			}else{
				$key_tournaments ="aMenuss_user_0";
			}
			$key_topics = "aMenuss_topics";
			
			if (false === ($aMenus_topics = $this->Cache_Get($key_topics))) {
				
				$aMenus_topics = array();	
				
				foreach($sports as $key=>$value){
					$aFilter = array('top_blog_id' => $value, 'faq'=>1, 'order'=> array('rand()') );
					
					$aTopics = $this->Topic_GetTopicsByFilter($aFilter, 1, 6, array('blog'));
					//$aMenus_topics[$key]['faq'][] = $aTopics['collection'];
					
					foreach($aTopics['collection'] as $oTopic){
						$aTopics_faq[] = array('url'=>$oTopic->getUrl(), 'title'=> $oTopic->getTitle());
					}
					$aMenus_topics[$key]['faq_topics'][] = $aTopics_faq;
					
				}
				$this->Cache_Set($aMenus_topics, $key_topics, array("PluginVs_ModuleStat_EntityTournament_save"), 60*60*24);
			}
			
			if (false === ($aMenus_tournaments = $this->Cache_Get($key_tournaments))) {
			
				$myTournaments = $this->PluginVs_Stat_GetMyTournaments();
				
				$aTournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array( 
					'zavershen' => '0',
					'site' => Config::Get('sys.site'),
					'#with' => array('game'),
					'#order' =>array('datestart'=>'asc')) );
				
				
				foreach($aTournaments as $oTournament){
					if(in_array($oTournament->getGame()->getPlatformId(), array(1,2)))
					{
						if($oTournament->getDatestart() > date('Y-m-d')){
							$aMenus_tournaments[$oTournament->getGame()->getPlatformId()]['future'][]=$oTournament;
						}else{
							$aMenus_tournaments[$oTournament->getGame()->getPlatformId()]['actual'][]=$oTournament;
						}

						if(in_array( $oTournament->getTournamentId(),$myTournaments) ){
							$aMenus_tournaments[$oTournament->getGame()->getPlatformId()]['my'][]=$oTournament;			
						}	
					}
				}
				
				$this->Cache_Set($aMenus_tournaments, $key_tournaments, array("PluginVs_ModuleStat_EntityTournament_save"), 60*60*24);
			}
			
		
		}

		
		$this->Viewer_Assign('sports_name',$sports_name); 
		$this->Viewer_Assign('aMenus_topics',$aMenus_topics);
		$this->Viewer_Assign('aMenus_tournaments',$aMenus_tournaments);
			
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'game_menu.tpl');
	
	
	}
	
	public function Alert(){
		$this->oUserCurrent=$this->User_GetUserCurrent();
		if($aAdvert = $this->PluginVs_Stat_GetAdvertItemsAll()) {
			$oAdvert = $aAdvert[0];
			
			$this->Viewer_Assign('oAdvert',$oAdvert);
			
			return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'hook_alert.tpl');
		}
	}
	
	
	public function SecondMenu(){
	 
		//$oViewer=$this->Viewer_GetLocalViewer();
		$mytournaments=0;
		$this->oUserCurrent=$this->User_GetUserCurrent();
		if($this->User_IsAuthorization()){
			$sql="select tournament_id from tis_stat_teamsintournament where player_id='".$this->oUserCurrent->GetUserId()."'";
			$aTournaments=$this->PluginVs_Stat_GetAll($sql);
			$tournament=array();
			if($aTournaments){
				foreach($aTournaments as $oTournament){
					$tournament[]=$oTournament['tournament_id'];
				}
				$mytournaments=1;
				if( $Tournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array( 
					'tournament_id in' => $tournament,
					'zavershen' => '0',
					'#with'         => array('gametype','blog','game'),
					'#order' =>array('datestart'=>'asc'),
					'#limit' =>array('0','10')
				))
					)
				{ 
					$this->Viewer_Assign('Tournaments',$Tournaments); 
					$this->Viewer_Assign('sTournaments',$sTextResult);
					$this->Viewer_Assign('mytournaments',$mytournaments);
					return $this->Viewer_Fetch('widget.turnirs_my.tpl');
				}
				
			}else{
				if( $Tournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array(
					'datestart >' => date("Y-m-d"),	
					'#with'         => array('gametype','blog','game'),
					'#order' =>array('datestart'=>'asc'),
					'#limit' =>array('0','10')
				))
					)
				{
				 
					$this->Viewer_Assign('Tournaments',$Tournaments); 
					$this->Viewer_Assign('sTournaments',$sTextResult);
					$this->Viewer_Assign('mytournaments',$mytournaments);
					return $this->Viewer_Fetch('widget.turnirs_future.tpl');
				}
			}		
		}else{
			if( $Tournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array(
						'datestart >' => date("Y-m-d"),	
						'#with'         => array('gametype','blog','game'),
						'#order' =>array('datestart'=>'asc'),
						'#limit' =>array('0','10')
					))
				)
			{
			 	
				$this->Viewer_Assign('Tournaments',$Tournaments);
				//$sTextResult=$oViewer->Fetch("block.turnirs_future.tpl");
				$this->Viewer_Assign('sTournaments',$sTextResult);
				$this->Viewer_Assign('mytournaments',$mytournaments);
				 
				return $this->Viewer_Fetch('widget.turnirs_future.tpl');
			}	
		}
	
	}
	public function ProfileTournamentInfoTeamplay($aVars) { 
		if($aPlayercards=$this->PluginVs_Stat_GetPlayercardItemsByFilter(array(
			'user_id' => $aVars['oUserProfile']->getId(),
			'#with'         => array('platform'),
			'#order'         => array('playercard_id'=>'desc') 						
			)) )
		{
		
			foreach($aPlayercards as $oPlayercard){
				$aFilter= array(	
							'who'=>'all', 
							'playercard_id'=>$oPlayercard->getId(),  
							'platform_id'=>$oPlayercard->getPlatformId(), 
							'user_id'=>$oPlayercard->getUserId(), 
							'sport_id'=>$oPlayercard->getSportId(),
							'tournament_id'=>'0', 
							'gametype_id'=>'4',
							'group_by'=>array('s.tournament_id','t.team_id','m.round_id'),
							'get_team'=>'mps');
				$aStats=$this->PluginVs_Stat_PlayerStats($aFilter);
				

				$aFilter=  array(	
								'who'=>'goalkeeper', 
								'playercard_id'=>$oPlayercard->getId(),  
								'platform_id'=>$oPlayercard->getPlatformId(), 
								'user_id'=>$oPlayercard->getUserId(), 
								'sport_id'=>$oPlayercard->getSportId(),
								'tournament_id'=>'0', 
								'gametype_id'=>'4',
								'group_by'=>array('s.tournament_id','t.team_id','m.round_id'),
								'get_team'=>'mps');
								
				$aStats_Goalkeeper=$this->PluginVs_Stat_PlayerStats($aFilter);
				
				if($aStats)
				foreach($aStats as $oStat){
					$tournaments[] = $oStat['tournament_id'];
					$teams[] = $oStat['team_id'];
				}
				if($aStats_Goalkeeper)
				foreach($aStats_Goalkeeper as $oStat){
					$tournaments[] = $oStat['tournament_id'];
					$teams[] = $oStat['team_id'];
				}
				if(isset($teams)){
					$oTeams = $this->PluginVs_Stat_GetTeamItemsByFilter(array(
						'team_id in' => $teams
					));
					foreach($oTeams as $oTeam){
						$aTeams[$oTeam->getTeamId()] = $oTeam;
					}
				}
				
				if(isset($tournaments)){
					$oTournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array(
						'tournament_id in' => $tournaments
					));
					foreach($oTournaments as $oTournament){
						$aTournaments[$oTournament->getTournamentId()] = $oTournament;
					}
				}
				
				$oPlayerTournament=$this->PluginVs_Stat_GetPlayertournamentByFilter(array(
				'playercard_id' => $oPlayercard->getPlayercardId(),
				'tournament_id' => 0,
				'#with'         => array('team')					
				));
				
				$this->Viewer_Assign('oPlayercard', $oPlayercard);
				$this->Viewer_Assign('oPlayerTournament', $oPlayerTournament);
				if(isset($aTeams))$this->Viewer_Assign('aTeams', $aTeams);
				if(isset($aTournaments))$this->Viewer_Assign('aTournaments', $aTournaments);
				$this->Viewer_Assign('aPlayercards', $aPlayercards);
				
				if($aStats || $aStats_Goalkeeper) {
					$this->Viewer_Assign('aStats',$aStats);
					$this->Viewer_Assign('aStats_Goalkeeper',$aStats_Goalkeeper);
					return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'profile_tournament_info_teamplay.tpl');
				}
			}
			
			
		}
		
    }
	public function ProfileTournamentInfo($aVars) { 
		if($Playerstat = LS::E()->PluginVs_Stat_GetPlayerstatItemsByFilter(array(
				'user_id' => $aVars['oUserProfile']->getId(),
				'tournament_id <>' => 0,				
				'gametype_id <>' => 3, 
				'#where' => array('game_id not in (10,11)' => array()),	
				'#with'         => array('team','tournament', 'game', 'gametype'),
				'#order' =>array('game_id'=>'desc','tournament_id'=>'desc','round_id'=>'asc') 
			))){
			// $oViewer=$this->Viewer_GetLocalViewer();	
			// $oViewer->Assign('Playerstat',$Playerstat); 
			// $sTextResult=$oViewer->Fetch("block.playerstat_table.tpl");
			// $this->Viewer_Assign('sTextResult',$sTextResult);

			$this->Viewer_Assign('Playerstat', $Playerstat);
            return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'profile_tournament_info.tpl');
		}
		
		/*$sql="SELECT DISTINCT sp.psnid as psnid,
				sp.rating as rating,
				g.name game,
				upper(p.brief) as platform, 
				t.game_id AS game_id,
				t.tournament_id as tournament_id,
				t.name as tournament,
				b.platform as bplatform, 
				b.game as bgame, 
				b.gametype as bgametype, 
				b.blog_url as blog_url
				
				FROM `tis_stat_playertournament` sp, `tis_stat_teamsintournament` tt, `tis_stat_tournament` t, `tis_stat_game` g, `tis_stat_platform` p, `tis_blog` b
				WHERE sp.tournament_id = t.tournament_id
					AND sp.tournament_id = tt.tournament_id
					AND sp.user_id=tt.player_id
					AND t.game_id = g.game_id
					AND g.platform_id = p.platform_id
				and t.tournament_id=b.tournament_id
				and sp.user_id='".$aVars['oUserProfile']->getId()."'
				order by p.platform_id, g.game_id, t.tournament_id";
			$aGameTournament=$this->PluginVs_Stat_GetAll($sql);
			$this->Viewer_Assign('aGameTournament', $aGameTournament);
            return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'profile_tournament_info.tpl');
			*/
        }
	public function ProfileMedalsInfo($aVars) {
	

			$aMedals = $this->PluginVs_Stat_GetMedalsItemsByFilter(array(
			'user_id' => $aVars['oUserProfile']->getId(),
			 '#with'         => array('tournament', 'game')				
			));	
			$this->Viewer_Assign('aMedals', $aMedals);
			
			
            return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'profile_medals_info.tpl');
			
        }	
		
	public function SiteSettings($aVars) {
		$this->oUserCurrent=$this->User_GetUserCurrent();

		$aTournament = $this->PluginVs_Stat_GetTournamentItemsByFilter(array(  
					'zavershen' => '0', 
					'#order' =>array('game_id'=>'asc','gametype_id'=>'asc'), 
				));
		$this->Viewer_Assign('aTournament', $aTournament);
		$this->Viewer_Assign('oUserCurrent', $this->oUserCurrent);
		
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'site_settings.tpl');
		
        }	
		
	public function BeforeTopic($aVars) {
		 
			$oTopic = $aVars['topic'];
			//$oBlog = $oTopic->getBlog();
			if($oTopic->getTournamentId()>0){
			
				$this->oUserCurrent=$this->User_GetUserCurrent();
				$admin='no';
				if ($this->User_IsAuthorization()) {
					$aAdmin = $this->PluginVs_Stat_GetTournamentadminItemsByFilter(array(
						'tournament_id' => $oTopic->getTournamentId(),
						'user_id' => $this->oUserCurrent->getUserId(),
						'#page' => 'count',
						'expire >='   => date("Y-m-d")
					));
					if($aAdmin['count']>0)$admin='yes';
				}
				$this->Viewer_Assign('admin',$admin);
				$sql="select distinct 1 from tis_stat_playoff where tournament_id=".$oTopic->getTournamentId();
				if($this->PluginVs_Stat_GetAll($sql))$this->Viewer_Assign('po',1);

		$domain='';
		$sPrimaryHost=str_replace('http://','',DIR_WEB_ROOT);
		if (SUBDOMAIN!=''){
			$domain="http://".SUBDOMAIN.".".$sPrimaryHost.'/';
		}else{
			$domain=DIR_WEB_ROOT;
		}

		
			$oTournament = $this->PluginVs_Stat_GetTournamentByTournamentId ($oTopic->getTournamentId());
			
		$admin='no';
		if ($this->User_IsAuthorization()) {
            $aAdmin = $this->PluginVs_Stat_GetTournamentadminItemsByFilter(array(
				'tournament_id' => $oTournament->getTournamentId(),
				'user_id' => $this->oUserCurrent->GetUserId(),
				'#page' => 'count',
				'expire >='   => date("Y-m-d")
			));
			if($aAdmin['count']>0)$admin='yes';
			if($this->oUserCurrent->isAdministrator())$admin='yes';
        }
		$this->Viewer_Assign('admin',$admin);
		
			$this->Viewer_Assign('link', $domain."turnir/".$oTournament->getUrl()."/");
			$this->Viewer_Assign('oTournament', $oTournament);			
			$this->Viewer_Assign('link_uchastniki', $domain."turnir/".$oTournament->getUrl()."/_uchastniki/");
			$this->Viewer_Assign('link_zayavki', $domain."turnir/".$oTournament->getUrl()."/_uchastniki/zayavki/");
			$this->Viewer_Assign('link_stats', $domain."turnir/".$oTournament->getUrl()."/_stats/");
			$this->Viewer_Assign('link_player_stats', $domain."turnir/".$oTournament->getUrl()."/_player_stats/");
			$this->Viewer_Assign('link_raspisanie', $domain."turnir/".$oTournament->getUrl()."/_raspisanie/");
			$this->Viewer_Assign('link_sobytiya', $domain."turnir/".$oTournament->getUrl()."/_sobytiya/");
			$this->Viewer_Assign('link_reglament', $domain."turnir/".$oTournament->getUrl()."/_reglament/");
			$this->Viewer_Assign('link_au', $domain."turnir/".$oTournament->getUrl()."/_au/");
			$this->Viewer_Assign('link_po', $domain."turnir/".$oTournament->getUrl()."/_po/");
			$this->Viewer_Assign('link_match', $domain."turnir/".$oTournament->getUrl()."/_match/");
			
				
				
				return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'actions/ActionVs/tournament_menu.tpl');
			} 
        }	
	
}
?>