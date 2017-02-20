<?php

namespace templesuite\attachments\behaviors;
use yii\base\Behavior;
use templesuite\attachments\models\File;


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