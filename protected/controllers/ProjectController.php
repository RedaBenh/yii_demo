<?php

class ProjectController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to 'column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'column2';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            /*
             //there are a problem in related issues list (can't go next page pagination) 
            array(
                'COutputCache + view', //cache the entire output from the actionView() method for 2 minutes
                'duration' => 60,
                'varyByParam' => array('id'),
            ),
             */
            array(
                'COutputCache + index', //cache the entire output from the actionView() method for 2 minutes
                'duration' => 60,
                'varyBySession' => true, //to reset content when user change session
            ),
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'adduser'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     */
    public function actionView() {
        $issueDataProvider = new CActiveDataProvider('Issue', array(
                    'criteria' => array(
                        'condition' => 'project_id=:projectId',
                        'params' => array(':projectId' => $this->loadModel()->id),
                    ),
                    'pagination' => array(
                        'pageSize' => 1,
                    ),
                ));
        Yii::app()->clientScript->registerLinkTag('alternate', 'application/rss+xml', $this->createUrl('comment/feed', array('pid' => $this->loadModel()->id)));

        $this->render('view', array(
            'model' => $this->loadModel(),
            'issueDataProvider' => $issueDataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Project;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate() {
        $model = $this->loadModel();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete() {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Project');
        Yii::app()->clientScript->registerLinkTag('alternate', 'application/rss+xml', $this->createUrl('comment/feed'));
        ////get the latest system message to display based on the update_time column
        // $sysMessage = SysMessage::model()->find(array(
        //    'order' => 't.update_time DESC',
        //       ));
        $sysMessage = SysMessage::getLatest();
        if ($sysMessage != null) {

            /*
              $cache = Yii::app()->cache;
              $key = 'TrackStar.ProjectListing.SystemMessage';
              $cache->set($key, $sysMessage, 300);
              //FIXME don't work
              //$cache->set($key, $sysMessage->message, 0,
              //        new CDbCacheDependency('select id,message from tbl_sys_message order by update_time desc'));
             */

            $message = $sysMessage->message;
        } else {
            $message = null;
        }$this->render('index', array(
            'dataProvider' => $dataProvider,
            'sysMessage' => $message,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Project('search');
        if (isset($_GET['Project']))
            $model->attributes = $_GET['Project'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Project::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            //throw new CException('The is an example of throwing a CException');
        }
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'project-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAdduser() {
        $project = $this->loadModel();
        if (!Yii::app()->user->checkAccess('createUser', array('project' => $project))) {
            throw new CHttpException(403, 'You are not authorized to per-form this action.');
        }
        $form = new ProjectUserForm;
        // collect user input data
        if (isset($_POST['ProjectUserForm'])) {
            $form->attributes = $_POST['ProjectUserForm'];
            $form->project = $project;
            // validate user input and set a sucessfull flassh message if valid   
            if ($form->validate()) {
                Yii::app()->user->setFlash('success', $form->username . " has been added to the project.");
                $form = new ProjectUserForm;
            }
        }
        // display the add user form
        $users = User::model()->findAll();
        $usernames = array();
        foreach ($users as $user) {
            $usernames[] = $user->username;
        }
        $form->project = $project;
        $this->render('adduser', array('model' => $form, 'usernames' => $usernames));
    }

}
