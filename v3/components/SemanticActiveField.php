<?php

namespace app\components;

use yii\helpers\Html;
use app\components\SemanticHtml;

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

    public function dropDownList($items, $options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        
        if(!isset($options["class"]) || empty($options["class"]))
            $options["class"] = "ui selection dropdown";
        
        if(!isset($options["encode"]))
            $options["encode"] = false;

        if ($this->form->validationStateOn === SemanticActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        return $this;
    }

     /* Thumbnail: Defaults to false, enabled if true, enabled with custom class if string */
     public function fileInput($thumbnail = false, $options = [])
     {
         if(!isset($options["hiddenOptions"]))
             $options["hiddenOptions"] = ["name" => "hidden_file_input_" . $this->attribute];
 
         // https://github.com/yiisoft/yii2/pull/795
         if ($this->inputOptions !== ['class' => 'form-control']) {
             $options = array_merge($this->inputOptions, $options);
         }
         // https://github.com/yiisoft/yii2/issues/8779
         if (!isset($this->form->options['enctype'])) {
             $this->form->options['enctype'] = 'multipart/form-data';
         }
 
         if ($this->form->validationStateOn === SemanticActiveForm::VALIDATION_STATE_ON_INPUT) {
             $this->addErrorClassIfNeeded($options);
         }
         
         $this->addAriaAttributes($options);
         $this->adjustLabelFor($options);
         $this->parts['{input}'] = Html::activeFileInput($this->model, $this->attribute, $options);
         
         if($thumbnail && !isset($options["multiple"])) {
             $view   =   $this->form->getView();
             $attr   =   $this->attribute;
             $id     =   static::getInputId($this->model, $attr);
             $file   =   $this->model->$attr;
             $thumbnailClass = $thumbnail === true ? "custom thumbnail avatar" : $thumbnail;
 
             $thumbnailHtml = Html::img($file, [
                 "class" =>  $thumbnailClass,
                 "id"    =>  "thumbnail-$attr",
             ]);
 
             if($file)
                 $thumbnailHtml = Html::a($thumbnailHtml, $file, [
                     "target"    =>  "_blank",
                     "class"     =>  $thumbnailClass,
                 ]);
             
             $this->parts['{input}'] = $thumbnailHtml . $this->parts['{input}'];
 
             $script = <<<SCRIPT
                 $('#$id').on('change', () => {
                     let input    =   document.querySelector('#$id');
                      
                     if (input.files && input.files[0]) {
                         let reader = new FileReader();
                         let link = input.previousElementSibling.previousElementSibling;
 
                         if(link.classList.value == "$thumbnailClass")
                             link.removeAttribute("href");
                  
                         reader.onload = e => $('#thumbnail-$attr').attr('src', e.target.result);
                         reader.readAsDataURL(input.files[0]);
                     }
                 });
 SCRIPT;
 
             $view->registerJs($script, $view::POS_END);
         }
         
         return $this;
     }

    public function radioList($items, $options = ['class' => 'inline fields'])
    {
        if ($this->form->validationStateOn === SemanticActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addRoleAttributes($options, 'radiogroup');
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = SemanticHtml::activeRadioList($this->model, $this->attribute, $items, $options);

        return $this;
    }

    public function textarea($options = [])
    {
        $options = array_merge($this->inputOptions, $options);

        if ($this->form->validationStateOn === SemanticActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }
        
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);
        
        if(isset($options["info"]))
            $this->parts['{input}'] .= "<label class='field info'>{$options["info"]}</label>";

        return $this;
    }

    public function toogle($options = [])
    {
        $options["toogle"] = true;

        $this->parts['{label}'] = '';
        $this->parts['{input}'] = "<div class= 'ui toggle checkbox'>" . SemanticHtml::activeCheckbox($this->model, $this->attribute, $options) . "</div>";

        if ($this->form->validationStateOn === SemanticActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        return $this;

    }
    
}
