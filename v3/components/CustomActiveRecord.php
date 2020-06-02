<?php
    namespace app\components;

    use ReflectionClass;
    use yii\db\ActiveRecord;

    class CustomActiveRecord extends ActiveRecord 
    {
        public function attributes()
        {
            $class = new ReflectionClass($this);
            $nonStaticPublicFields = [];
            $databaseFields = array_keys(static::getTableSchema()->columns);

            foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
                if (!$property->isStatic()) {
                    $nonStaticPublicFields[] = $property->getName();
                }
            }
            
            return array_merge($nonStaticPublicFields, $databaseFields);
        }

        public function load($data, $formName = null, $safeAttributesOnly = true)
        {
            $scope = $formName === null ? $this->formName() : $formName;
            if ($scope === '' && !empty($data)) {
                $this->setAttributes($data, $safeAttributesOnly);
    
                return true;
            } elseif (isset($data[$scope])) {
                $this->setAttributes($data[$scope], $safeAttributesOnly);
    
                return true;
            }
    
            return false;
        }
    }

?>