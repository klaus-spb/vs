<?php

class PluginVs_WidgetIndexmatches extends Widget {
    public function Exec() {
		
		$tournament_id = 0;
		$blog_id = 0;
		$matches = 15;
		
		if( $this->GetParam('oTournament') ){
			$oTournament=$this->GetParam('oTournament');
			$tournament_id = $oTournament->getTournamentId();
		}
		
		if( $this->GetParam('oBlog') ){
			$oBlog=$this->GetParam('oBlog');
			$blog_id = $oBlog->getBlogId();
		}
		
		if( $this->GetParam('num') ){
			$matches=$this->GetParam('num');
		}
		
		$aMatches = $this->PluginVs_Stat_GetMatchesItemsByFilter(array(
			'played' => '1',
			'#where' => array('(blog_id = (?d) or 0 = (?d) ) and (tournament_id = (?d) or 0 = (?d) )' => array($blog_id, $blog_id, $tournament_id, $tournament_id)),				
			'#with'         => array('hometeam','awayteam','tournament'),
			'#order' =>array('play_dates'=>'desc','number'=>'desc'),
			'#limit' =>array('0',$matches),
		));
		
		
		//if($oTournament)
		//$Indexmatches = $this->PluginVs_Stat_StreamReadMainPage($matches, 0, $oTournament->getTournamentId() , 0, 0,  /*1*/ 0, $blog_id); 
		
		 
		//PluginFirephp::GetLog($oBlog);
				
		$this->Viewer_Assign('aMatches', $aMatches);
		//$this->Viewer_Assign('oTournament', $oTournament);
		 
    }
}
?>