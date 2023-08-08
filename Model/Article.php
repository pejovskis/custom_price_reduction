<?php

namespace OxidEsales\CustomPriceReduction\Model;
// Main Controller
use \OxidEsales\CustomPriceReduction\Controller\MainController;

class Article extends \OxidEsales\Eshop\Application\Model\Article
{

    // Activate the module to reduce the price of the from-yaml-parsed ArtNum
    public static function onActivate() : void
    {
        // Initialize the main Controller
        $mainController = new MainController();

        // Retrieve the ArtNum from the yaml Array
        $sReducedProductArtNum = $mainController->getYamlArtnumValue();

        // Initialize the product object
        $product = oxNew(self::class);

        // Get the product id using its ArtNum
        $productId = $mainController->getProductIdByArtNum($sReducedProductArtNum);

        // Load & Apply the price reduction
        $product->load($productId);
        $mainController->applyPriceReduction($product);
    }

    // Deactivate the module, resetting the original price to the same product
    public static function onDeactivate() : void
    {
        // Initialize the main Controller
        $mainController = new MainController();

        // Get the Artnum from the .yaml File
        $sReducedProductArtNum = $mainController->getYamlArtnumValue();

        // Initialize the product
        $product = oxNew(self::class);
        // Get Product's ID
        $productId = $mainController->getProductIdByArtNum($sReducedProductArtNum);
        // Load and reset the Product's price
        $product->load($productId);
        $mainController->retrievePriceReduction($product);
    }

}
