<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DItemsTable Test Case
 */
class DItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DItemsTable
     */
    public $DItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.d_items',
        'app.rows'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DItems') ? [] : ['className' => 'App\Model\Table\DItemsTable'];
        $this->DItems = TableRegistry::get('DItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DItems);

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
