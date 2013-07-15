<?php

/**
 * This is the model class for table "{{ieltseye_weibo}}".
 *
 * The followings are the available columns in table '{{ieltseye_weibo}}':
 * @property string $eid
 * @property string $uid
 * @property string $uidstr
 * @property string $screen_name
 * @property string $wbid
 * @property string $wbmid
 * @property string $text
 * @property integer $created_at
 * @property string $keywords
 * @property integer $dateline
 * @property integer $status
 * @property integer $source
 */
class IeltseyeWeibo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IeltseyeWeibo the static model class
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
		return '{{ieltseye_weibo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, uidstr, screen_name, wbid, wbmid, text, created_at, dateline, status, source', 'required'),
			array('created_at, dateline, status, source', 'numerical', 'integerOnly'=>true),
			array('uid, uidstr, wbid, wbmid', 'length', 'max'=>255),
			array('screen_name, keywords', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('eid, uid, uidstr, screen_name, wbid, wbmid, text, created_at, keywords, dateline, status, source', 'safe', 'on'=>'search'),
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
			'eid' => 'Eid',
			'uid' => 'Uid',
			'uidstr' => 'Uidstr',
			'screen_name' => 'Screen Name',
			'wbid' => 'Wbid',
			'wbmid' => 'Wbmid',
			'text' => 'Text',
			'created_at' => 'Created At',
			'keywords' => 'Keywords',
			'dateline' => 'Dateline',
			'status' => 'Status',
			'source' => 'Source',
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

		$criteria->compare('eid',$this->eid,true);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('uidstr',$this->uidstr,true);
		$criteria->compare('screen_name',$this->screen_name,true);
		$criteria->compare('wbid',$this->wbid,true);
		$criteria->compare('wbmid',$this->wbmid,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('dateline',$this->dateline);
		$criteria->compare('status',$this->status);
		$criteria->compare('source',$this->source);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}