<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SysMessgeTest
 *
 * @author Reda BENHEMMOUCHE
 */
class SysMessageTest extends CDbTestCase {

    public $fixtures = array(
        'messages' => 'SysMessage',
    );

    public function testGetLatest() {

        $message = SysMessage::getLatest();
        //echo '###### cachePath : '.Yii::app()->cache->cachePath;
        $this->assertTrue($message instanceof SysMessage);
    }

}

?>
