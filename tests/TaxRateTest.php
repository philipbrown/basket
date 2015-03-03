<?php namespace PhilipBrown\Basket\Tests;

use PhilipBrown\Basket\TaxRate;

class TaxRateTest extends \PHPUnit_Framework_TestCase
{
	/** @var TaxRate */
	private $tax;

	/** @return void */
	public function setUp()
	{
		$this->tax = new TaxRate(0.20);
	}

    /** @test */
    public function should_return_rate_as_float()
    {
        $this->assertEquals(0.20, $this->tax->float());
    }

    /** @test */
    public function should_return_rate_as_percentage()
    {
        $this->assertEquals(20, $this->tax->percentage());
    }
}
