<?php

namespace App\Models;

use App\Database\Eloquent\Concerns\HasCustom;
use App\Rules\PhoneFormatRule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Представляет резюме.
 *
 * @property int $id Идентификатор записи
 * @property int $user_id Идентификатор записи пользователя
 * @property int $position_id Идентификатор записи должности
 * @property string $last_name Фамилия
 * @property string $first_name Имя
 * @property string $patronymic Отчество
 * @property Carbon $date_of_birth Дата рождения
 * @property string $city Город проживания
 * @property string $floor Пол
 * @property string $phone Мобильный телефон
 * @property string $email Электронная почта
 * @property string $site Сайт
 * @property string $about Биография
 * @property Carbon $created_at Время создания записи
 * @property Carbon $updated_at Время обновления записи
 * @property-read string $initials Краткое ФИО (инициалы)
 * @property-read User $user Пользователь
 * @property-read Position $position Должность
 * @property-read Collection $educations Образование
 * @property-read Collection $experiences Опыт работы
 * @property-read Result $result Результат прохождения теста
 */
class Summary extends Model {

    use HasFactory;
    use HasCustom;

    #region Properties

    /**
     * @inheritDoc
     */
    public $table = 'summaries';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'user_id',
        'position_id',
        'first_name',
        'last_name',
        'patronymic',
        'date_of_birth',
        'city',
        'floor',
        'phone',
        'email',
        'site',
        'about'
    ];

    /**
     * @inheritDoc
     */
    public $timestamps = true;

    #endregion

    #region Relationships

    /**
     * Возвращает пользователя.
     *
     * @return BelongsTo
     */
    public function user() {
        return $this->belongsTo(Position::class, 'user_id');
    }

    /**
     * Возвращает должность.
     *
     * @return BelongsTo
     */
    public function position() {
        return $this->belongsTo(Position::class, 'position_id');
    }

    /**
     * Возвращает список учебных заведений.
     *
     * @return HasMany
     */
    public function educations() {
        return $this->hasMany(Education::class, 'summary_id');
    }

    /**
     * Возвращает список организаций.
     *
     * @return HasMany
     */
    public function experiences() {
        return $this->hasMany(Experience::class, 'summary_id');
    }

    /**
     * Возвращает результат прохождения теста.
     *
     * @return HasOne
     */
    public function result() {
        return $this->hasOne(Result::class, 'summary_id');
    }

    #endregion

    #region Mutators

    /**
     * Возвращает отчество.
     *
     * @param  mixed $value Отчество.
     * @return string
     */
    public function getPatronymicAttribute($value) {
        return (is_null($value)) ? '' : (string)$value;
    }

    /**
     * Возвращает краткое ФИО (инициалы).
     *
     * @return string
     */
    public function getInitialsAttribute() {
        return ucfirst($this->last_name) . mb_strtoupper(' ' . mb_substr($this->first_name, 0, 1) . '. ' . mb_substr($this->patronymic, 0, 1) . '.');
    }

    /**
     * Возвращает дату рождения.
     *
     * @param  mixed $value Дата рождения.
     * @return Carbon
     */
    public function getDateOfBirthAttribute($value) {
        if (is_null($value))
            return null;

        return Carbon::parse($value, 'UTC')->setTimezone(config('app.timezone'));
    }

    /**
     * Возвращает биографию.
     *
     * @param  mixed $value Биография.
     * @return string
     */
    public function getAboutAttribute($value) {
        return (is_null($value)) ? '' : (string)$value;
    }

    #endregion
}
