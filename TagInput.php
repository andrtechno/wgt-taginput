<?php

/**
 *
 *
 * @author CORNER CMS <dev@corner-cms.com>
 * @link http://www.corner-cms.com/
 */

namespace panix\ext\taginput;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class TagInput extends InputWidget {

    public function run() {
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
        $this->registerClientScript();
    }

    protected function registerClientScript() {
        $view = $this->getView();
        Asset::register($view);
        $options = Json::encode($this->options);
        $js[] = "$('#{$this->options['id']}').tagEditor({$options});";
        $view->registerJs(implode("\n", $js));
    }

}