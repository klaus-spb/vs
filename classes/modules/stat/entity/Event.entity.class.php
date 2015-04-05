<?php
class PluginVs_ModuleStat_EntityEvent extends EntityORM {
	protected $aRelations=array(            
       'tournament' =>  array(self::RELATION_TYPE_BELONGS_TO,'PluginVs_ModuleStat_EntityTournament','tournament_id')
);

}

?>