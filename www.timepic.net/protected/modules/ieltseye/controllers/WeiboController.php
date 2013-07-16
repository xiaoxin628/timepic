<?php

class WeiboController extends IeltseyeController
{
    public $pageTitle = '';
    
	public function actionIndex()
	{
        $keyword = '';
        if (Yii::app()->request->getParam('keyword')) {
            $keyword = Yii::app()->request->getParam('keyword');
            $keyword=strtr($keyword, array('%'=>'\%', '_'=>'\_'));
        }
		$model=new IeltseyeWeibo();
        $command = Yii::app()->db->createCommand();
        $command->select('count(eid)');
        $command->from('{{ieltseye_weibo}}');
        if (!empty($keyword)) {
            $command->where(array('like', 'text', '%'.$keyword.'%'));
        }
        $criteria = new CDbCriteria();
		$pages=new CPagination($command->queryScalar());
		$pages->pageSize = 20;
		$pages->applyLimit($criteria);

        $command = Yii::app()->db->createCommand();
        $command->select('*');
        $command->from('{{ieltseye_weibo}}');
        if (!empty($keyword)) {
            $command->where(array('like', 'text', '%'.$keyword.'%'));
        }
        $command->order('created_at DESC');
        $command->limit($pages->pageSize, $pages->currentPage*$pages->pageSize);

		$query = $command->query();
		while($row = $query->read()){
            //去掉@某人
            $row['text'] = preg_replace("/@[\\x{4e00}-\\x{9fa5}\\w\\-]+/u", "", $row['text']);
            if (!empty($keyword)) {
                $row['text'] = str_ireplace($keyword, '<span class="alert alert-info ieltsKeyword">'.$keyword.'</span>', CHtml::encode($row['text']));   
            }
			$data[] = $row;
		}
		$this->render('index',
                    array('model'=>$model,
                        'data'=>$data,
                        'pages'=>$pages,
                        'keyword'=>$keyword,
                    )
				);
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