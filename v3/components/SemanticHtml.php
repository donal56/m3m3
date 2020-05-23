<?php

namespace app\components;

use yii\helpers\BaseHtml;
use yii\helpers\ArrayHelper;

class SemanticHtml extends BaseHtml
{

    public static function radioList($name, $selection = null, $items = [], $options = [])
    {
        if (ArrayHelper::isTraversable($selection)) {
            $selection = array_map('strval', ArrayHelper::toArray($selection));
        }

        $formatter = ArrayHelper::remove($options, 'item');
        $itemOptions = ArrayHelper::remove($options, 'itemOptions', []);
        $encode = ArrayHelper::remove($options, 'encode', true);
        $separator = ArrayHelper::remove($options, 'separator', "\n");
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        $hidden = '';
        if (isset($options['unselect'])) {
            // add a hidden field so that if the list box has no option being selected, it still submits a value
            $hiddenOptions = [];
            // make sure disabled input is not sending any value
            if (!empty($options['disabled'])) {
                $hiddenOptions['disabled'] = $options['disabled'];
            }
            $hidden =  static::hiddenInput($name, $options['unselect'], $hiddenOptions);
            unset($options['unselect'], $options['disabled']);
        }

        $lines = [];
        $index = 0;
        foreach ($items as $value => $label) {
            $checked = $selection !== null &&
                (!ArrayHelper::isTraversable($selection) && !strcmp($value, $selection)
                    || ArrayHelper::isTraversable($selection) && ArrayHelper::isIn((string) $value, $selection));
            if ($formatter !== null) {
                $lines[] = call_user_func($formatter, $index, $label, $name, $checked, $value);
            } else {
                $lines[] = '<div class="field"><div class="ui radio checkbox">' . 
                    static::radio($name, $checked, array_merge(['value' => $value], $itemOptions)) . 
                    static::label($encode ? static::encode($label) : $label, $name) . '</div></div>';
            }
            $index++;
        }
        $visibleContent = implode($separator, $lines);

        if ($tag === false) {
            return $hidden . $visibleContent;
        }

        return $hidden . static::tag($tag, $visibleContent, $options);
    }

    protected static function booleanInput($type, $name, $checked = false, $options = [])
    {
        // 'checked' option has priority over $checked argument
        if (!isset($options['checked'])) {
            $options['checked'] = (bool) $checked;
        }
        $value = array_key_exists('value', $options) ? $options['value'] : '1';
        if (isset($options['uncheck'])) {
            // add a hidden field so that if the checkbox is not selected, it still submits a value
            $hiddenOptions = [];
            if (isset($options['form'])) {
                $hiddenOptions['form'] = $options['form'];
            }
            // make sure disabled input is not sending any value
            if (!empty($options['disabled'])) {
                $hiddenOptions['disabled'] = $options['disabled'];
            }
            $hidden = static::hiddenInput($name, $options['uncheck'], $hiddenOptions);
            unset($options['uncheck']);
        } else {
            $hidden = '';
        }
        if (isset($options['label'])) {
            $label = $options['label'];
            $labelOptions = isset($options['labelOptions']) ? $options['labelOptions'] : [];
            unset($options['label'], $options['labelOptions']);
            $content = static::input($type, $name, $value, $options) . static::label($label, null, $labelOptions);
            return $hidden . $content;
        }

        return static::input($type, $name, $value, $options) . $hidden;
    }
}
