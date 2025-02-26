<?php


namespace PaylandsSDK\Tests\BTS\GetProducts;

use PaylandsSDK\Requests\GetProductsRequest;
use PaylandsSDK\Responses\GetProductsResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Enums\PaymentTypeCd;
use PaylandsSDK\Types\Product;
use PaylandsSDK\Utils\HttpResponse;

class GetProductsTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getProductsTest_ok()
    {
        $request = new GetProductsRequest(
            "service uuid",
            "EK6"
        );
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "bts/products",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new GetProductsResponse(
            "OK",
            200,
            "2020-02-24T10:25:50+0100",
            [
                new Product(
                    "MTR",
                    "ESP",
                    "EUR",
                    "ARG",
                    "USD",
                    PaymentTypeCd::CSA(),
                    "RDR",
                    "NEF"
                )
            ]
        );
        $actual = $this->paylandsClient->getProducts($request);
        $this->assertEquals($expected, $actual);
    }
}
