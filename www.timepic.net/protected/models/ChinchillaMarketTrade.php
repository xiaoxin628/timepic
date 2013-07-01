<?php

/**
 * This is the model class for table "{{chinchilla_market_trade}}".
 *
 * The followings are the available columns in table '{{chinchilla_market_trade}}':
 * @property integer $tradeId
 * @property integer $uid
 * @property integer $breed
 * @property integer $gender
 * @property integer $birthday
 * @property integer $weight
 * @property string $ip
 * @property string $description
 * @property integer $price
 * @property string $pic
 * @property integer $expiredDate
 * @property integer $dateline
 * @property integer $displayorder
 */
class ChinchillaMarketTrade extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChinchillaMarketTrade the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{chinchilla_market_trade}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, breed, gender, birthday, weight, description, price, expiredDate', 'required'),
			array('uid, breed, gender, weight, price, dateline, displayorder', 'numerical', 'integerOnly'=>true),
			array('gender', 'in', 'range'=>array(0, 1)),
			array('birthday', 'date','format'=>'yyyy-mm-dd'),
			array('expiredDate', 'date','format'=>'yyyy-mm-dd'),
			array('weight', 'numerical', 'min'=>10, 'max'=>2000),
			array('ip', 'length', 'max'=>15),
			array('description', 'length', 'min'=>4, 'max'=>2000, 'message'=>'{attribute}'),
			array('price', 'numerical', 'min'=>1, 'max'=>1000000),
			array('pic', 'default'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tradeId, uid, breed, gender, birthday, weight, ip, description, price, pic, expiredDate, dateline, displayorder', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tradeId' => 'Trade',
			'uid' => 'Uid',
			'breed' => '品种/毛色',
			'gender' => '性别',
			'birthday' => '生日',
			'weight' => '体重',
			'ip' => 'Ip',
			'description' => '描述',
			'price' => '价格',
			'pic' => '封面',
			'expiredDate' => '过期时间',
			'dateline' => '发表日期',
			'displayorder' => 'Displayorder',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tradeId',$this->tradeId);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('breed',$this->breed);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('birthday',$this->birthday);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('expiredDate',$this->expiredDate);
		$criteria->compare('dateline',$this->dateline);
		$criteria->compare('displayorder',$this->displayorder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	//* format the data for this model e.g. dateline or uid
	public function beforeSave(){
		$this->birthday = strtotime($this->birthday);
		$this->expiredDate = strtotime($this->expiredDate);
		return true;
	}
}