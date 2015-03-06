<?php

namespace yii3ds\shoppinglists\controllers\frontend;

use yii3ds\shoppinglists\models\frontend\Product;
use yii3ds\shoppinglists\components\Productcomponent;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\HttpException;
use yii\helpers\Url;


/**
 * Default controller.
 */
class DefaultController extends Controller
{

    public $enableCsrfValidation = false;
    public $category;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        if (!isset($behaviors['access']['class'])) {
            $behaviors['access']['class'] = AccessControl::className();
        }

        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['index', 'view'],
            'roles' => ['viewProducts']
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get', 'post'],
                'view' => ['get', 'post']
            ]
        ];
        $behaviors['ContentNegotiator'] = 
        [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
            'languages' => [
                'en',
                'th',
            ],
        ];
        return $behaviors;
    }
    /**
     * Product list page.
     */
    function actionIndex($id='')
    {

        $this->setCategory();
        return $this->getProductsResult($id,\yii::$app->request->get('language','th'));
    }

    public function setCategory()
    {
        $this->category = \yii::$app->request->get('category');
    }

    function getProductsResult($id='',$language='')
    {
        $result = [];
        if ($this->isInputNotHaveProductsID($id)) {
            $result = $this->getAllProductsData($language);
        }else{
            $result = $this->getProductsById($id, $language);
        }

        return $this->createResult($result, $language);
    }
    function isInputNotHaveProductsID($id)
    {
        return empty($id);
    }
    function isDataEmpty($data='')
    {
        return empty($data);
    }
    function requestLanguageIsEnglish($language)
    {
        return $language === "en" ? true : false;
    }
    function getAllProductsData($language)
    {
        $isNull = $this->category == null;
        if( $isNull )
        {
            $findObject = Product::find();
        } else {
            $findObject = Product::find()->where(['category' => $this->category]);
        }
        if( $this->requestLanguageIsEnglish($language) )
        {
            $query = $findObject->resultAllEnglish()->asArray();
        } else {
            $query = $findObject->resultAllThai()->asArray();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->module->recordsPerPage
            ]
        ]);
        
        return $dataProvider->getModels();
    }
    function getProductsById($id='', $language)
    {
        $isNull = $this->category == null;
        if( $isNull )
        {
            $findObject = Product::find(['id'=>$id]);
        } else {
            $findObject = Product::find(['id'=>$id])->where(['category' => $this->category]);
        }

        if(  $this->requestLanguageIsEnglish($language) )
        {
            return $findObject->resultOneEnglish()->asArray()->one();
        }
        return $findObject->resultOneThai()->asArray()->one();
    }
    
   
    

    function createResult($data='')
    {
        $result = [
            'success' => true,
            'result' => $data
        ];
        if ($this->isDataEmpty($data)) {
            $result = [
                'success' => false,
                'message' => 'Data not found',
                'result' => [],
            ];
        }
        return $result;
    }

    /**
     * Product page.
     *
     * @param integer $id Product ID
     * @param string $alias Product alias
     *
     * @return mixed
     *
     * @throws \yii\web\HttpException 404 if event was not found
     */
    public function actionView($id, $alias)
    {
        if (($model = Product::findOne(['id' => $id, 'alias' => $alias])) !== null) {
            $this->counter($model);

            return $this->render('view', [
                'model' => $model
            ]);
        } else {
            throw new HttpException(404);
        }
    }

    /**
     * Update event views counter.
     *
     * @param Product $model Model
     */
    protected function counter($model)
    {
        $cookieName = 'shoppinglists-views';
        $shouldCount = false;
        $views = Yii::$app->request->cookies->getValue($cookieName);

        if ($views !== null) {
            if (is_array($views)) {
                if (!in_array($model->id, $views)) {
                    $views[] = $model->id;
                    $shouldCount = true;
                }
            } else {
                $views = [$model->id];
                $shouldCount = true;
            }
        } else {
            $views = [$model->id];
            $shouldCount = true;
        }

        if ($shouldCount === true) {
            if ($model->updateViews()) {
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => $cookieName,
                    'value' => $views,
                    'expire' => time() + 86400 * 365
                ]));
            }
        }
    }
}
