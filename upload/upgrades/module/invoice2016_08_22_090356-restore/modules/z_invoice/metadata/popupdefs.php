<?php
$popupMeta = array (
    'moduleMain' => 'z_invoice',
    'varName' => 'z_invoice',
    'orderBy' => 'z_invoice.name',
    'whereClauses' => array (
  'name' => 'z_invoice.name',
  'date_entered' => 'z_invoice.date_entered',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'date_entered',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'name' => 'date_entered',
  ),
),
);
