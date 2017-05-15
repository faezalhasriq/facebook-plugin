<?php

$viewdefs['Cases']['base']['layout']['facebook-dashlet-config'] = array (
    'components' => array (
        array (
            'layout' => array (
                'components' => array (
                    array (
                        'layout' => array (
                            'components' => array (
                                array (
                                    'view' => 'facebook-dashlet-config-content-headerpane',
                                ),
                                array (
                                    'view' => 'facebook-dashlet-config-content',
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
    'type' => 'facebook-dashlet-config',
    'name' => 'facebook-dashlet-config',
    'span' => 12,
);
