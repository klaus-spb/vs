<?php

class PluginVs_WidgetIndextournament extends Widget {
    public function Exec() {
		
		$blog_id = 0;
		$tournaments = 15;
		

		
		if( $this->GetParam('oBlog') ){
			$oBlog=$this->GetParam('oBlog');
			$blog_id = $oBlog->getBlogId();
		}
		
		if( $this->GetParam('num') ){
			$tournaments=$this->GetParam('num');
		}
		
		$aTournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array(
			'blog_id' => $blog_id, 
			'#order' =>array('zavershen'=>'asc','datestart'=>'desc'),
			'#limit' =>array('0',$tournaments),
		));
		
		
		//if($oTournament)
		//$Indexmatches = $this->PluginVs_Stat_StreamReadMainPage($matches, 0, $oTournament->getTournamentId() , 0, 0,  /*1*/ 0, $blog_id); 
		
		 
		//PluginFirephp::GetLog($oBlog);
				
		$this->Viewer_Assign('aTournaments', $aTournaments);
		//$this->Viewer_Assign('oTournament', $oTournament);
		 
    }
}
?>