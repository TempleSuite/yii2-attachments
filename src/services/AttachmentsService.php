<?php 
namespace templesuite\attachments\behaviors;

use common\models\ar\User;
use common\models\ar\Facility;
use common\models\ar\Complex;
use common\models\ar\Group;
use common\models\ar\PunchPassUser;
use templesuite\attachments\models\File;
use common\models\ar\SystemConfiguration;

class AttachmentsService {

	// gets the related model of the File so we know what type we're dealing with
	public function getRelatedModel(File $file)
	{
		// needs the string prefix because the component only stores the Classname, not the namespaced Classname...
		$model = 'common\models\ar\\'.$file->model;
		return $model::findOne($file->itemId);
	}

	//attaches a file to a model
	public function attach($model, File $file)
	{
		if($model instanceOf SystemConfiguration) {
			$sysConfig = SystemConfiguration::instance();
			$sysConfig->file_id = $file->id;
			$sysConfig->save();
			return true;
		} else if($model instanceOf Facility) {
			return true;
		} else if($model instanceOf Complex) {
			return true;
		} else if($model instanceOf Group) {
			return true;
		} else if($model instanceOf MembershipEnrollment || $model instanceOf PunchPassUser || $model instanceOf User) {
			$model->file_id = $file->id;
			$model->save();
			return true;
		} else { // did not match, try anyways
			$model->file_id = $file->id;
			$model->save();
			return true;
		}

		return false;
	}

	public static function buildHtmlForSelectButton()
	{
		return '<button type="button" class="btn btn-xs btn-default js-upload-select" title="Use file" {dataKey}"><i class="glyphicon glyphicon-ok"></i></button>';
	}


	// determines how to reload the page
	public function reload($model)
	{
		if($model instanceOf SystemConfiguration)
			return true;
		return false;
	}
}