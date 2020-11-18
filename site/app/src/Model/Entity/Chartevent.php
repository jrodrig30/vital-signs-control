<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chartevent Entity
 *
 * @property int $row_id
 * @property int $subject_id
 * @property int $hadm_id
 * @property int $icustay_id
 * @property int $itemid
 * @property \Cake\I18n\Time $charttime
 * @property \Cake\I18n\Time $storetime
 * @property int $cgid
 * @property string $value
 * @property float $valuenum
 * @property string $valueuom
 * @property int $warning
 * @property int $error
 * @property string $resultstatus
 * @property string $stopped
 *
 * @property \App\Model\Entity\Row $row
 * @property \App\Model\Entity\Subject $subject
 * @property \App\Model\Entity\Hadm $hadm
 * @property \App\Model\Entity\Icustay $icustay
 */
class Chartevent extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'row_id' => false
    ];

      public function getHistorico(){
        $sql = "SELECT * FROM chartevents LIMIT 100";
        return $this->query($sql);
    }
}
