<?php

/**
 * This is the model class for table "{{ieltseye_speaking_topic_card}}".
 *
 * The followings are the available columns in table '{{ieltseye_speaking_topic_card}}':
 * @property integer $cardid
 * @property string $question
 * @property string $description
 * @property integer $type
 * @property integer $dateline
 */
class IeltseyeSpeakingTopicCard extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IeltseyeSpeakingTopicCard the static model class
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
		return '{{ieltseye_speaking_topic_card}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question, description, type, dateline', 'required'),
			array('type, dateline', 'numerical', 'integerOnly'=>true),
			array('question', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cardid, question, description, type, dateline', 'safe', 'on'=>'search'),
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
            'topicSamples'=>array(self::HAS_MANY, 'IeltseyeSpeakingTopicCard', 'cardid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cardid' => 'Cardid',
			'question' => 'Question',
			'description' => 'Descripiton',
			'type' => 'Type',
			'dateline' => 'Dateline',
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

		$criteria->compare('cardid',$this->cardid);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('dateline',$this->dateline);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getPart($part, $keyword =''){
//        part
        $part = intval($part);
        if (!in_array($part, array(1,2,3))) {
            $part = 2;
        }
//        keyword
        if (Yii::app()->request->getParam('keyword')) {
            $keyword = Yii::app()->request->getParam('keyword');
            $keyword=strtr($keyword, array('%'=>'\%', '_'=>'\_'));
        }
        
        $command = Yii::app()->db->createCommand();
        $command->select('count(cardid)');
        $command->from('{{ieltseye_speaking_topic_card}}');
        if (!empty($keyword)) {
            $command->where(array('like', 'question', '%'.$keyword.'%'));
        }
        if ($part) {
            $command->andWhere('type=:type', array(':type'=>$part));
        }
        $count = $command->queryScalar();
        
        $command = Yii::app()->db->createCommand();
        $command->select('*');
        $command->from('{{ieltseye_speaking_topic_card}}');
        if (!empty($keyword)) {
            $command->where(array('like', 'question', '%'.$keyword.'%'));
        }
        if ($part) {
            $command->andWhere('type=:type', array(':type'=>$part));
        }
        $command->order('dateline DESC');

        $dataProvider = new CSqlDataProvider($command, array(
                'totalItemCount'=>$count,
                'pagination' => array(
                    'pageSize' => 10,
                ),
                'sort' => array(
                    'defaultOrder' => array('dateline' => 'CSort::SORT_DESC'),
                ),
            )
        );
        
        return $dataProvider;
        
    }
}