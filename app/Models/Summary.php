<?php

namespace App\Models;

use App\Database\Eloquent\Concerns\HasOverrides;
use App\Database\Eloquent\Concerns\HasValidation;
use App\Rules\PhoneFormatRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Представляет анкету.
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
 * @property string $phone Номер мобильного телефона
 * @property string $email Адрес электронной почты
 * @property string $site Сайт
 * @property string $about Биография
 * @property Carbon $created_at Время создания записи
 * @property Carbon $updated_at Время обновления записи
 * @property-read string $full_name Полное Ф.И.О.
 * @property-read string $initials Краткое Ф.И.О. (инициалы)
 * @property-read User $user Пользователь
 * @property-read Position $position Должность
 * @property-read string $phone_masked Маскированный номер мобильного телефона
 * @property-read string $email_masked Маскированный адрес электронной почты
 * @property-read Collection $educations Образование
 * @property-read Collection $experiences Опыт работы
 * @property-read Result $result Результат прохождения теста
 *
 * @method static Builder ofPosition($slug) Возвращает список анкет по указанной должности.
 */
class Summary extends Model {

    use HasFactory;
    use HasOverrides;
    use HasValidation;

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
        return $this->belongsTo(User::class);
    }

    /**
     * Возвращает должность.
     *
     * @return BelongsTo
     */
    public function position() {
        return $this->belongsTo(Position::class);
    }

    /**
     * Возвращает список учебных заведений.
     *
     * @return HasMany
     */
    public function educations() {
        return $this->hasMany(Education::class);
    }

    /**
     * Возвращает список организаций.
     *
     * @return HasMany
     */
    public function experiences() {
        return $this->hasMany(Experience::class);
    }

    /**
     * Возвращает результат прохождения теста.
     *
     * @return HasOne
     */
    public function result() {
        return $this->hasOne(Result::class);
    }

    #endregion

    #region Scopes

    /**
     * Возвращает список анкет по указанной должности.
     *
     * @param  Builder $query Запрос.
     * @param  string  $slug  Ярлык должности.
     * @return Builder
     */
    public function scopeOfPosition(Builder $query, $slug) {
        return $query
            ->join('positions', 'positions.id', '=', 'position_id', null)
            ->where('positions.slug', $slug);
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
     * Возвращает полное ФИО.
     *
     * @return string
     */
    public function getFullNameAttribute() {
        $name = ucfirst($this->last_name) . ' ' . ucfirst($this->first_name);

        if (!empty($this->patronymic))
            $name .= ' ' . ucfirst($this->patronymic);

        return $name;
    }

    /**
     * Возвращает краткое ФИО (инициалы).
     *
     * @return string
     */
    public function getInitialsAttribute() {
        $name = ucfirst($this->last_name) . mb_strtoupper(' ' . mb_substr($this->first_name, 0, 1) . '.');

        if (!empty($this->patronymic))
            $name .= ' ' . mb_strtoupper(mb_substr($this->patronymic, 0, 1) . '.');

        return $name;
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
     * Задаёт номер мобильного телефона.
     *
     * @param  mixed $value Номер мобильного телефона.
     * @return void
     */
    public function setPhoneAttribute($value) {
        $this->attributes['phone'] = '8' . phone_cleared($value);
    }

    /**
     * Возвращает номер мобильного телефона.
     *
     * @param  mixed $value Номер мобильного телефона.
     * @return string
     */
    public function getPhoneAttribute($value) {
        return phone_formatted($value);
    }

    /**
     * Возвращает маскированный номер мобильного телефона.
     *
     * @return string
     */
    public function getPhoneMaskedAttribute() {
        return phone_masked($this->phone);
    }

    /**
     * Возвращает маскированный адрес электронной почты.
     *
     * @return string
     */
    public function getEmailMaskedAttribute() {
        return email_masked($this->email);
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

    #region Validation

    /**
     * @inheritDoc
     */
    protected static function validatorRules() {
        return [
            'position_id' => [ 'bail', 'required', 'integer', 'min:0', 'exists:positions,id' ],
            'first_name' => [ 'bail', 'required', 'string' ],
            'last_name' => [ 'bail', 'required', 'string' ],
            'patronymic' => [ 'bail', 'nullable', 'string' ],
            'date_of_birth' => [ 'bail', 'required', 'date' ],
            'city' => [ 'bail', 'required', 'string' ],
            'floor' => [ 'bail', 'required', 'string', 'in:male,women' ],
            'phone' => [ 'bail', 'required', 'string', new PhoneFormatRule() ],
            'email' => [ 'bail', 'nullable', 'email:rfc,dns' ],
            'site' => [ 'bail', 'nullable', 'url' ],
            'about' => [ 'bail', 'nullable', 'string' ],
            'educations' => [ 'bail', 'required', 'array', 'min:0' ],
            'experiences' => [ 'bail', 'nullable', 'array' ]
        ];
    }

    /**
     * @inheritDoc
     */
    protected static function validatorAttributes() {
        return [
            'position_id' => 'должность',
            'first_name' => 'имя',
            'last_name' => 'фамилия',
            'patronymic' => 'отчество',
            'city' => 'город',
            'floor' => 'пол',
            'phone' => 'мобильный телефон',
            'email' => 'электронная почта',
            'site' => 'личный сайт',
            'about' => 'о себе',
            'educations' => 'образование',
            'experiences' => 'опыт работы'
        ];
    }

    #endregion
}
