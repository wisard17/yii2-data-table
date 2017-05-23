<?php
/**
 * Created by.
 * User: wisard17
 * Date: 5/23/2017
 * Time: 10:04 AM
 */

namespace yii\datatable;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\web\View;

/**
 * @author Wisard Kalengkongan <wisard.kalengkongan@gmail.com>
 *
 * Class DataTableView
 * @property string jsonData
 * @package yii\datatable
 */
class DataTableView extends Widget
{
    /**
     * @var array the HTML attributes for the container tag of the list view.
     * The "tag" element specifies the tag name of the container element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /** @var \yii\data\DataProviderInterface the data provider for the view. This property is required. */
    public $dataProvider;

    public $allData;

    public $filterModel;

    public $columns;

    public $request;


    /**
     * Initializes the view.
     */
    public function init()
    {
        parent::init();
        if ($this->dataProvider === null) {
            throw new InvalidConfigException('The "dataProvider" property must be set.');
        }

        if ($this->allData === null) {
            $this->allData = $this->dataProvider->getTotalCount();
        }

        if ($this->filterModel === null) {
            throw new InvalidConfigException('The "filterModel" property must be set.');
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        echo $this->loadTable();
        DataTableAsset::register($this->view);
        $this->runJs();
    }

    public function loadTable()
    {
        $content = '';

        return Html::tag('table', $content,
            ['class' => "table table-responsive", 'width' => "100%", 'id' => $this->options['id']]);
    }

    public function renderContent()
    {
        $out = [];
        foreach ($this->dataProvider->getModels() as $model) {
            $item = [];
            foreach ($this->columns as $column) {
                $ext = explode('__', $column);
                if (is_array($ext) && sizeof($ext) == 2) {
                    if ($model->$ext[0] != null)
                        $item[$column] = $model->$ext[0]->$ext[1];
                    else
                        $item[$column] = '';
                } else {
                    $item[$column] = $model->$column;
                }
            }
            $out[] = $item;
        }
        return $out;
    }

    public function getJsonDataTable()
    {
        return Json::encode([
            "draw" => isset ($this->request['draw']) ? intval($this->request['draw']) : 0,
            "recordsTotal" => intval($this->allData),
            "recordsFiltered" => intval($this->dataProvider->getTotalCount()),
            "data" => $this->renderContent(),
        ]);
    }

    protected function getJsonData()
    {
        return Json::encode($this->renderContent());
    }

    protected function loadColumnHeader()
    {
        $out = [];
        foreach ($this->columns as $column) {
            $out[] = [
                'title' => Html::activeLabel($this->model, $column),
                'data' => "$column",
            ];
        }

        return $out;
    }

    protected function runJs()
    {
        $csrf = Yii::$app->request->getCsrfToken();

        $idTable = $this->options['id'];

        $columns = Json::encode($this->loadColumnHeader());

        $jsScript = <<< JS
var renderdata = (function () {
    var dataSet = $this->jsonData;
    var domElement = $('#$idTable');
    
    var table = domElement.DataTable({
        data : dataSet,
        rowId: "Order_No",
        "processing": true,
        // "serverSide": true,
        

        order: [[0, "desc"]],
        initComplete: function () {

        }

    });

    

    return {
        "test": function () {
            alert('daa');
        },
        table: table
    };
})();        

JS;

        $this->view->registerJs($jsScript, View::POS_READY, 'runfor_' . $this->options['id']);
    }


}