<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class WebToPay_UrlBuilderTest extends TestCase
{
    protected WebToPay_UrlBuilder $urlBuilder;

    public function setUp(): void
    {
        $this->urlBuilder = (new WebToPay_Factory())->useSandbox(true)->getUrlBuilder();
    }

    public function testBuildForRequest()
    {
        $request = [
            'projectid' => 1,
            'orderid' => 1,
            'amount' => 1,
            'currency' => 'EUR',
            'country' => 'LT',
            'accepturl' => 'http://example.com/accept',
            'cancelurl' => 'http://example.com/cancel',
            'callbackurl' => 'http://example.com/callback',
            'test' => 1,
        ];

        $url = $this->urlBuilder->buildForRequest($request);

        $this->assertEquals(
            'https://sandbox.paysera.com/pay/?projectid=1&orderid=1&amount=1&currency=EUR&country=LT'
            . '&accepturl=http%3A%2F%2Fexample.com%2Faccept&cancelurl=http%3A%2F%2Fexample.com%2Fcancel'
            . '&callbackurl=http%3A%2F%2Fexample.com%2Fcallback&test=1',
            $url
        );
    }

    public function testBuildForPaymentsMethodList()
    {
        $url = $this->urlBuilder->buildForPaymentsMethodList(1, '1.00', 'EUR');

        $this->assertEquals(
            'https://sandbox.paysera.com/new/api/paymentMethods/1/currency:EUR/amount:1.00',
            $url
        );
    }
}
