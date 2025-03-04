<?php
/**
 * Copyright 2020 Vipps
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */
namespace Vipps\Payment\Model;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteRepository;
use Vipps\Checkout\Api\QuoteRepositoryInterface as VippsQuoteRepositoryInterface;

/**
 * Class QuoteLocator
 * @package Vipps\Payment\Model
 */
class QuoteLocator
{
    /**
     * @var QuoteRepository
     */
    private $quoteRepository;
    /**
     * @var VippsQuoteRepositoryInterface
     */
    private VippsQuoteRepositoryInterface $vippsQuoteRepository;

    /**
     * QuoteLocator constructor.
     *
     * @param QuoteRepository $quoteRepository
     * @param VippsQuoteRepositoryInterface $vippsQuoteRepository
     */
    public function __construct(
        QuoteRepository $quoteRepository,
        VippsQuoteRepositoryInterface $vippsQuoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->vippsQuoteRepository = $vippsQuoteRepository;
    }

    /**
     * Retrieve a quote by increment id
     *
     * @param string $incrementId
     *
     * @return CartInterface|Quote
     */
    public function get($incrementId): ?CartInterface
    {
        try {
            $vippsQuote = $this->vippsQuoteRepository->loadByOrderId($incrementId);
            $quote = $this->quoteRepository->get($vippsQuote->getQuoteId());
        } catch (\Exception $e) {
            $quote = null;
        }

        return $quote ?: null;
    }
}
