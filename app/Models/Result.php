<?php

namespace App\Models;

use App\Database\Eloquent\Concerns\HasOverrides;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Представляет результат прохождения теста кандидата.
 *
 * @property int $id Идентификатор записи
 * @property int $summary_id Идентификатор записи должности
 * @property array $questions Вопросы
 * @property array $answers Ответы
 * @property Carbon $checked_at Время проверки результата
 * @property Carbon $created_at Время создания записи
 * @property Carbon $updated_at Время обновления записи
 * @property-read Summary $summary Резюме
 * @property-read int $points Количество баллов
 */
class Result extends Model {

    use HasFactory;
    use HasOverrides;

    #region Properties

    /**
     * @inheritDoc
     */
    public $table = 'summary_results';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'summary_id',
        'questions',
        'answers',
        'checked_at'
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'questions' => 'array',
        'answers' => 'array'
    ];

    /**
     * @inheritDoc
     */
    protected $dates = [
        'checked_at'
    ];

    /**
     * @var bool Определяет, требуется ли форматировать JSON.
     */
    protected $json_pretty_print = true;

    /**
     * @inheritDoc
     */
    public $timestamps = true;

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
     * Определяет, проверен ли тест.
     *
     * @return bool
     */
    public function getIsCheckedAttribute() {
        return !empty($checked_at);
    }

    /**
     * Возвращает суммарное количество баллов.
     *
     * @return int
     */
    public function getPointsAttribute() {
        $points = 0;

        if (empty($this->answers))
            return $points;

        foreach ($this->answers as $answer) {
            foreach ($answer as $value) {
                $count   = intval(data_get($value, 'points', 0));
                $points += $count;
            }
        }

        return $points;
    }

    #endregion
}
