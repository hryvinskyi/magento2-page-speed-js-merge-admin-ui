<?php
/**
 * Copyright (c) 2022. All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedJsMergeAdminUi\Observer;

use Hryvinskyi\PageSpeedApi\Model\CacheInterface;
use Hryvinskyi\PageSpeedJsMerge\Model\Cache\JsList;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CleanListJsCache implements ObserverInterface
{
    private JsList $jsList;

    /**
     * @param JsList $jsList
     */
    public function __construct(JsList $jsList)
    {
        $this->jsList = $jsList;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws \Zend_Cache_Exception
     */
    public function execute(Observer $observer): void
    {
        $this->jsList->getCache()->clean('all', [CacheInterface::CACHE_TAG]);
    }
}
