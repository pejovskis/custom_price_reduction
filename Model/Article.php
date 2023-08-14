<?php

namespace OxidEsales\CustomPriceReduction\Model;

use \OxidEsales\CustomPriceReduction\Controller\MainController;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;

class Article extends \OxidEsales\Eshop\Application\Model\Article
{

    // Override getPrice() function. Retrieve the Admin-given Article-Number and reduce its price.
    public function getPrice($dAmount = 1)
    {
        // Get the original price
        $originalPrice = parent::getPrice($dAmount);

        // Create mainController instance, retrieve the Article-Number and initialise the final productId
        $mainController = oxNew(MainController::class);
        $artNum = $mainController->retrieveArtikelNum();
        $productId = MainController::getProductIdByArtNum($artNum);

        // If there is a product with ID matching the $productId -> reduce its price by the given percent.
        if ($this->getId() == $productId) {
            // Retrieve the reduction factor from the module settings
            $container = ContainerFactory::getInstance()->getContainer();
            $moduleSettingService = $container->get(ModuleSettingServiceInterface::class);

            // Get the value in the 'reduction-percent' field, convert it to string and parse it to float value.
            // Divide by 100 to get the percent factor.
            $reductionPercent = ((float)$moduleSettingService->
                getString('reduction-percent', 'custom_price_reduction')->toString()) / 100;

            // Apply the reduction factor
            $reductionAmount = $originalPrice->getBruttoPrice() * $reductionPercent;
            $newPrice = $originalPrice->getBruttoPrice() - $reductionAmount;

            // Apply the new price
            $newPriceObject = oxNew(\OxidEsales\Eshop\Core\Price::class);
            $newPriceObject->setPrice($newPrice);

            return $newPriceObject;
        }

        // Return the original price for every oder Article
        return $originalPrice;

    }

    // Activate the module
    public static function onActivate(): void
    {
        $article = new Article();
        $article->getPrice();
    }

    // Deactivate the module
    public static function onDeactivate(): void
    {
    }

}
