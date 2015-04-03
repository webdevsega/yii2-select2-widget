<?php

namespace webdevsega\select2;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class Widget extends InputWidget
{
    /**
     * @var array Select items
     */
    public $items = [];

    /**
     * @var array widget plugin options
     */
    public $pluginOptions = [];

    /**
     * @var array widget JQuery events. You must define events in
     * event-name => event-function format
     * for example:
     * ~~~
     * pluginEvents = [
     *        "change" => "function() { log("change"); }",
     *        "open" => "function() { log("open"); }",
     * ];
     * ~~~
     */
    public $pluginEvents = [];

    /**
     * @var string selector for init js scripts
     */
    protected $selector = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->pluginOptions['language'])) {
            $appLanguage = strtolower(substr(Yii::$app->language, 0, 2));
            if ($appLanguage !== 'en') {
                $this->pluginOptions['language'] = $appLanguage;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->selector = '#' . $this->options['id'];

        if ($this->hasModel()) {
            echo Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        } else {
            echo Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }

        $this->registerClientScript();
        $this->registerEvents();
    }

    /**
     * Register widget asset.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();

        $asset = Select2Asset::register($view);

        if (!empty($this->pluginOptions['language'])) {
            $asset->language = $this->pluginOptions['language'];
        }

        $options = empty($this->pluginOptions) ? '' : Json::encode($this->pluginOptions);
        $js = "jQuery('{$this->selector}').select2({$options});";
        $view->registerJs($js);
    }

    /**
     * Register widget events.
     */
    protected function registerEvents()
    {
        if (!empty($this->pluginEvents)) {
            $js = [];
            foreach ($this->pluginEvents as $event => $handler) {
                $js[] = "jQuery('{$this->selector}').on('{$event}', $handler);";
            }

            $this->getView()->registerJs(implode("\n", $js));
        }
    }
}
