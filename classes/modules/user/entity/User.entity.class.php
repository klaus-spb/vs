<?php
class PluginVs_ModuleUser_EntityUser extends PluginVs_Inherit_ModuleUser_EntityUser {
	
	protected $aMedals=null;
	
	public function getMedals()
    {
        return $this->_getDataOne('user_medals') ? $this->_getDataOne('user_medals') : serialize('');
    }

	
	public function setMedals($data)
    {
        $this->_aData['user_medals']=serialize($data);
    }
    /**
     * Расширения методов
     */
    public function extractMedals() {
        if (is_null($this->aMedals)) {
            $this->aMedals=@unserialize($this->getMedals());
        }
    }
    public function setMedalsValue($sName,$data) {
        $this->extractMedals();
        $this->aMedals[$sName]=$data;
        $this->setMedals($this->aMedals);
    }
    public function getMedalsValue($sName) {
        $this->extractMedals();
        if (isset($this->aMedals[$sName])) {
            return $this->aMedals[$sName];
        }
        return null;
    }

    public function setGold($data) {
        $this->setMedalsValue('gold',$data);
    }
    public function getGold() {
        return $this->getMedalsValue('gold');
    }
	public function setSilver($data) {
        $this->setMedalsValue('silver',$data);
    }
    public function getSilver() {
        return $this->getMedalsValue('silver');
    }
	public function setBronze($data) {
        $this->setMedalsValue('bronze',$data);
    }
    public function getBronze() {
        return $this->getMedalsValue('bronze');
    }
	public function setUnknown($data) {
        $this->setMedalsValue('unknown',$data);
    }
    public function getUnknown() {
        return $this->getMedalsValue('unknown');
    }
	
	public function getChId() { 
        return $this->_aData['ch_id'];
    }
	public function setChId($data) {
        $this->_aData['ch_id']=$data;
    } 

	public function getDonator() { 
        return $this->_aData['user_donator'];
    }

	public function setDonator($data) {
        $this->_aData['user_donator']=$data;
    } 
	
 	public function getChPassword() { 
        return $this->_aData['ch_password'];
    }
	public function setChPassword($data) {
        $this->_aData['ch_password']=$data;
    } 
	
/* from sitemap ****************?
	    /**
     * Get date of last user modification
     *
     * @return string
     */
    public function getDateLastMod() {
        return is_null($this->getProfileDate()) ? $this->getDateRegister() : $this->getProfileDate();
    }

    /**
     * Get web path to page with user comments
     *
     * @return string
     */
    public function getUserCommentsWebPath() {
        return $this->getUserWebPath() . 'created/comments/';
    }

    /**
     * Get web path to page with user topics
     *
     * @return string
     */
    public function getUserTopicsWebPath() {
        return $this->getUserWebPath() . 'created/topics/';
    }

}

?>