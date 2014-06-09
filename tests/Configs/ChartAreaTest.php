<?php namespace Khill\Lavacharts\Tests\Configs;

use Khill\Lavacharts\Lavacharts;
use Khill\Lavacharts\Tests\TestCase;
use Khill\Lavacharts\Configs\chartArea;

class ChartAreaTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->ca = new chartArea();
    }

    public function testIfInstanceOfchartArea()
    {
        $this->assertInstanceOf('Khill\Lavacharts\Configs\chartArea', $this->ca);
    }

    public function testConstructorDefaults()
    {
        $this->assertEquals(null, $this->ca->left);
        $this->assertEquals(null, $this->ca->top);
        $this->assertEquals(null, $this->ca->width);
        $this->assertEquals(null, $this->ca->height);
    }

    public function testConstructorWithIntsValuesAssignment()
    {
        $chartArea = new chartArea(array(
            'left'   => 25,
            'top'    => 10,
            'width'  => 900,
            'height' => 300
        ));

        $this->assertEquals(25,  $chartArea->left);
        $this->assertEquals(10,  $chartArea->top);
        $this->assertEquals(900, $chartArea->width);
        $this->assertEquals(300, $chartArea->height);
    }

    public function testConstructorWithPercentsValuesAssignment()
    {
        $chartArea = new chartArea(array(
            'left'   => '5%',
            'top'    => '10%',
            'width'  => '90%',
            'height' => '40%'
        ));

        $this->assertEquals('5%',  $chartArea->left);
        $this->assertEquals('10%', $chartArea->top);
        $this->assertEquals('90%', $chartArea->width);
        $this->assertEquals('40%', $chartArea->height);
    }

    public function testConstructorWithInvalidPropertiesKey()
    {
        $chartArea = new chartArea(array('Pizza' => 'sandwich'));

        $this->assertTrue(Lavacharts::hasErrors());
    }

    /**
     * @dataProvider badParamsProvider
     */
    public function testLeftWithBadParams($badVals)
    {
        $this->ca->left($badVals);

        $this->assertTrue(Lavacharts::hasErrors());
    }

    /**
     * @dataProvider badParamsProvider
     */
    public function testTopWithBadParams($badVals)
    {
        $this->ca->top($badVals);

        $this->assertTrue(Lavacharts::hasErrors());
    }

    /**
     * @dataProvider badParamsProvider
     */
    public function testWidthWithBadParams($badVals)
    {
        $this->ca->width($badVals);

        $this->assertTrue(Lavacharts::hasErrors());
    }

    /**
     * @dataProvider badParamsProvider
     */
    public function testHeightWithBadParams($badVals)
    {
        $this->ca->height($badVals);

        $this->assertTrue(Lavacharts::hasErrors());
    }

    public function badParamsProvider()
    {
        return array(
            array('zooAnimals'),
            array(123.456),
            array(array()),
            array(new \stdClass()),
            array(true),
            array(null)
        );
    }

}
