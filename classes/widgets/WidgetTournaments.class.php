<?php


/**
 * Регистрация хука
 *
 */
class PluginVs_WidgetTournaments extends Widget {
    /**
     * Запуск обработки
     */
    public function Exec() { 
		
		$blog_id = 0;
		$tournaments = 0;
		
		if( $this->GetParam('oBlog') ){
			$oBlog=$this->GetParam('oBlog');
			$blog_id = $oBlog->getBlogId();
		}
		
		if( $this->GetParam('num') ){
			$tournaments=$this->GetParam('num');
		}
		
		$aTournaments = $this->PluginVs_Stat_GetTournamentItemsByFilter(array(
			'#where' => array('(blog_id = (?d) or 0 = (?d) ) ' => array($blog_id, $blog_id)),	
			'#order' =>array('tournament_id'=>'desc'),
			'#limit' =>array('0',$tournaments),
		))
		$this->Viewer_Assign("aTournaments",$aTournaments);
		
	  
    }
}
// EOF