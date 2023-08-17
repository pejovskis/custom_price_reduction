<?php

namespace OxidEsales\CustomPriceReduction\Controller;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;


class MainController
{

    // Retrieve the Artikel Number given in the Admin Configuration Panel | Fieldname: "sCustomPriceReductionModule"
    public function retrieveArtikelNum()
    {
        $moduleSettingService = ContainerFactory::getInstance()
            ->getContainer()
            ->get(ModuleSettingServiceInterface::class);

        $artNum = $moduleSettingService->getString('sCustomPriceReductionModule', 'custom_price_reduction');

        return $artNum;
    }

    // ** UPDATED new method without deprecation ** Retrieve Product ID from the database
    public static function getProductIdByArtNum($artNum): ?string
    {
        $container = ContainerFactory::getInstance()->getContainer();
        $queryBuilderFactory = $container->get(QueryBuilderFactoryInterface::class);
        $queryBuilder = $queryBuilderFactory->create();
        $queryBuilder->select('oxid')
            ->from('oxarticles')
            ->where('oxartnum = :artNum')
            ->setParameter('artNum', $artNum);

        return $queryBuilder->execute()->fetchColumn();
    }

}
