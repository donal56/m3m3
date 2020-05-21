<?php
    namespace app\components;
    
    use webvimark\modules\UserManagement\models\User;
    use webvimark\modules\UserManagement\UserManagementModule;
    
    class SemanticGhostDropdown extends SemantictDropDown
    {
        public function init()
        {
            parent::init();
    
            $this->ensureVisibility($this->items);
        }
    
        /**
         * @param array $items
         *
         * @return bool
         */
        protected function ensureVisibility(&$items)
        {
            $allVisible = false;
    
            foreach ($items as &$item)
            {
                if ( isset( $item['url'] ) AND !isset( $item['visible'] ) AND !in_array($item['url'], ['', '#']))
                {
                    $item['visible'] = User::canRoute($item['url']);
                }
    
                if ( isset( $item['items'] ) )
                {
                    // If not children are visible - make invisible this node
                    if ( !$this->ensureVisibility($item['items']) AND !isset( $item['visible'] ) )
                    {
                        $item['visible'] = false;
                    }
                }
    
                if ( isset( $item['label'] ) AND ( !isset( $item['visible'] ) OR $item['visible'] === true ) )
                {
                    $allVisible = true;
                }
            }
    
            return $allVisible;
        }

        public static function authMenuItems() 
        {
            return [
                [   
                    'icon' => 'users',
                    'label' => UserManagementModule::t('back', 'Users'), 
                    'url' => ['/user-management/user/index'],
                ],
                [   
                    'icon' => 'shield alternate',
                    'label' => UserManagementModule::t('back', 'Roles'), 
                    'url' => ['/user-management/role/index'],
                ],
                [   
                    'icon' => 'check',
                    'label' => UserManagementModule::t('back', 'Permissions'), 
                    'url' => ['/user-management/permission/index'],
                ],
                [
                    'icon' => 'check circle',
                    'label' => UserManagementModule::t('back', 'Permission groups'), 
                    'url' => ['/user-management/auth-item-group/index'],
                ],
                [
                    'icon' => 'clipboard list',
                    'label' => UserManagementModule::t('back', 'Visit log'), 
                    'url' => ['/user-management/user-visit-log/index'],
                ]
            ];
        }
    } 
    
?>