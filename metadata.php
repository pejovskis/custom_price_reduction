<?php
$sMetadataVersion = '2.0';
$aModule = array(
    'id'           => 'custom_price_reduction',
    'title'        => 'Custom Price Reduction Plugin',
    'description'  => 'Applies a X price reduction to a specific product, every day from 10am to 12am.',
    'version'      => '2.0.0',
    'author'       => 'Sashko Pejovski',
    'extend' => array(
        \OxidEsales\Eshop\Application\Model\Article::class => \OxidEsales\CustomPriceReduction\Model\Article::class,
        \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController::class => \OxidEsales\CustomPriceReduction\Controller\MainController::class,
    ),
        'events'     => array(
            'onActivate' => '\OxidEsales\CustomPriceReduction\Model\Article::onActivate',
            'onDeactivate' => '\OxidEsales\CustomPriceReduction\Model\Article::onDeactivate'
    ),
    'settings' => array(
        array(
            'group' => 'custom_reduction_price_settings',
            'name'  => 'sCustomPriceReductionModule',
            'type'  => 'str',
            'value' => 'Artikel Nummer',
            'position' => 0,
        ),
        array(
            'group' => 'custom_reduction_price_settings',
            'name'  => 'reduction-percent',
            'type'  => 'str',
            'value' => '%',
            'position' => 1,
        )
    ),
    'controllers' => array(
        'CustomPriceReductionSettingsController' => OxidEsales\CustomPriceReduction\Controller\MainController::class,
    )
);
