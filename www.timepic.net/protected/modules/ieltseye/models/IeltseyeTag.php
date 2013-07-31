<?php

/**
 * This is the model class for table "{{ieltseye_tag}}".
 *
 * The followings are the available columns in table '{{ieltseye_tag}}':
 * @property integer $tagid
 * @property string $tagname
 * @property string $aliasWords
 * @property integer $status
 */
class IeltseyeTag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IeltseyeTag the static model class
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
		return '{{ieltseye_tag}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tagname', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('tagname', 'length', 'max'=>20),
			array('aliasWords', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tagid, tagname, aliasWords, status', 'safe', 'on'=>'search'),
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
            'tagItems' => array(self::HAS_MANY, 'IeltseyeTagitem', 'tagid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tagid' => 'Tagid',
			'tagname' => 'Tagname',
			'aliasWords' => 'Alias Words',
			'status' => 'Status',
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

		$criteria->compare('tagid',$this->tagid);
		$criteria->compare('tagname',$this->tagname,true);
        $criteria->compare('aliasWords',$this->aliasWords,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function beforeSave() {
        $this->checkAliasWords();
        return true;
    }
    
    public function checkAliasWords() {
        $alias = $aliasStr = '';
        if ($this->aliasWords) {
            $alias = str_replace(array(chr(0xa3) . chr(0xac), chr(0xa1) . chr(0x41), chr(0xef) . chr(0xbc) . chr(0x8c)), ',', $this->aliasWords);
            if (strpos($alias, ',') !== FALSE) {
                $aliasArray = array_unique(explode(',', $alias));
            } else {
                $alias = str_replace('　', ' ', $alias);
                $aliasArray = array_unique(explode(' ', $alias));
            }
            if ($aliasArray) {
                foreach($aliasArray as $aliasWord) {
                    $aliasWord = trim($aliasWord);
                    if(preg_match('/^([\x7f-\xff_-]|\w|\s){1,20}$/', $aliasWord)) {
                        $aliasStr[] = $aliasWord;
                    }
                }
            }
            $this->aliasWords = implode(',', $aliasStr);
            return true;
        }
        return false;
    }
}