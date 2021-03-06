<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$viewdefs['base']['layout']['history-summary-preview'] = array(
    'components' =>
    array(
        array(
            'view' => 'history-summary-preview-header',
        ),
        array(
            'view' => 'history-summary-preview',
        ),
        array(
            'layout' => 'preview-activitystream',
            'context' =>
            array(
                'module' => 'Activities',
                'forceNew' => true,
            ),
        ),
    ),
    'type' => 'preview',
    'span' => 12,
);
