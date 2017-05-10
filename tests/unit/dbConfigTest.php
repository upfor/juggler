<?php

class dbConfigTest extends \Codeception\Test\Unit {

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before() {
    }

    protected function _after() {
    }

    public function testDbConfig() {
        $msg = 'dbConfig(): ';
        $this->assertInternalType('array', db()->dbConfig(), $msg . '不传参数');
        $this->assertInternalType('array', db()->dbConfig(''), $msg . '$config="", 不传$value');
        $this->assertInternalType('array', db()->dbConfig('', ''), $msg . '$config="", $value=""');
        $this->assertInternalType('array', db()->dbConfig(null, ''), $msg . '$config=null, $value=""');
    }
}
