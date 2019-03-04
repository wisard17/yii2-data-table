<p align="center">
        <img src="https://avatars2.githubusercontent.com/u/278219?s=400&v=4" height="80px">
    </a>
    <h1 align="center">DataTables Extension for Yii 2</h1>
    <br>
</p>

Extension for [Yii framework 2.0](http://www.yiiframework.com). to used [DataTables](http://www.datatables.net) easy.  

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist wisard17/yii2-data-table
```

or add

```
"wisard17/yii2-data-table": "~1.0.0"
```

to the require section of your `composer.json` file.

Usage
----

For example, the following is simple code:

```php
<?= wisard17\DataTableView::widget([
    'columns' => [
        'Customer_ID',
        'action',
        'Customer_Name',
        'Office_Phone',
        'Office_Email',
    ],
    'model' => new Model(),
]) ?>
```
