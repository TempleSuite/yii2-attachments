<?php

namespace jeffwalsh\attachments\behaviors;
use yii\base\Behavior;
use nemmo\attachments\models\File;


class DocumentBehavior extends Behavior
{
    public $docTypes = ['pdf', 'doc', 'docx', 'odt'];

    public function getDocuments()
    {
        return $this->owner->hasMany(File::className(), ['itemId' => 'id'])
            ->andWhere(['=', 'model', (new \ReflectionClass($this->owner))->getShortName()])
            ->andWhere(['in', 'type', $this->docTypes]);
    }
}