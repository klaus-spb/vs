<?php

class PluginVs_WidgetRating extends Widget {
    public function Exec() {
		
		$game_id = '24';
		$gametype_id = '1';
		
		$aGametypes = $this->PluginVs_Stat_GetGametypeItemsByFilter(array(
			'gametype_id' => $gametype_id
		));		
		$oGametype = $aGametypes[0];
		
		$aGames     = $this->PluginVs_Stat_GetGameItemsByFilter(array(
			'game_id' => $game_id
		));
		$oGame = $aGames[0];
		
		if( $aRatings = $this->PluginVs_Stat_GetRatingItemsByFilter(array(
				'game_id' => $game_id,
				'gametype_id' => $gametype_id,
				'user_id !='=> '0',
				'#with'         => array('user'),
				'#order' =>array('rating'=>'desc'),
				'#limit' =>array('0','10')
					
			)) ){ 
            $oViewer = $this->Viewer_GetLocalViewer();
            $oViewer->Assign('aRatings', $aRatings);
			
			$oViewer->Assign('oGametype', $oGametype);
			$oViewer->Assign('oGame', $oGame);
			
            // * Формируем результат в виде шаблона и возвращаем
            $sTextResult = $oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__).'widgets/widget.ratings.tpl');
            $this->Viewer_Assign('sRatings', $sTextResult);
        }
		
		// if( $aPlayercard_temp = $this->PluginVs_Stat_GetPlayercardItemsByFilter(array(
				// '#order' =>array('playercard_id'=>'desc'),
				// '#limit' =>array('0','5')
					// )) ){
					
			// $playercards = array();
			// foreach($aPlayercard_temp as $oPlayercard){
				// $playercards[]=$oPlayercard->getPlayercardId();	
				// $aPlayercards[$oPlayercard->getPlayercardId()] = $oPlayercard;
			// }

			// if($aPlayerTournament_temp = $this->PluginVs_Stat_GetPlayertournamentItemsByFilter(array(
				// 'playercard_id in' => $playercards,
				// 'tournament_id'         => '0'	,
				// '#with'         => array('team'),
			// )))
			// {	
				// foreach($aPlayerTournament_temp as $oPlayerTournament){
					// $aPlayercards[$oPlayerTournament->getPlayercardId()]->setTeam($oPlayerTournament->getTeam());
					// $playercards[]=$oPlayerTournament->getPlayercardId();			
				// }
				
			// }
			// $this->Viewer_Assign('aPlayercards', $aPlayercards);
		// }
		
    }
}
?>