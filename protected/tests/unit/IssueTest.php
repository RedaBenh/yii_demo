<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IssueTest
 *
 * @author Reda BENHEMMOUCHE
 */
class IssueTest extends CDbTestCase {

    public $fixtures = array
        (
        'projects' => 'Project',
        'issues' => 'Issue',
    );

    public function testGetTypes() {
        $options = Issue::model()->typeOptions;
        $this->assertTrue(is_array($options));
        $this->assertTrue(3 == count($options));
        $this->assertTrue(in_array('Bug', $options));
        $this->assertTrue(in_array('Feature', $options));
        $this->assertTrue(in_array('Task', $options));
    }

    public function testGetStatus() {
        $options = Issue::model()->statusOptions;
        $this->assertTrue(is_array($options));
        $this->assertTrue(3 == count($options));
        $this->assertTrue(in_array('Not yet started', $options));
        $this->assertTrue(in_array('Started', $options));
        $this->assertTrue(in_array('Finished', $options));
    }

    public function testGetStatusText() {
        $issue1 = $this->issues('issueBug');
        $this->assertTrue('Started' == $issue1->getStatusText());
    }

    public function testGetTypeText() {
        $issue1 = $this->issues('issueBug');
        $this->assertTrue('Bug' == $issue1->getTypeText());
    }
    
    public function testAddComment() {
        $comment = new Comment;
        $comment->content = "this is a test comment";
        $this->assertTrue($this->issues('issueBug')->addComment($comment));
    }

}
?>
