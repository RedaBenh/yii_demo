<?php
$this->breadcrumbs = array(
    'Projects',
);

$this->menu = array(
    array('label' => 'Create Project', 'url' => array('create')),
    array('label' => 'Manage Project', 'url' => array('admin')),
);
?>

<?php if ($sysMessage != null): ?>
    <div class="sys-message">
        <?php echo $sysMessage; ?>
    </div>
    <?php
    Yii::app()->clientScript->registerScript(
            'fadeAndHideEffect', '$(".sys-message").animate({opacity: 1.0}, 2000).fadeOut("slow");'
    );
endif;
?>

<h1>Projects</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>

<?php

$key = "TrackStar.ProjectListing.RecentComments";
if ($this->beginCache($key, array('duration' => 60))) {
    echo 'time to check cache : '.time();
    $this->beginWidget('zii.widgets.CPortlet', array(
        'title' => 'Recent Comments',
    ));
    $this->widget('RecentComments');
    $this->endWidget();
    $this->endCache();
}
?>
