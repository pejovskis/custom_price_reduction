<?php
$sMetadataVersion = '2.0';
$aModule = array(
    'id'           => 'custom_price_reduction',
    'title'        => 'Custom Price Reduction Plugin',
    'description'  => 'Applies a 10% price reduction to a specific product.',
    'version'      => '2.0.0',
    'author'       => 'Sashko Pejovski',
    'extend' => array(
        \OxidEsales\Eshop\Application\Model\Article::class => \OxidEsales\LoggerDemo\Model\Article::class
    ),
        'events'     => array(
            'onActivate' => '\OxidEsales\CustomPriceReduction\Model\Article::onActivate'
    ),
);
