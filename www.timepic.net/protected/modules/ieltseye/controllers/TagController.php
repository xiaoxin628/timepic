<?php

class TagController extends IeltseyeController
{
	public function actionIndex() {
        $tagsCache = IeltseyeCache::loadCache('Tags');
        if (!empty($tagsCache)) {

            foreach ($tagsCache as $tag) {
                $tagsData[ucwords($tag['tagname'])] = $tag['tagid'];
                $typeAheadData[] = $tag['tagname'];
                if ($tag['aliasWords']) {
                    $aliasWords = explode(',', $tag['aliasWords']);
                    if ($aliasWords) {
                        foreach ($aliasWords as $aliasWord) {
                            $tagsData[ucwords($aliasWord)] = $tag['tagid'];
                            $typeAheadData[] = $aliasWord;
                        }
                    }
                }
            }
        }
        ksort($tagsData);
        $this->render('index', array(
            'typeAheadData' => $typeAheadData,
            'tagsData' => $tagsData,
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