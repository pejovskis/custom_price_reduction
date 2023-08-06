<?php
namespace OxidEsales\CustomPriceReduction\Model;

class Article extends \OxidEsales\Eshop\Application\Model\Article
{
    public function applyPriceReduction(): void
    {
        if ($this->getId() === '9c44c') { // Replace with the actual product ID
            // Load the product data if not already loaded
            if (!$this->isLoaded()) {
                $this->load('9c44c');
            }

            // Calculate the reduced price
            $currentPrice = $this->oxarticles__oxprice->value;
            $reductionAmount = $currentPrice * 0.10; // 10% reduction
            $newPrice = $currentPrice - $reductionAmount;

            // Set the new price
            $this->oxarticles__oxprice = new \OxidEsales\Eshop\Core\Field($newPrice);
            $this->save();
        }
    }

    public static function onActivate() : void
    {
        $log = oxNew('oxLog');
        $log->write('Custom Price Reduction module activated.');

        // Instantiate the Article model and apply the price reduction
        $article = oxNew(self::class);
        $article->applyPriceReduction();
    }

    public static function logSomething() : void
    {
        $log = oxNew('oxLog');
        $log->write('METHOD UNLEASHED BABY');
    }

}
