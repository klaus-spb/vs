<?php

class PluginVs_ModuleUser_MapperUser extends PluginVs_Inherit_ModuleUser_MapperUser {
	
	public function SetUserDonator($sUserId, $is_donator)
    {
        $sql = "UPDATE ?_user
			SET
				user_donator = ?d
			WHERE
				user_id = ?d
		";
        if ($this->oDb->query($sql, $is_donator, $sUserId)) {
            return true;
        }
        return false;
    }
	
	public function SetUserMedals($oUser)
    {
        $sql = "UPDATE ?_user
			SET
				user_medals = ?
			WHERE
				user_id = ?d
		";
		
        if ($this->oDb->query($sql, $oUser->getMedals(), $oUser->getUserId())) {
            return true;
        }
        return false;
    }
	

}

?>