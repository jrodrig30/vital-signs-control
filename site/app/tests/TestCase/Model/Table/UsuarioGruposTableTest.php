<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsuarioGruposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsuarioGruposTable Test Case
 */
class UsuarioGruposTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'UsuarioGrupos' => 'app.usuario_grupos',
        'Permissoes' => 'app.permissoes',
        'Acos' => 'app.acos',
        'Usuarios' => 'app.usuarios'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsuarioGrupos') ? [] : ['className' => 'App\Model\Table\UsuarioGruposTable'];
        $this->UsuarioGrupos = TableRegistry::get('UsuarioGrupos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsuarioGrupos);

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
}
