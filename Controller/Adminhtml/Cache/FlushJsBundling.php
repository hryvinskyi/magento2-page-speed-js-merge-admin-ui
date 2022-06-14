<?php
/**
 * Copyright (c) 2020-2022. All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\PageSpeedJsMergeAdminUi\Controller\Adminhtml\Cache;

use Exception;
use Hryvinskyi\PageSpeedAdminUi\Controller\Adminhtml\Cache;
use Hryvinskyi\PageSpeedApi\Model\CacheInterface;
use Hryvinskyi\PageSpeedJsMerge\Model\Cache\JsList as JsListCache;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Filesystem\Io\File;

/**
 * Class FlushJsBundling
 */
class FlushJsBundling extends Cache
{
    private \Zend_Cache_Core $jsListCache;
    private TypeListInterface $cacheTypeList;
    private File $file;
    private CacheInterface $cache;

    /**
     * @param Context $context
     * @param JsListCache $jsListCache
     * @param TypeListInterface $cacheTypeList
     * @param File $file
     * @throws \Zend_Cache_Exception
     */
    public function __construct(
        Context $context,
        JsListCache $jsListCache,
        TypeListInterface $cacheTypeList,
        File $file,
        CacheInterface $cache
    ) {
        parent::__construct($context);
        $this->jsListCache = $jsListCache->getCache();
        $this->cacheTypeList = $cacheTypeList;
        $this->file = $file;
        $this->cache = $cache;
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        try {
            $this->cacheTypeList->cleanType('full_page');
            $this->jsListCache->clean('all', [CacheInterface::CACHE_TAG]);
            $this->file->rmdir($this->cache->getRootCachePath(), true);
            $this->messageManager->addSuccessMessage(__('Cache has been successfully cleaned'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong'));
        }

        return $this->resultRedirectFactory->create()->setRefererUrl();
    }
}
