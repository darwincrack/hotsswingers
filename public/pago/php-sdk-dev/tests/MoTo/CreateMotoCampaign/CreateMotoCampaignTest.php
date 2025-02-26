<?php

namespace PaylandsSDK\Tests\MoTo\CreateMotoCampaign;

use PaylandsSDK\Requests\CreateMotoCampaignRequest;
use PaylandsSDK\Responses\CreateMotoCampaignResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\CampaignDetail;
use PaylandsSDK\Types\Enums\EntryType;
use PaylandsSDK\Types\Enums\MoToCampaignStatus;
use PaylandsSDK\Types\Enums\MoToCampaignType;
use PaylandsSDK\Types\Enums\Operative;
use PaylandsSDK\Types\MotoCampaignPayment;
use PaylandsSDK\Utils\HttpResponse;

class CreateMotoCampaignTest extends TestBase
{
    /**
 * @return void
 */
    public function test_createMotoCampaign_ok()
    {
        $request = new CreateMotoCampaignRequest(
            "Navidad 2019",
            "Campaña de Navidad 2019",
            "some uuid",
            MoToCampaignType::PHONE(),
            "2017-11-11",
            "data:text/csv;base64,QU1PVU5ULE9QRVJBVElWRSxERVNUSU5BVElPTixDVVNUT01FUl9FWFRfSUQsQURESVRJT05BTCxTRUNVUkUsVVJMX1BPU1QsVVJMX09LLFVSTF9LTyxDQVJEX1RFTVBMQVRFLE1PVE9fVEVNUExBVEUsRENDX1RFTVBMQVRFCjEsREVGRVJSRUQsc3VjY2Vzc0BzaW11bGF0b3IuYW1hem9uc2VzLmNvbSxleHRlcm5hbElELGFkZGl0aW9uYWwsRkFMU0UsaHR0cDovL3VybC5wb3N0LGh0dHA6Ly91cmwub2ssaHR0cDovL3VybC5rbyxDRDVGMzU0MC1CMkNCLTRDNjctQUU2Qi1GNzZFRDkzREU2QzEsRUVCRjEwMjItNkRCMi00NURCLTgxN0QtQTg3QjA5QUU4NDFCLDQwMTExRkU4LTlCMzItNDNFMy1BNEFFLTk3QzdCRTZEMTlDNQ==",
            "test.csv"
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'payment/moto/csv',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new CreateMotoCampaignResponse(
            "OK",
            200,
            "2019-05-30T12:52:54+0200",
            new CampaignDetail(
                "CFD6A322-47F4-4AA8-8208-B8AAE02D6C87",
                "some description",
                "60A1F4C0-CC58-47A9-A0B9-868F9EF29045",
                "1",
                "B8A48789-8AF0-47D1-9116-35AB0A941121",
                MoToCampaignType::MAIL(),
                EntryType::WEBSERVICE(),
                "2019-04-01 00:00:00",
                "te223st",
                "filename.csv",
                21,
                MoToCampaignStatus::PENDING(),
                "2019-05-30 12:52:54"
            ),
            [
                new MotoCampaignPayment(
                    774,
                    "0297A7B1-5506-49EF-836B-1E2F04C6D179",
                    774,
                    2,
                    MoToCampaignStatus::PENDING(),
                    47,
                    Operative::AUTHORIZATION(),
                    false,
                    "lchessell0@fastcompany.com",
                    "2019-05-30 12:52:54",
                    "http://wikimedia.org",
                    "https://imgur.com/lobortis.aspx",
                    "https://walmart.com/varius.png",
                    null,
                    null,
                    "3FA633A9-0F04-4EDD-B32E-4D56E1B0761D",
                    null,
                    null
                ),
                new MotoCampaignPayment(
                    775,
                    "69D9D760-0F03-4083-9B5D-67C6475695B2",
                    775,
                    3,
                    MoToCampaignStatus::PENDING(),
                    5,
                    Operative::DEFERRED(),
                    false,
                    "jmedeway1@angelfire.com",
                    "2019-05-30 12:52:54",
                    "https://weebly.com",
                    "http://hud.gov/consequat.xml",
                    "https://1688.com/quisque/erat/eros/viverra.jsp"
                )
            ]
        );

        $actual = $this->paylandsClient->createMotoCampaign($request);

        $this->assertEquals($expected, $actual);
    }
}
