<?php

namespace webdevsega\select2;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    /**
     * @var string Plugin language
     */
    public $language;

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/select2/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/select2.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/select2.min.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * @inheritdoc
     */
    public function registerAssetFiles()
    {
        if ($this->language !== null) {
            $this->js[] = 'js/i18n/' . $this->language . '.js';
        }

        parent::registerAssetFiles();
    }
}
