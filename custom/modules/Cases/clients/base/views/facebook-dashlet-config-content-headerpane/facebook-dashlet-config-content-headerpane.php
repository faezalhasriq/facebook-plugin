<?php

if (!defined('sugarEntry') || !sugarEntry)
{
    die('Not A Valid Entry Point');
}

$viewdefs['Cases']['base']['view']['facebook-dashlet-config-content-headerpane'] = array (
    'template' => 'headerpane',
    'buttons' => array (
        array (
            'name' => 'close',
            'type' => 'button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'events' => array (
                'click' => 'cases:settings:close',
            ),
            'css_class' => 'btn-invisible btn-link',
        ),
        array (
            'name' => 'save_button',
            'type' => 'button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'primary' => true,
            'events' => array (
                'click' => 'cases:settings:save',
            ),
        ),
        array (
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
);
