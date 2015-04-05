<?php
class PluginVs_ModuleStat_EntityTeam extends EntityORM {
protected $aRelations=array(            
		'game' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleStat_EntityGame', 'game_id'),
		'gametype' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleStat_EntityGametype', 'gametype_id'),
		'sport' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleStat_EntitySport', 'sport_id'),	
		'platform' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleStat_EntityPlatform', 'platform_id'),		
		'owner' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'owner_id'),
		//'blog' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleBlog_EntityBlog', 'blog_id'),
		'blog_vs' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleBlog_EntityBlog', 'blog_vs_id'),
		'blog_ch' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleBlog_EntityBlog', 'blog_ch_id'),
		'league' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleStat_EntityLeague', 'league_id'),
);
	protected $aExtra=null;
	
	public function getSlidebyNum($num) { 
		$slides = explode(";", $this->getSlide());
		return isset($slides[$num-1])? $slides[$num-1] : '0';
    }
	
	public function getBlogId() {
		if(Config::Get('sys.site')=='vs'){
			return $this->getBlogVsId();
		}
		if(Config::Get('sys.site')=='ch'){
			return $this->getBlogChId();
		}
	}
	
	public function getBlog() {
		if(Config::Get('sys.site')=='vs'){
			return $this->getBlogVs();
		}
		if(Config::Get('sys.site')=='ch'){
			return $this->getBlogCh();
		}
	}
	
	public function getUrlFull() { 	
		if($this->getBlogId()!=0 && $this->getBlog()){
			return $this->getBlog()->getTeamUrlFull();
		}else{
			return Router::GetPath('team').$this->getTeamId();
		}
    }
	
	public function getExtra()
    {
        return $this->_getDataOne('team_extra') ? $this->_getDataOne('team_extra') : serialize('');
    }
	public function setExtra($data)
    {
        $this->_aData['team_extra']=serialize($data);
    }
	 /**
     * Расширения методов
     */
    protected function extractExtra() {
        if (is_null($this->aExtra)) {
            $this->aExtra=@unserialize($this->getExtra());
        }
    }
    protected function setExtraValue($sName,$data) {
        $this->extractExtra();
        $this->aExtra[$sName]=$data;
        $this->setExtra($this->aExtra);
    }
    protected function getExtraValue($sName) {
        $this->extractExtra();
        if (isset($this->aExtra[$sName])) {
            return $this->aExtra[$sName];
        }
        return null;
    }
	
	public function setAttackRating($data) {
        $this->setExtraValue('attack_rating',$data);
    }

    public function getAttackRating() {
        return $this->getExtraValue('attack_rating')?$this->getExtraValue('attack_rating'):0;
    }
	
	public function setMiddleRating($data) {
        $this->setExtraValue('middle_rating',$data);
    }

    public function getMiddleRating() {
        return $this->getExtraValue('middle_rating')?$this->getExtraValue('middle_rating'):0;
    }
	
	public function setDefenseRating($data) {
        $this->setExtraValue('defense_rating',$data);
    }

    public function getDefenseRating() {
        return $this->getExtraValue('defense_rating')?$this->getExtraValue('defense_rating'):0;
    }
	public function getSkill() {
		return ($this->getAttackRating() + $this->getMiddleRating() + $this->getDefenseRating());
	}
}

?>