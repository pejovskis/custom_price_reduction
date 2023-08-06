<?php
namespace OxidEsales\CustomPriceReduction\Model;

class Article extends \OxidEsales\Eshop\Application\Model\Article
{
    public function applyPriceReduction(): void
    {
        // Check if the current article has the specified oxid
        if ($this->getId() === '22e135eb03a3aa69198ae30762ee785c') {
            // Load the product data if not already loaded
            if (!$this->isLoaded()) {
                $this->load('22e135eb03a3aa69198ae30762ee785c');
            }

            // Calculate the reduced price
            $currentPrice = $this->oxarticles__oxprice->value;
            $reductionAmount = $currentPrice * 0.10; // 10% reduction
            $newPrice = $currentPrice - $reductionAmount;

            // Set the new price
            $this->oxarticles__oxprice = new \OxidEsales\Eshop\Core\Field($newPrice);
            $this->save();

            // Log the message using error_log()
            error_log('Price reduction applied for product ID: ' . $this->getId());
        }
    }

    public static function onActivate() : void
    {
        //$log = oxNew('oxLog');
        //$log->write('Custom Price Reduction module activated.');

        // Instantiate the Article model and apply the price reduction
        $article = oxNew(self::class);
        $article->applyPriceReduction();
    }

    public static function onDeactivate() : void
    {
    }

    public static function logSomething() : void
    {
        $log = oxNew('oxLog');
        $log->write('METHOD UNLEASHED BABY');
    }

}
