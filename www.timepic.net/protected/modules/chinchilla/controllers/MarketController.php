<?php

class MarketController extends TPController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $translate = array();

	public function init(){
		//get chinchilla color translate data from the config/param
		 $this->translate = Yii::app()->getParams('chinchilla')->chinchilla['colorTranslate'];
	}
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl -uploadTradePic', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'uploadTradePic'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'getChinchillaColor', 'showTmpThumbnail'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	// show chinchilla color by the imageid
	public function actionGetChinchillaColor($imageid){

		if (isset($imageid)) {
			$row = Yii::app()->db->createCommand()->select('*')->from('{{totoro_color}}')->where('imageid=:imageid', array(':imageid' => $imageid))->query()->read();
			//只有语言选择中文才开始翻译。
			if (Yii::app()->language == 'zh_cn') {
				$row['color'] = str_replace(array_keys($this->translate), $this->translate, $row['color']);	
			}
			if (isset($row['color'])) {
				echo $row['color'];
			}
		}
		Yii::app()->end();

	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model = ChinchillaMarketTrade::model()->with('author')->findByPk($id);
        $tradeImages = ChinchillaMarketTradePic::model()->findAll('uid=:uid and tradeId=:tradeId', array(':uid'=>Yii::app()->user->uid, ':tradeId'=>$model->tradeId));
		$this->render('view',array(
			'model'=> $model,
            'tradeImages'=>$tradeImages,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ChinchillaMarketTrade;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        //distroy the images uploaded before in this action to keep upload images being available.
        
        
		if(isset($_POST['ChinchillaMarketTrade']))
		{
            $uploadList = isset(Yii::app()->user->uploadList) ? Yii::app()->user->uploadList : array();
			$model->attributes=$_POST['ChinchillaMarketTrade'];
			$model->uid = Yii::app()->user->uid;
			$model->breed = Yii::app()->request->getParam('ChinchillaGVC');
			$model->dateline = time();
			$model->ip = Yii::app()->request->getUserHostAddress();
			$model->displayorder = 0;
            //check breed color
            $colors = $model->checkColor($model->breed);
            $model->attributes = $colors;
            if($model->save()){
                if ($uploadList) {
                    Yii::import('application.components.UploadHelper');
                    $setCover = true;
                    foreach ($uploadList as $attachment){
                        $upload = new UploadHelper();
                        $upload->init($attachment, 'chinchillaMarket');
                        $upload->save();
                        $picmodel = new ChinchillaMarketTradePic();
                        $picmodel->uid = Yii::app()->user->uid;
                        $picmodel->tradeId = $model->tradeId;
                        $picmodel->ip = Yii::app()->request->getUserHostAddress();
                        $picmodel->filename = $upload->attach['name'];
                        $picmodel->type = $upload->attach['extension'];
                        $picmodel->size = $upload->attach['size'];
                        $picmodel->filepath = $upload->attach['attachment'];
                        $picmodel->thumb = 1;
                        $picmodel->status = 0;
                        $picmodel->dateline = time();
                        $picmodel->save();
                        //the cover will be the first element in the uploadList;
                        if ($setCover) {
                            $model->updateByPk($model->tradeId, array('pic'=>$picmodel->filepath));
                            $setCover = false;
                        }
                        unset($upload);
                        unset($picmodel);
                    }
                }
                //reset the attachment list
                unset(Yii::app()->user->uploadList);
				$this->redirect(array('view','id'=>$model->tradeId));
            }
		}
        //reset the attachment list
        unset(Yii::app()->user->uploadList);
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ChinchillaMarketTrade']))
		{
			$model->attributes=$_POST['ChinchillaMarketTrade'];
			$model->uid = Yii::app()->user->uid;
			$model->breed = Yii::app()->request->getParam('ChinchillaGVC');
            //check breed color
            $colors = $model->checkColor($model->breed);
            $model->attributes = $colors;
            if($model->save()){
                $uploadList = isset(Yii::app()->user->uploadList) ? Yii::app()->user->uploadList : array();
                if ($uploadList) {
                    Yii::import('application.components.UploadHelper');
                    foreach ($uploadList as $attachment){
                        $upload = new UploadHelper();
                        $upload->init($attachment, 'chinchillaMarket');
                        $upload->save();
                        $picmodel = new ChinchillaMarketTradePic();
                        $picmodel->uid = Yii::app()->user->uid;
                        $picmodel->tradeId = $model->tradeId;
                        $picmodel->ip = Yii::app()->request->getUserHostAddress();
                        $picmodel->filename = $upload->attach['name'];
                        $picmodel->type = $upload->attach['extension'];
                        $picmodel->size = $upload->attach['size'];
                        $picmodel->filepath = $upload->attach['attachment'];
                        $picmodel->thumb = 1;
                        $picmodel->status = 0;
                        $picmodel->dateline = time();
                        $picmodel->save();
                        unset($upload);
                        unset($picmodel);
                    }
                }
                //reset the attachment list
                unset(Yii::app()->user->uploadList);
				$this->redirect(array('view','id'=>$model->tradeId));
            }
		}
        //reset the attachment list
        unset(Yii::app()->user->uploadList);
        //formate the time
        $model->birthday = date('Y-m-d', $model->birthday);
        $model->expiredDate = date('Y-m-d', $model->expiredDate);
        $tradeImages = ChinchillaMarketTradePic::model()->findAll('uid=:uid and tradeId=:tradeId', array(':uid'=>Yii::app()->user->uid, ':tradeId'=>$model->tradeId));
        $this->render('update',array(
			'model'=>$model,
            'tradeImages'=>$tradeImages,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
//		if(Yii::app()->request->isPostRequest)
//		{
//			// we only allow deletion via POST request
//			$this->loadModel($id)->delete();
//
//			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//			if(!isset($_GET['ajax']))
//				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//		}
//		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$model=new ChinchillaMarketTrade;
		
		$sql = "SELECT tradeId, uid, title, price, dateline, pic  FROM {{chinchilla_market_trade}} ORDER BY dateline DESC";
		$criteria = new CDbCriteria();
		$result = Yii::app()->db->createCommand($sql)->query();
		$pages=new CPagination($result->rowCount);
		$pages->pageSize = 2;
		$pages->applyLimit($criteria);
		$result=Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
		$result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
		$result->bindValue(':limit', $pages->pageSize);
		$query = $result->query();
		while($row = $query->read()){
			if ($row['uid']) {
				$row['memberInfo'] = member::model()->getMemberInfo($row['uid']); 
			}
			$data[] = $row;
		}
		$this->render('index',
				array('model'=>$model,
						'data'=>$data,
						'pages'=>$pages,
					)
				);

		// $dataProvider=new CActiveDataProvider('ChinchillaMarketTrade');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ChinchillaMarketTrade('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ChinchillaMarketTrade']))
			$model->attributes=$_GET['ChinchillaMarketTrade'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ChinchillaMarketTrade::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='chinchilla-market-trade-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /** 
     * multiupload images
     */
	public function actionUploadTradePic(){
		//this action should be access by anyone due the SWFUpload bug
		//you should modify the filters
		//		'accessControl -uploadTradePic',
  
        $uploadlist = array();
        $sessionCount = $dbCount = 0;
		if (Yii::app()->request->getParam('PHPSESSID')) {
			$res = Yii::app()->session->setSessionID(Yii::app()->request->getParam('PHPSESSID'));
		}
		// Check the upload
		if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
			echo "ERROR:invalid upload";
			Yii::app()->end();
		}
        if (isset(Yii::app()->user->uploadList)) {
            $uploadList = Yii::app()->user->uploadList; 
            $sessionCount = count($uploadList);
        }
        
        $tradeId = Yii::app()->request->getParam('tradeId');
        
        if ($tradeId) {
            $dbCount = ChinchillaMarketTradePic::model()->count('uid=:uid and tradeId=:tradeId', array(':uid'=>Yii::app()->user->uid, ':tradeId'=>$tradeId));
        }
        
        if (($sessionCount+$dbCount)>=4) {
			echo "ERROR: 图片最多上传4张";
			Yii::app()->end();
        }
        
        Yii::import('application.components.UploadHelper');
        $attach = $_FILES['Filedata'];
        $upload = new UploadHelper();
		$upload->init($attach);
        $upload->saveToTmp();


        $uploadList[$upload->attach['attachName']] = $upload->attach;
        Yii::app()->user->setState('uploadList', $uploadList);
        echo 'FILEID:'.$upload->attach['attachName'];
        Yii::app()->end();
	}
    
    /**
     * 
     * show Thumbnail in market create
     */
    public function actionShowTmpThumbnail(){
        $id = Yii::app()->request->getParam('id');
        if (empty($id)) {
            throw new CHttpException(500, 'No ID');
        }
        $uploadList = Yii::app()->user->uploadList;
        if (empty($uploadList) || empty($uploadList[$id]['copyTmp'])) {
            throw new CHttpException(404, 'No File');
        }
        $pathInfo = pathinfo(Yii::getPathOfAlias('webroot').$uploadList[$id]['copyTmp']);
        $thumbImage = $pathInfo['dirname'].'/'.'thumb'.'_'.$pathInfo['basename'];
        $image = file_get_contents($thumbImage);
        header("Content-type: image/jpeg");
        header("Content-Length: " . strlen($image));
        echo $image;
        Yii::app()->end();
    }
}
