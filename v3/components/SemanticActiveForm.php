<?php
    namespace app\components;

    use Yii;
    use yii\helpers\Json;
    use yii\helpers\Html;  
    use yii\base\InvalidCallException;
    
    class SemanticActiveForm extends \yii\widgets\ActiveForm
    {
        public $id = 'w0';
        public $ajax = false;
        public $options = [ 'class' => 'ui equal width form' ];
        public $fieldClass = 'app\components\SemanticActiveField';
        public $validationStateOn = self::VALIDATION_STATE_ON_INPUT;
        public static $dataAttributes = ['aria', 'data', 'data-ng', 'ng'];
        public static $submitAttributesOrder = [ 'type', 'id', 'class', 'name', 'value', 'form', 'disabled' ];
        
        public $script = true;
        public $enableClientScript = false;
        public $enableClientValidation = false;

        public function init() {
            parent::init();
            $this->enableClientScript = false;
            $this->enableClientValidation = false;
        }

        public function run()
        {
            if (!empty($this->_fields)) {
                throw new InvalidCallException('Each beginField() should have a matching endField() call.');
            }
    
            $content = ob_get_clean();
            $html = Html::beginForm($this->action, $this->method, $this->options);
            $html .= $content;

            if($this->script) 
                $this->registerScript();
          
            $html .= Html::endForm();
            return $html;
        }
        
        private function registerScript() {

            $id = $this->options['id'];
            $view = $this->getView();
            
            if($ajaxOptions = $this->ajax) {
                $progressBarActiveText  =   $ajaxOptions["activeText"] ? $ajaxOptions["activeText"] : "Guardando cambios {value}%";
                $progressBarSuccessText =   $ajaxOptions["successText"] ? $ajaxOptions["successText"] : "Datos guardados!";
                $progressBarErrorText   =   $ajaxOptions["errorText"] ? $ajaxOptions["errorText"] : "Hubo un error al completar la solicitud";

                $ajaxRedirect   =   $ajaxOptions["redirect"] ? "window.location= '" . $ajaxOptions['redirect'] . "';" : "";

                $debugError     =   YII_ENV_DEV ? "console.log(data);" : "";

                $script = <<<SCRIPT
                    let form_$id = document.querySelector("#$id");
                    let form_progress_$id = $("#$id .hidden.progress");

                    let form_conf_$id = {
                        url : form_$id.action,
                        method : form_$id.method,
                        contentType : form_$id.encoding,
                        success : data => {
                            $debugError
                            
                        },
                        error : (xhr, data, e) => {
                            form_progress_$id.progress("set error");
                            $debugError
                        },
                        xhr : function()
                        {
                            let xhr = new window.XMLHttpRequest();
                            
                            form_progress_$id.progress('set percent', 0);
                            form_progress_$id.removeClass("hidden");
                            
                            form_progress_$id.progress({
                                total    : 100,
                                text     : {
                                    active  : '$progressBarActiveText',
                                    success : '$progressBarSuccessText',
                                    error   : '$progressBarErrorText',
                                    ratio   : '{value} de {total}',
                                },
                                onSuccess: () => {
                                    $ajaxRedirect
                                }
                            });
                            
                            //Upload progress
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {  
                                    var percentComplete = 100 * evt.loaded / evt.total;
                                    console.log("u " + evt.loaded + " / " + evt.total + " = " + percentComplete);
                                    form_progress_$id.progress('set percent', percentComplete);
                                }
                            }, false); 
                            
                            //Download progress
                            xhr.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {  
                                    var percentComplete = 100 * evt.loaded / evt.total;
                                    console.log("d " + evt.loaded + " / " + evt.total + " = " + percentComplete);
                                    form_progress_$id.progress('set percent', percentComplete);
                                }
                            }, false); 

                            return xhr;
                        },
                    };
                    
                    $("#$id").form({
                        onSuccess : (event, fields) =>  {
                            event.preventDefault();
                            event.stopPropagation();

                            $("#$id input[type=checkbox]:not(:checked)").each( (i,n) => fields[n.name] = "0" );

                            if(form_conf_$id.contentType === "multipart/form-data" || form_conf_$id.contentType === false) {
                                form_conf_$id.cache         =   false;
                                form_conf_$id.processData   =   false;
                                form_conf_$id.contentType   =   false;
        
                                let dataEl = new FormData();
                                Object.entries(fields).forEach( i => dataEl.append(i[0], i[1]) );

                                $("#$id").find("input[type=file]").each( (n, i) => {
                                    //dataEl.delete(i.name);
                                    
                                    if(i.multiple) {
                                        dataEl.append(i.name, i.files);
                                    } else {
                                        dataEl.append(i.name, i.files[0]);
                                    }
                                });

                                form_conf_$id.data  =   dataEl;
                            }
                            else {
                                form_conf_$id.data = fields;
                            }
                            
                            $.ajax(form_conf_$id);
                        }
                    });

SCRIPT;
            }
            else {
                $script = <<<SCRIPT
                $('#$id').on('submit', e => {
                    let valid = $('#$id').form('validate form');  
                    if(!valid) {
                        e.preventDefault();
                        e.stopPropagation();
                    }

                    return valid;
                });

SCRIPT;
            }

            $view->registerJs($script, $view::POS_END);
        }

        public function submitButton($content = 'Submit', $icon = "", $options = [])
        {
            $options['type'] = 'submit';
            $progressBar = "";
            
            if($icon) {
                if($content)
                    $options['class'].= " labeled icon";

                $content = "<i class= '$icon icon'></i>" . $content;
            }

            if($this->ajax) {
                $progressBarClass   =   $this->ajax["class"] ? $this->ajax["class"] : "";
                $progressBar =
                    "<div class='ui {$progressBarClass} progress hidden'>
                        <div class='bar'>
                            <div class='progress'></div>
                        </div>
                        <div class='label'></div>
                    </div>";
            }

            $html = "$progressBar<div class= 'field'><button" . static::renderSubmit($options) . ">$content</button></div>";

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