<?php
    namespace app\components;

    use yii\helpers\Html;
    
    class SemanticActiveField extends \yii\widgets\ActiveField
    {
        public $options = ['class' => 'field'];
        public $template = "{label}\n{input}\n{hint}\n{error}";
        public $inputOptions = ['class' => ''];
        public $labelOptions = ['class' => ''];
        public $errorOptions = ['class' => 'help-block'];
        public $hintOptions = ['class' => 'hint-block'];

        public function checkbox($options = [], $enclosedByLabel = true)
        {
            if ($enclosedByLabel) {
                $this->parts['{input}'] = "<div class= 'ui checkbox'>" . Html::activeCheckbox($this->model, $this->attribute, $options)  . "</div>";
                $this->parts['{label}'] = '';
            } else {
                if (isset($options['label']) && !isset($this->parts['{label}'])) {
                    $this->parts['{label}'] = $options['label'];
                    if (!empty($options['labelOptions'])) {
                        $this->labelOptions = $options['labelOptions'];
                    }
                }
                unset($options['labelOptions']);
                $options['label'] = null;
                $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);
            }

            if ($this->form->validationStateOn === SemanticActiveForm::VALIDATION_STATE_ON_INPUT) {
                $this->addErrorClassIfNeeded($options);
            }

            $this->addAriaAttributes($options);
            $this->adjustLabelFor($options);

            return $this;
        }

    }
?>