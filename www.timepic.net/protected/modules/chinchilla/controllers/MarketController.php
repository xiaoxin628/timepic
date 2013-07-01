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
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('index','view', 'getChinchillaColor'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
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

		if(isset($_POST['ChinchillaMarketTrade']))
		{
			$model->attributes=$_POST['ChinchillaMarketTrade'];
			$model->uid = Yii::app()->user->uid;
			$model->breed = Yii::app()->request->getParam('ChinchillaGVC');
			$model->dateline = time();
			$model->ip = Yii::app()->request->getUserHostAddress();
			$model->displayorder = 0;
			if($model->save())
				$this->redirect(array('view','id'=>$model->tradeId));
			var_dump($model->validate());
			exit;
		}

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
			if($model->save())
				$this->redirect(array('view','id'=>$model->tradeId));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$model=new ChinchillaMarketTrade;
		
		$sql = "SELECT tradeid, uid, title, price, dateline, pic  FROM {{chinchilla_market_trade}} ORDER BY dateline DESC";
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
}
