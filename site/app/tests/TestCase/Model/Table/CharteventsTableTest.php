<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharteventsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharteventsTable Test Case
 */
class CharteventsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CharteventsTable
     */
    public $Chartevents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.chartevents',
        'app.rows',
        'app.subjects',
        'app.hadms',
        'app.icustays'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Chartevents') ? [] : ['className' => 'App\Model\Table\CharteventsTable'];
        $this->Chartevents = TableRegistry::get('Chartevents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Chartevents);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
