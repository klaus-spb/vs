<?php
class PluginVs_ModuleStat_EntityTopicInterview extends EntityORM {

protected $aRelations = array( 
	'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
	'topic' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleTopic_EntityTopic', 'topic_id'),	 
  );
  
	
}

?>