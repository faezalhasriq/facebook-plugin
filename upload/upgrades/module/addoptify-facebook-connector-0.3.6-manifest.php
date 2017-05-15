<?php

$manifest = array (
  'readme' => '',
  'key' => 'addoptify-facebook-connector',
  'description' => '',
  'icon' => '',
  'is_uninstallable' => true,
  'name' => 'Add+ Facebook Connector - 0.3.6',
  'published_date' => '2017-01-19 11:14:36',
  'type' => 'module',
  'version' => '0.3.6',
  'remove_tables' => 'prompt',
  0 => 
  array (
    'acceptable_sugar_versions' => 
    array (
      0 => '7.6.x',
      1 => '7.7.x',
      2 => '7.8.x',
    ),
  ),
  1 => 
  array (
    'acceptable_sugar_flavors' => 
    array (
      0 => 'PRO',
      1 => 'CORP',
      2 => 'ENT',
      3 => 'ULT',
    ),
  ),
  'author' => 'Oskar Hellgren',
);

$installdefs = array (
  'id' => 'addoptify-facebook-connector',
  'post_execute' => 
  array (
    0 => '<basepath>/actions/post_install_actions.php',
  ),
  'post_uninstall' => 
  array (
    0 => '<basepath>/actions/post_uninstall_actions.php',
  ),
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/src/custom/clients/base/api/FacebookDashletApi.php',
      'to' => 'custom/clients/base/api/FacebookDashletApi.php',
    ),
    1 => 
    array (
      'from' => '<basepath>/src/custom/clients/base/views/facebook-case-dashlet/dashlet-config.hbs',
      'to' => 'custom/clients/base/views/facebook-case-dashlet/dashlet-config.hbs',
    ),
    2 => 
    array (
      'from' => '<basepath>/src/custom/clients/base/views/facebook-case-dashlet/facebook-case-dashlet.css',
      'to' => 'custom/clients/base/views/facebook-case-dashlet/facebook-case-dashlet.css',
    ),
    3 => 
    array (
      'from' => '<basepath>/src/custom/clients/base/views/facebook-case-dashlet/facebook-case-dashlet.hbs',
      'to' => 'custom/clients/base/views/facebook-case-dashlet/facebook-case-dashlet.hbs',
    ),
    4 => 
    array (
      'from' => '<basepath>/src/custom/clients/base/views/facebook-case-dashlet/facebook-case-dashlet.js',
      'to' => 'custom/clients/base/views/facebook-case-dashlet/facebook-case-dashlet.js',
    ),
    5 => 
    array (
      'from' => '<basepath>/src/custom/clients/base/views/facebook-case-dashlet/facebook-case-dashlet.php',
      'to' => 'custom/clients/base/views/facebook-case-dashlet/facebook-case-dashlet.php',
    ),
    6 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/bg_BG.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/bg_BG.facebook-case-dashlet.php',
    ),
    7 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/de_DE.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/de_DE.facebook-case-dashlet.php',
    ),
    8 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/en_UK.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/en_UK.facebook-case-dashlet.php',
    ),
    9 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/en_us.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/en_us.facebook-case-dashlet.php',
    ),
    10 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/es_ES.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/es_ES.facebook-case-dashlet.php',
    ),
    11 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/fr_FR.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/fr_FR.facebook-case-dashlet.php',
    ),
    12 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/nb_NO.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/nb_NO.facebook-case-dashlet.php',
    ),
    13 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/nl_NL.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/nl_NL.facebook-case-dashlet.php',
    ),
    14 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/pt_PT.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/pt_PT.facebook-case-dashlet.php',
    ),
    15 => 
    array (
      'from' => '<basepath>/src/custom/Extension/application/Ext/Language/sv_SE.facebook-case-dashlet.php',
      'to' => 'custom/Extension/application/Ext/Language/sv_SE.facebook-case-dashlet.php',
    ),
    16 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Administration/facebook_dashlet_config.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Administration/facebook_dashlet_config.php',
    ),
    17 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/bg_BG.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/bg_BG.facebook_dashlet.php',
    ),
    18 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/de_DE.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/de_DE.facebook_dashlet.php',
    ),
    19 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/en_UK.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/en_UK.facebook_dashlet.php',
    ),
    20 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/en_us.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/en_us.facebook_dashlet.php',
    ),
    21 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/es_ES.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/es_ES.facebook_dashlet.php',
    ),
    22 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/fr_FR.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/fr_FR.facebook_dashlet.php',
    ),
    23 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/nb_NO.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/nb_NO.facebook_dashlet.php',
    ),
    24 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/nl_NL.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/nl_NL.facebook_dashlet.php',
    ),
    25 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/pt_PT.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/pt_PT.facebook_dashlet.php',
    ),
    26 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Administration/Ext/Language/sv_SE.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/sv_SE.facebook_dashlet.php',
    ),
    27 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/bg_BG.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/bg_BG.facebook_dashlet.php',
    ),
    28 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/de_DE.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/de_DE.facebook_dashlet.php',
    ),
    29 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/en_UK.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/en_UK.facebook_dashlet.php',
    ),
    30 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/en_us.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/en_us.facebook_dashlet.php',
    ),
    31 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/es_ES.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/es_ES.facebook_dashlet.php',
    ),
    32 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/fr_FR.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/fr_FR.facebook_dashlet.php',
    ),
    33 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/nb_NO.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/nb_NO.facebook_dashlet.php',
    ),
    34 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/nl_NL.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/nl_NL.facebook_dashlet.php',
    ),
    35 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/pt_PT.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/pt_PT.facebook_dashlet.php',
    ),
    36 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Language/sv_SE.facebook_dashlet.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Language/sv_SE.facebook_dashlet.php',
    ),
    37 => 
    array (
      'from' => '<basepath>/src/custom/Extension/modules/Cases/Ext/Vardefs/facebook_post_id.php',
      'to' => 'custom/Extension/modules/Cases/Ext/Vardefs/facebook_post_id.php',
    ),
    38 => 
    array (
      'from' => '<basepath>/src/custom/include/DRI/Exception/InvalidLicenseException.php',
      'to' => 'custom/include/DRI/Exception/InvalidLicenseException.php',
    ),
    39 => 
    array (
      'from' => '<basepath>/src/custom/include/DRI/FacebookConfig.php',
      'to' => 'custom/include/DRI/FacebookConfig.php',
    ),
    40 => 
    array (
      'from' => '<basepath>/src/custom/include/DRI/FacebookLicenseValidator.php',
      'to' => 'custom/include/DRI/FacebookLicenseValidator.php',
    ),
    41 => 
    array (
      'from' => '<basepath>/src/custom/include/DRI/FacebookSugarOutfittersClient.php',
      'to' => 'custom/include/DRI/FacebookSugarOutfittersClient.php',
    ),
    42 => 
    array (
      'from' => '<basepath>/src/custom/modules/Cases/clients/base/api/CustomCasesFacebookApi.php',
      'to' => 'custom/modules/Cases/clients/base/api/CustomCasesFacebookApi.php',
    ),
    43 => 
    array (
      'from' => '<basepath>/src/custom/modules/Cases/clients/base/layouts/facebook-dashlet-config/facebook-dashlet-config.js',
      'to' => 'custom/modules/Cases/clients/base/layouts/facebook-dashlet-config/facebook-dashlet-config.js',
    ),
    44 => 
    array (
      'from' => '<basepath>/src/custom/modules/Cases/clients/base/layouts/facebook-dashlet-config/facebook-dashlet-config.php',
      'to' => 'custom/modules/Cases/clients/base/layouts/facebook-dashlet-config/facebook-dashlet-config.php',
    ),
    45 => 
    array (
      'from' => '<basepath>/src/custom/modules/Cases/clients/base/views/facebook-dashlet-config-content/facebook-dashlet-config-content.hbs',
      'to' => 'custom/modules/Cases/clients/base/views/facebook-dashlet-config-content/facebook-dashlet-config-content.hbs',
    ),
    46 => 
    array (
      'from' => '<basepath>/src/custom/modules/Cases/clients/base/views/facebook-dashlet-config-content/facebook-dashlet-config-content.js',
      'to' => 'custom/modules/Cases/clients/base/views/facebook-dashlet-config-content/facebook-dashlet-config-content.js',
    ),
    47 => 
    array (
      'from' => '<basepath>/src/custom/modules/Cases/clients/base/views/facebook-dashlet-config-content/facebook-dashlet-config-content.php',
      'to' => 'custom/modules/Cases/clients/base/views/facebook-dashlet-config-content/facebook-dashlet-config-content.php',
    ),
    48 => 
    array (
      'from' => '<basepath>/src/custom/modules/Cases/clients/base/views/facebook-dashlet-config-content-headerpane/facebook-dashlet-config-content-headerpane.js',
      'to' => 'custom/modules/Cases/clients/base/views/facebook-dashlet-config-content-headerpane/facebook-dashlet-config-content-headerpane.js',
    ),
    49 => 
    array (
      'from' => '<basepath>/src/custom/modules/Cases/clients/base/views/facebook-dashlet-config-content-headerpane/facebook-dashlet-config-content-headerpane.php',
      'to' => 'custom/modules/Cases/clients/base/views/facebook-dashlet-config-content-headerpane/facebook-dashlet-config-content-headerpane.php',
    ),
  ),
  'beans' => 
  array (
  ),
);
