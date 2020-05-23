<?php
    namespace app\components;

    use Yii;
    use yii\helpers\Json;
    use yii\helpers\Html;  
    use yii\base\InvalidCallException;
    
    class SemanticActiveForm extends \yii\widgets\ActiveForm
    {
        public $id = 'w0';
        public $enableClientScript = false;
        public $enableClientValidation = false;
        public $options = [ 'class' => 'ui equal width form' ];
        public $fieldClass = 'app\components\SemanticActiveField';
        public $validationStateOn = self::VALIDATION_STATE_ON_INPUT;
        public static $dataAttributes = ['aria', 'data', 'data-ng', 'ng'];
        public static $submitAttributesOrder = [ 'type', 'id', 'class', 'name', 'value', 'form', 'disabled' ];

        public function run()
        {
            if (!empty($this->_fields)) {
                throw new InvalidCallException('Each beginField() should have a matching endField() call.');
            }
    
            $content = ob_get_clean();
            $html = Html::beginForm($this->action, $this->method, $this->options);
            $html .= $content;

            $id = $this->options['id'];
            $view = $this->getView();
            $view->registerJs("$('#$id').on('submit', e => {
                let valid = $('#$id').form('validate form');  
                if(!valid) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                return valid;
            });", $view::POS_END);

            $html .= Html::endForm();
            return $html;
        }

        public function submitButton($content = 'Submit', $icon = "", $options = [])
        {
            $options['type'] = 'submit';
            
            if($icon) {
                $content = "<i class= '$icon icon'></i>" . $content;
                $options['class'].= " labeled icon";
            }

            $html = "<div class= 'field'><button" . static::renderSubmit($options) . ">$content</button></div>";

            return $html;
        }

        public function errorBox($addClass = "")
        {
            return "<div class='ui error message $addClass field'></div>";
        }

        public static function renderSubmit($attributes)
        {
            if (count($attributes) > 1) {
                $sorted = [];
                foreach (static::$submitAttributesOrder as $name) {
                    if (isset($attributes[$name])) {
                        $sorted[$name] = $attributes[$name];
                    }
                }
                $attributes = array_merge($sorted, $attributes);
            }
    
            $html = '';
            foreach ($attributes as $name => $value) {
                if (is_bool($value)) {
                    if ($value) {
                        $html .= " $name";
                    }
                } elseif (is_array($value)) {
                    if (in_array($name, static::$dataAttributes)) {
                        foreach ($value as $n => $v) {
                            if (is_array($v)) {
                                $html .= " $name-$n='" . Json::htmlEncode($v) . "'";
                            } elseif (is_bool($v)) {
                                if ($v) {
                                    $html .= " $name-$n";
                                }
                            } elseif ($v !== null) {
                                $html .= " $name-$n=\"" . static::encode($v) . '"';
                            }
                        }
                    } elseif ($name === 'class') {
                        if (empty($value)) {
                            continue;
                        }
                        $html .= " $name=\"" . static::encode(implode(' ', $value)) . '"';
                    } elseif ($name === 'style') {
                        if (empty($value)) {
                            continue;
                        }
                        $html .= " $name=\"" . static::encode(static::cssStyleFromArray($value)) . '"';
                    } else {
                        $html .= " $name='" . Json::htmlEncode($value) . "'";
                    }
                } elseif ($value !== null) {
                    $html .= " $name=\"" . static::encode($value) . '"';
                }
            }
    
            return $html;
        }

        public static function cssStyleFromArray(array $style)
        {
            $result = '';
            foreach ($style as $name => $value) {
                $result .= "$name: $value; ";
            }
            
            return $result === '' ? null : rtrim($result);
        }

        public static function encode($content, $doubleEncode = true)
        {
            return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, Yii::$app ? Yii::$app->charset : 'UTF-8', $doubleEncode);
        }
    }
?>