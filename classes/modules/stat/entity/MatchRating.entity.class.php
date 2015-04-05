<?php
class PluginVs_ModuleStat_EntityMatchRating extends EntityORM {
  
	protected $aRelations=array(            
		'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'), 
		'match' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleStat_EntityMatches', 'match_id')
	);

}

?>