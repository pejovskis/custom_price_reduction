<?php

namespace OxidEsales\CustomPriceReduction\Controller;

use \Symfony\Component\Yaml\Yaml;

class MainController
{
    // Obtain the Artnum Value from the .yaml file || From the Configuration panel's Module
    public function getYamlArtnumValue() : string
    {
        // .yaml file location
        $yamlFilePath = '/var/www/html/oxid/var/configuration/shops/1/modules/custom_price_reduction.yaml';

        // Get content from the .yaml
        $yamlContent = file_get_contents($yamlFilePath);

        // Parse the yaml content
        $moduleSettings = Yaml::parse($yamlContent);

        // Check if the setting exists and retrieve the value
        $sReducedProductArtNum = $moduleSettings['moduleSettings']['sReducedProductArtNum']['value'] ?? '';

        return $sReducedProductArtNum;
    }

    // Reduce the product's price
    public function applyPriceReduction($product): void
    {
        // Get original price && set new 10% reduced price
        $currentPrice = $product->getPrice()->getBruttoPrice(); // Call methods on the product object
        $reductionAmount = $currentPrice * 0.10; // 10% reduction
        $newPrice = $currentPrice - $reductionAmount;

        // Update the price with discount
        $product->oxarticles__oxprice = new \OxidEsales\Eshop\Core\Field($newPrice);

        // Save the product
        $product->save();

    }

    // Set back the original price
    public function retrievePriceReduction($product) : void
    {
        // Get original price && set new 10% reduced price
        $currentPrice = $product->getPrice()->getBruttoPrice();
        $originalPrice = $currentPrice / (0.90);

        // Update the price to the original one
        $product->oxarticles__oxprice = new \OxidEsales\Eshop\Core\Field ( $originalPrice );

        //Save the product
        $product->save();
    }

    // This one is from 6.0 ! -> Should be used the Factory Container -> Look it up in the 7.0 Version Docu, by searching Database
    // Get the Artnum from the DB
    public static function getProductIdByArtNum($artNum) : ?string {
        $database = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
        $query = "SELECT oxid FROM oxarticles WHERE oxartnum = ?";
        return $database->getOne($query, [$artNum]);
    }

}
