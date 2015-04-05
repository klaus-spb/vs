<?php
class PluginVs_ModuleStat_EntityEventPlayer extends EntityORM {
	protected $aRelations=array(            
		'teamtournament' =>  array(self::RELATION_TYPE_BELONGS_TO,'PluginVs_ModuleStat_EntityTeamsintournament','teamintournament_id'),
		'event' =>  array(self::RELATION_TYPE_BELONGS_TO,'PluginVs_ModuleStat_EntityEvent','event_id')

);

}

?>