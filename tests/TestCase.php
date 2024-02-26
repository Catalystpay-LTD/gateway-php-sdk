<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use GatewayPay\GatewayPaySDK;

abstract class TestCase extends BaseTestCase
{
	public function getGatewayPayConfig()
	{

		$GatewayPayConfig = new GatewayPaySDK(
			getenv('GATEWAY_PAY_TOKEN'),
			getenv('GATEWAY_PAY_ENTITY_ID'),
			(bool) getenv('GATEWAY_PAY_IS_PRODUCTION')

		);
		return $GatewayPayConfig;
	}
}
