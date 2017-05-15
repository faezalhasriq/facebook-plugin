<?php

$viewdefs['Cases']['base']['layout']['facebook-plugin-dashlet-config'] = array (
    'components' => array (
        array (
            'layout' => array (
                'components' => array (
                    array (
                        'layout' => array (
                            'components' => array (
                                array (
                                    'view' => 'facebook-plugin-dashlet-config-content-headerpane',
                                ),
                                array (
                                    'view' => 'facebook-plugin-dashlet-config-content',
                                ),
                            ),
                            'type' => 'simple',
                            'name' => 'main-pane',
                            'span' => 8,
                        ),
                    ),
                    array (
                        'layout' => array (
                            'components' => array (),
                            'type' => 'simple',
                            'name' => 'dashboard-pane',
                            'span' => 4,
                        ),
                    ),
                ),
                'type' => 'default',
                'name' => 'sidebar',
                'span' => 12,
            ),
        ),
    ),
    'type' => 'facebook-plugin-dashlet-config',
    'name' => 'facebook-plugin-dashlet-config',
    'span' => 12,
);
