<?php
class PluginVs_ModuleStat_EntityEventPair extends EntityORM {
	protected $aRelations=array(            
		'leftteamtournament' =>  array(self::RELATION_TYPE_BELONGS_TO,'PluginVs_ModuleStat_EntityTeamsintournament','left_teamintournament_id'),
		'rightteamtournament' =>  array(self::RELATION_TYPE_BELONGS_TO,'PluginVs_ModuleStat_EntityTeamsintournament','right_teamintournament_id'),
		'event' =>  array(self::RELATION_TYPE_BELONGS_TO,'PluginVs_ModuleStat_EntityEvent','event_id')

);

}

?>