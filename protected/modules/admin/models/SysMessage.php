<?php

/**
 * This is the model class for table "tbl_sys_message".
 *
 * The followings are the available columns in table 'tbl_sys_message':
 * @property integer $id
 * @property string $message
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class SysMessage extends TrackstarActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SysMessage the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_sys_message';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('message', 'required'),
            //array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
            //array('create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, message, create_time, create_user_id, update_time, update_user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'message' => 'Message',
            'create_time' => 'Create Time',
            'create_user_id' => 'Create User',
            'update_time' => 'Update Time',
            'update_user_id' => 'Update User',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('create_user_id', $this->create_user_id);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_user_id', $this->update_user_id);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Retrieves the most recent system message.
     * @return SysMessage the AR instance representing the latest
      system message.
     */
    public static function getLatest() {
        //see if it is in the cache, if so, just return it
        if (($cache = Yii::app()->cache) !== null) {
            $key = 'TrackStar.ProjectListing.SystemMessage';
            if (($sysMessage = $cache->get($key)) !== false)
                return $sysMessage;
        }
        //The system message was either not found in the cache, or
        //there is no cache component defined for the application
        //retrieve the system message from the database
        $sysMessage = SysMessage::model()->find(array(
            'order' => 't.update_time DESC',
                ));
        if ($sysMessage != null) {
        //a valid message was found. Store it in cache for future retrievals
            if (isset($key))
                $cache->set($key, $sysMessage, 300);
               // $cache->set($key, $sysMessage, 0, new CDbCacheDependency('select id,message from tbl_sys_message order by update_time desc'));
            return $sysMessage;
        }
        else
            return null;
    }

}