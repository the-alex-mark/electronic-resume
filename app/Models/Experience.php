<?php

namespace App\Models;

use App\Database\Eloquent\Concerns\HasCustom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

/**
 * Представляет опыт работы кандидата.
 *
 * @property int $id Идентификатор записи
 * @property int $summary_id Идентификатор записи должности
 * @property string $organization Организация
 * @property Carbon $start Начало работы
 * @property Carbon $end Окончание работы
 * @property string $position Должность
 * @property string $description Обязанности на рабочем месте
 * @property string $site Адрес сайта
 * @property-read Summary $summary Резюме
 */
class Experience extends Model {

    use HasFactory;
    use HasCustom;

    #region Properties

    /**
     * @inheritDoc
     */
    public $table = 'summary_experiences';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'summary_id',
        'organization',
        'start',
        'end',
        'position',
        'description',
        'site'
    ];

    /**
     * @inheritDoc
     */
    protected $dates = [
        'start',
        'end'
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
     * Возвращает дату начала работы.
     *
     * @param  mixed $value Дата начала работы.
     * @return Carbon
     */
    public function getStartAttribute($value) {
        if (is_null($value))
            return null;

        return Carbon::parse($value, 'UTC')->setTimezone(config('app.timezone'));
    }

    /**
     * Возвращает дату окончания работы.
     *
     * @param  mixed $value Дата окончания работы.
     * @return Carbon
     */
    public function getEndAttribute($value) {
        if (is_null($value))
            return null;

        return Carbon::parse($value, 'UTC')->setTimezone(config('app.timezone'));
    }

    /**
     * Задаёт адрес сайта.
     *
     * @param  string $value Адрес сайта.
     * @return void
     * @throws UrlGenerationException
     */
    public function setUrlAttribute($value) {
        if (!URL::isValidUrl($value))
            throw new UrlGenerationException('Адрес URL сайта имеет неверный формат.');

        $this->attributes['site'] = $value;
    }

    /**
     * Возвращает адрес сайта.
     *
     * @param  mixed $value Адрес сайта.
     * @return string
     */
    public function getSiteAttribute($value) {
        return (is_null($value)) ? '' : (string)$value;
    }

    #endregion
}
