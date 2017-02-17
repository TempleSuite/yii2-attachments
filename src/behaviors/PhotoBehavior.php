<?php

namespace jeffwalsh\attachments\behaviors;

use yii\base\Behavior;
use nemmo\attachments\models\File;
use common\models\ar\SystemConfiguration;
use common\models\ar\User;
use common\models\ar\PunchPassUser;
use common\models\ar\MembershipEnrollment;


class PhotoBehavior extends Behavior
{

    public $docTypes = ['png','jpeg','jpg','gif', 'svg'];

    public function getPhoto()
    {
        return $this->owner->hasOne(File::className(), ['id' => 'file_id']);
    }

    public function getPhotos()
    {
         return $this->owner->hasMany(File::className(), ['itemId' => 'id'])
            ->andWhere(['=', 'model', (new \ReflectionClass($this->owner))->getShortName()])
            ->andWhere(['in', 'type', $this->docTypes]);
    }

    public function displayPhoto()
    {
    	if($this->owner->photo)
	    	echo '/attachments/file/download?id='.$this->owner->photo->id;
	    else
	    	echo '/images/avatars/default.png';
    }

    public function buildBaseUrl()
    {
        if($this->owner instanceof SystemConfiguration)
            return $this->owner->photo ? $this->owner->photo->url : '/images/logo/somewhere.png'; 
        if($this->owner instanceof User || $this->owner instanceof PunchPassUser || $this->owner instanceof MembershipEnrollment)
            return $this->owner->photo ? $this->owner->photo->url : '/images/avatars/male.png';

        return '';
    }
}