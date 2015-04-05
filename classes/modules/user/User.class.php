<?php

class PluginVs_ModuleUser extends PluginVs_Inherit_ModuleUser {
	
	public function Shutdown() {
		
		parent::Shutdown(); 
		
        if ($this->oUserCurrent) {
			$matches = $this->PluginVs_Stat_GetMyMatches($this->oUserCurrent->getId());
            $this->Viewer_Assign('iUserCurrentCountMatches', $matches['count_matches']);
            $this->Viewer_Assign('iUserCurrentCountMyMatches', $matches['count_my_matches']);
            
        }
    }
	
	public function SetUserDonator($sUserId, $is_donator) {
      
		$this->Cache_Delete("user_{$sUserId}");
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array("user_update"));
		
        return $this->oMapper->SetUserDonator($sUserId, $is_donator);
    }
	
	public function SetUserMedals($oUser) {
      
		$this->Cache_Delete("user_{$oUser->getUserId()}");
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array("user_update"));
		
        return $this->oMapper->SetUserMedals($oUser);
    }
	
	
	public function GetUsersAdditionalData($aUserId, $aAllowData = null) {

        if (is_null($aAllowData)) {
            $aAllowData = array( /*'session','vote', 'friend', 'geo_target','note'*/ );
        }
        $aAllowData = F::Array_FlipIntKeys($aAllowData);
        if (!is_array($aUserId)) {
            $aUserId = array($aUserId);
        }
        /**
         * Получаем юзеров
         */
        $aUsers = $this->GetUsersByArrayId($aUserId);
        /**
         * Получаем дополнительные данные
         */
        $aSessions = array();
        $aFriends = array();
        $aVote = array();
        $aGeoTargets = array();
        $aNotes = array();
        if (isset($aAllowData['session'])) {
            $aSessions = $this->GetSessionsByArrayId($aUserId);
        }
        if (isset($aAllowData['friend']) && $this->oUserCurrent) {
            $aFriends = $this->GetFriendsByArray($aUserId, $this->oUserCurrent->getId());
        }

        if (isset($aAllowData['vote']) && $this->oUserCurrent) {
            $aVote = $this->Vote_GetVoteByArray($aUserId, 'user', $this->oUserCurrent->getId());
        }
        if (isset($aAllowData['geo_target'])) {
            $aGeoTargets = $this->Geo_GetTargetsByTargetArray('user', $aUserId);
        }
        if (isset($aAllowData['note']) && $this->oUserCurrent) {
            $aNotes = $this->GetUserNotesByArray($aUserId, $this->oUserCurrent->getId());
        }
        /**
         * Добавляем данные к результату
         */
        foreach ($aUsers as $oUser) {
            if (isset($aSessions[$oUser->getId()])) {
                $oUser->setSession($aSessions[$oUser->getId()]);
            } else {
                $oUser->setSession(null); // или $oUser->setSession(new ModuleUser_EntitySession());
            }
            if ($aFriends && isset($aFriends[$oUser->getId()])) {
                $oUser->setUserFriend($aFriends[$oUser->getId()]);
            } else {
                $oUser->setUserFriend(null);
            }

            if (isset($aVote[$oUser->getId()])) {
                $oUser->setVote($aVote[$oUser->getId()]);
            } else {
                $oUser->setVote(null);
            }
            if (isset($aGeoTargets[$oUser->getId()])) {
                $aTargets = $aGeoTargets[$oUser->getId()];
                $oUser->setGeoTarget(isset($aTargets[0]) ? $aTargets[0] : null);
            } else {
                $oUser->setGeoTarget(null);
            }
            if (isset($aAllowData['note'])) {
                if (isset($aNotes[$oUser->getId()])) {
                    $oUser->setUserNote($aNotes[$oUser->getId()]);
                } else {
                    $oUser->setUserNote(false);
                }
            }
        }

        return $aUsers;
    }
	
	public function DeletePlayerPhoto($oUser) {
		$oPlayercard = $this->PluginVs_Stat_GetPlayercardByFilter(array(
						'user_id' => $oUser->GetUserId(), 
						'sport_id' => 1  
					));
		$this->Image_RemoveFile($this->Image_GetServerPath($oPlayercard->getFoto()));
	}
	
	public function UploadPlayerPhoto($sFileTmp,$oUser,$aSize=array()) {
		if (!file_exists($sFileTmp)) {
			return false;
		}
		$sDirUpload=$this->Image_GetIdDir($oUser->getId());
		$aParams=$this->Image_BuildParams('playerphoto');


		if ($aSize) {
			$oImage = $this->Image_CreateImageObject($sFileTmp);
			/**
			 * Если объект изображения не создан,
			 * возвращаем ошибку
			 */
			if($sError=$oImage->get_last_error()) {
				// Вывод сообщения об ошибки, произошедшей при создании объекта изображения
				// $this->Message_AddError($sError,$this->Lang_Get('error'));
				@unlink($sFileTmp);
				return false;
			}

			$iWSource=$oImage->get_image_params('width');
			$iHSource=$oImage->get_image_params('height');
			/**
			 * Достаем переменные x1 и т.п. из $aSize
			 */
			extract($aSize,EXTR_PREFIX_SAME,'ops');
			if ($x1>$x2) {
				// меняем значения переменных
				$x1 = $x1 + $x2;
				$x2 = $x1 - $x2;
				$x1 = $x1 - $x2;
			}
			if ($y1>$y2) {
				$y1 = $y1 + $y2;
				$y2 = $y1 - $y2;
				$y1 = $y1 - $y2;
			}
			if ($x1<0) {
				$x1=0;
			}
			if ($y1<0) {
				$y1=0;
			}
			if ($x2>$iWSource) {
				$x2=$iWSource;
			}
			if ($y2>$iHSource) {
				$y2=$iHSource;
			}

			$iW=$x2-$x1;
			// Допускаем минимальный клип в 32px (исключая маленькие изображения)
			if ($iW<32 && $x1+32<=$iWSource) {
				$iW=32;
			}
			$iH=$y2-$y1;
			$oImage->crop($iW,$iH,$x1,$y1);
			$oImage->output(null,$sFileTmp);
		}

		if ($sFileFoto=$this->Image_Resize($sFileTmp,$sDirUpload,func_generator(6),Config::Get('view.img_max_width'),Config::Get('view.img_max_height'),100,null,true,$aParams)) {
			@unlink($sFileTmp);
			/**
			 * удаляем старое фото
			 */
			$this->DeletePlayerPhoto($oUser);
			return $this->Image_GetWebPath($sFileFoto);
		}
		@unlink($sFileTmp);
		return false;
	}

}
?>