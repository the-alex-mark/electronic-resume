<?php

namespace App\Models;

use App\Database\Eloquent\Concerns\HasCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Представляет результат прохождения теста кандидата.
 *
 * @property int $id Идентификатор записи
 * @property int $summary_id Идентификатор записи должности
 * @property string $questions Вопросы
 * @property string $answers Ответы
 * @property Carbon $created_at Время создания записи
 * @property Carbon $updated_at Время обновления записи
 * @property-read Summary $summary Резюме
 */
class Result extends Model {

    use HasFactory;
    use HasCustom;

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
        'answers'
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'questions' => 'array',
        'answers' => 'array'
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
}
