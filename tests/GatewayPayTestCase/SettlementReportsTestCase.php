<?php

namespace Tests\GatewayPayTestCase;

use GatewayPay\GatewayPaySDK;
use Tests\TestCase;

class SettlementReportsTestCase extends TestCase
{
    /**
     * Test the get detail Level for a particular aggregation id.
     */
    public function testGetDetailLevelById()
    {
        $GatewayPay =  $this->getGatewayPayConfig();
        $response = $GatewayPay->getDetailLevelById(['id' => '8a82944a4cc25ebf014cc2c782423202', 'sortValue' => 'SettlementTxDate', 'sortOrder' => 'ASC', 'testMode' => GatewayPaySDK::TEST_MODE_INTERNAL]);

        // assert
        $this->assertTrue($response->isSuccessful(), 'The get detail Level by id returned ' . $response->getResultCode());
    }

    /**
     * Test the get summary level information for a certain date and/or settlement currency.
     */
    public function testGetSettlementReportBySummary()
    {
        $GatewayPay =  $this->getGatewayPayConfig();
        $response = $GatewayPay->getSettlementReportBySummary(['dateFrom' => '2015-08-01', 'dateTo' => '2015-08-02', 'currency' => 'EUR', 'testMode' => GatewayPaySDK::TEST_MODE_INTERNAL]);

        // assert
        $this->assertTrue($response->isSuccessful(), 'The get summary level information for a certain date and/or settlement currency' . $response->getResultCode());
    }

    /**
     * Test the get Detail Level with Pagination.
     */
    public function testGetDetailLevelByIdWithPagination()
    {
        $GatewayPay =  $this->getGatewayPayConfig();
        $response = $GatewayPay->getDetailLevelByIdWithPagination(['id' => '8a82944a4cc25ebf014cc2c782423202', 'reconciliationType' => 'SETTLED', 'testMode' => GatewayPaySDK::TEST_MODE_INTERNAL, "pageNo" => 2]);

        // assert
        $this->assertTrue($response->isSuccessful(), 'The get detail level pagination returned ' . $response->getResultCode());
    }
}
