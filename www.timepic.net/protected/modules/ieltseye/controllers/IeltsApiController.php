<?php

class IeltsApiController extends Controller
{
	public function actionIndex()
	{
		$page = Yii::app()->request->getParam('page');
        if (Yii::app()->request->getParam('keyword')) {
            $keyword = Yii::app()->request->getParam('keyword');
            $keyword=strtr($keyword, array('%'=>'\%', '_'=>'\_'));
        }
		$jsondata = $data = array();
		$page = $page ? intval($page) : 0;
		$pageSize = 10;
        $command = Yii::app()->db->createCommand();
        $command->select('uid, screen_name, text, created_at');
        $command->from('{{ieltseye_weibo}}');
        $command->order('created_at DESC');
        $command->limit($pageSize, $page*$pageSize);
        if (!empty($keyword)) {
            $command->where(array('like', 'text', '%'.$keyword.'%'));
        }
		$query = $command->query();
		while($row = $query->read()){
            //去掉@某人
            $row['text'] = preg_replace("/@[\\x{4e00}-\\x{9fa5}\\w\\-]+/u", "", $row['text']);
            if (!empty($keyword)) {
                $row['text'] = str_ireplace($keyword, '<span class="badge badge-info">'.$keyword.'</span>', CHtml::encode($row['text']));   
            }
            $row['created_at'] = date("Y-m-d H:i:s", $row['created_at']);
			$data[] = $row;
		}
		$jsondata['datas'] = $data;
		header('Access-Control-Allow-Origin: *');
		echo Yii::app()->request->getParam('callback').'('.json_encode($jsondata).')';
		Yii::app()->end();
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
