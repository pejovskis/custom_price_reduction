<?php
$sMetadataVersion = '2.0';
$aModule = array(
    'id'           => 'custom_price_reduction',
    'title'        => 'Custom Price Reduction Plugin',
    'description'  => 'Applies a 10% price reduction to a specific product.',
    'version'      => '1.0',
    'author'       => 'Sashko Pejovski',
    'extend'       => array(
        \OxidEsales\Eshop\Application\Model\Article::class => 'custom_price_reduction/models/Article',
    ),
    'events'       => array(
        'onActivate' => '\CustomPriceReduction\Models\Article::onActivate'
    ),
);