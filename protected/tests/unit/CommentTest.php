<?php

class CommentTest extends CDbTestCase {

    public $fixtures = array(
        'comments' => 'Comment',
        'projects' => 'Project',
        'issues' => 'Issue',
    );

    public function testRecentComments() {
        $recentComments = Comment::findRecentComments();
        $this->assertTrue(is_array($recentComments));
    }

}

?>
