<?php

class SampleController extends IeltseyeController
{
	public function actionIndex()
	{
		$this->render('index');
	}
    
    public function actionSpeakingTopic($id){
        $topicCard = $dataprovider = '';
        $topicCard = IeltseyeSpeakingTopicCard::model()->findByPk($id);
        $dataprovider = new CActiveDataProvider('IeltseyeSpeakingTopicSample', array(
                    'criteria' => array(
                        'condition' => 'cardid='.  intval($id),
                    ),
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                    'sort' => array(
                        'defaultOrder' => array('dateline'=>'CSort::SORT_DESC'),
                    )
                )
        );
		$this->render('speakingTopic',array(
            'dataprovider'=>$dataprovider,
            'topicCard' => $topicCard,
		));
    }
    
    public function actionSpeakingView($id){
        $topicCard = $dataprovider = '';
        $sample = IeltseyeSpeakingTopicSample::model()->with('topicCard')->findByPk($id);
		$this->render('speakingView',array(
            'sample'=>$sample,
		));
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