<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PermissoesFixture
 *
 */
class PermissoesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'usuario_grupo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'aco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_ow_permissoes_ow_grupos1_idx' => ['type' => 'index', 'columns' => ['usuario_grupo_id'], 'length' => []],
            'fk_ow_permissoes_ow_acos1_idx' => ['type' => 'index', 'columns' => ['aco_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_ow_permissoes_ow_acos1' => ['type' => 'foreign', 'columns' => ['aco_id'], 'references' => ['acos', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_ow_permissoes_ow_grupos1' => ['type' => 'foreign', 'columns' => ['usuario_grupo_id'], 'references' => ['usuario_grupos', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'usuario_grupo_id' => 1,
            'aco_id' => 1
        ],
    ];
}
