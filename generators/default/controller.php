<?php
/**
 * 生成控制器文件的模板.
 */

use yii\helpers\StringHelper;
use yii\db\ActiveRecordInterface;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 首页（显示记录列表）<?= $modelClass ?>.
     * @return mixed
     */
    public function actionIndex()
    {    
       <?php if (!empty($generator->searchModelClass)): ?>
 $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }


    /**
     * 查看详情<?= $modelClass ?>.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView(<?= $actionParams ?>)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "<?= $modelClass ?> #".<?= $actionParams ?>,
                    'size' => 'large',
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel(<?= $actionParams ?>),
                    ]),
                    'footer'=> Html::button('<i class="glyphicon glyphicon-ban-circle"></i> 关闭',['class'=>'btn btn-danger','data-dismiss'=>"modal"])
                   ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel(<?= $actionParams ?>),
            ]);
        }
    }

    /**
     *插入一条记录 <?= $modelClass ?>.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new <?= $modelClass ?>();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "创建 <?= $modelClass ?>",
                    'size' => 'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="glyphicon glyphicon-ban-circle"></i> 关闭',['class'=>'btn btn-danger','data-dismiss'=>"modal"]).
                                Html::button('<i class="glyphicon glyphicon-ok"></i> 保存',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "新建 <?= $modelClass ?>",
                    'content'=>'<span class="text-success">创建 <?= $modelClass ?> 成功</span>',
                    'footer'=> Html::button('<i class="glyphicon glyphicon-ban-circle"></i> 关闭',['class'=>'btn btn-danger','data-dismiss'=>"modal"]).
                            Html::a('<i class="glyphicon glyphicon-ok"></i> 继续创建',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "创建 <?= $modelClass ?>",
                    'size' => 'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="glyphicon glyphicon-ban-circle"></i> 关闭',['class'=>'btn btn-danger','data-dismiss'=>"modal"]).
                                Html::button('<i class="glyphicon glyphicon-ok"></i> 保存',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', <?= $urlParams ?>]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * 修改记录：<?= $modelClass ?> .
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;
        $model = $this->findModel(<?= $actionParams ?>);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "更新 <?= $modelClass ?> #".<?= $actionParams ?>,
                    'size' => 'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="glyphicon glyphicon-ban-circle"></i> 关闭',['class'=>'btn btn-danger','data-dismiss'=>"modal"]).
                                Html::button('<i class="glyphicon glyphicon-ok"></i> 保存',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "<?= $modelClass ?> #".<?= $actionParams ?>,
                    'size' => 'large',
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="glyphicon glyphicon-ban-circle"></i> 关闭',['class'=>'btn btn-danger','data-dismiss'=>"modal"])
                ];    
            }else{
                 return [
                    'title'=> "更新 <?= $modelClass ?> #".<?= $actionParams ?>,
                    'size' => 'large',
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="glyphicon glyphicon-ban-circle"></i> 关闭',['class'=>'btn btn-danger','data-dismiss'=>"modal"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', <?= $urlParams ?>]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * 删除记录<?= $modelClass ?>(从列表删除，删除后刷新列表页面) .
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;
        $this->findModel(<?= $actionParams ?>)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

    /**
    * 删除记录从消息页面modal<?= $modelClass ?>.
    * For ajax request will return json object
    * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
    * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
    * @return mixed
    */
    public function actionDeletefromdetail(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;
        $ret = $this->findModel(<?= $actionParams ?>)->delete();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            if($ret === false){
                return [
                    'success' => false,
                    'messages' => [
                    'kv-detail-danger' => '删除失败',
                    ]
                ];
            }

            return [
                'forceClose'=>true,
                'forceReload'=>'#crud-datatable-pjax',
                'success' => true,
                'messages' => [
                    'kv-detail-success' => '删除成功',
                ]
            ];
        }else{
            return $this->redirect(['index']);
        }
    }

     /**
     * 批量删除记录<?= $modelClass ?>.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
    * 激活
    * @param integer $id
    * @return type
    */
    /*public function actionActivate($id)
    {
        $model = $this->findModel($id);
        if ($model->status == 0) {
            $model->status = 1;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->save()) {
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }
    }*/

    /**
    * 禁用
    * @param integer $id
    * @return type
    */
    /*public function actionInactivate($id)
    {
        $model = $this->findModel($id);

        if ($model->status == 1) {
            $model->status = 0;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->save()) {
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }
    }*/


    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('页面不存在.');
        }
    }
}
