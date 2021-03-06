<?php

namespace App\Models;

use App\Database\Eloquent\Concerns\HasOverrides;
use App\Database\Eloquent\Concerns\HasValidation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Представляет образование кандидата.
 *
 * @property int $id Идентификатор записи
 * @property int $summary_id Идентификатор записи должности
 * @property string $institution Учебное заведение
 * @property string $faculty Факультет
 * @property string $specialization Специализация
 * @property string $year Год окончания
 * @property-read Summary $summary Резюме
 */
class Education extends Model {

    use HasFactory;
    use HasOverrides;
    use HasValidation;

    #region Properties

    /**
     * @inheritDoc
     */
    public $table = 'summary_educations';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'summary_id',
        'institution',
        'faculty',
        'specialization',
        'year'
    ];

    /**
     * @inheritDoc
     */
    public $timestamps = false;

    #endregion

    #region Relationships

    /**
     * Возвращает резюме.
     *
     * @return BelongsTo
     */
    public function summary() {
        return $this->belongsTo(Summary::class, 'summary_id');
    }

    #endregion

    #region Mutators

    /**
     * Возвращает факультет.
     *
     * @param  mixed $value Факультет.
     * @return string
     */
    public function getFacultyAttribute($value) {
        return (is_null($value)) ? '' : (string)$value;
    }

    /**
     * Возвращает специализация.
     *
     * @param  mixed $value Специализация.
     * @return string
     */
    public function getSpecializationAttribute($value) {
        return (is_null($value)) ? '' : (string)$value;
    }

    #endregion

    #region Validation

    /**
     * @inheritDoc
     */
    protected static function validatorRules() {
        return [
            'institution'    => [ 'bail', 'required', 'string' ],
            'faculty'        => [ 'bail', 'nullable', 'string' ],
            'specialization' => [ 'bail', 'nullable', 'string' ],
            'year'           => [ 'bail', 'required', 'string' ]
        ];
    }

    /**
     * @inheritDoc
     */
    protected static function validatorAttributes() {
        return [
            'institution'    => '',
            'faculty'        => '',
            'specialization' => '',
            'year'           => '',
        ];
    }

    #endregion
}
