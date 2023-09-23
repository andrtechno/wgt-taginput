<?php

namespace panix\ext\taginput;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * Class TagInput
 * @package panix\ext\taginput
 */
class TagInput extends InputWidget
{

    public $placeholder;
    public $suggestUrl;

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        $view = $this->getView();
        Asset::register($view);

        if ($this->placeholder)
            $this->options['placeholder'] = $this->placeholder;

        if($this->suggestUrl){
            $this->options['autocomplete']['source'] = new JsExpression('tagSuggest');
            $this->options['autocomplete']['minLength'] = 1;
            $this->options['autocomplete']['delay'] = 250;
            $this->options['autocomplete']['position'] = ['collision' => 'flip'];

            $view->registerJs("
                var tag_cache = {};
                var tag_xhr;
                function tagSuggest(request, response) {
                    if (typeof tag_xhr !== 'undefined')
                        tag_xhr.abort();

                    var term = request.term;
                    if (term in tag_cache) { response(tag_cache[term]); return; }
                    tag_xhr = $.ajax({
                        url: '".$this->suggestUrl."',
                        dataType: 'json',
                        data: { q: term },
                        success: function(data) {
                            var suggestions = [];
                            $.each(data, function(key, value) {
                                suggestions.push({label: value, value: value});
                            });
                            tag_cache[term] = suggestions;
                            response(suggestions);
                        }
                    });
                }
            ");
        }

        $options = Json::encode($this->options);
        $js[] = "$('#{$this->options['id']}').tagEditor({$options});";
        $view->registerJs(implode("\n", $js));
    }

}
