<?php

namespace App\Models;

use App\Database\Eloquent\Concerns\HasCustom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Представляет тест.
 *
 * @property int $id Идентификатор записи
 * @property int $position_id Идентификатор записи должности
 * @property string $title Название
 * @property string $data Параметры теста
 * @property Carbon $created_at Время создания записи
 * @property Carbon $updated_at Время обновления записи
 * @property-read Position $position Должность
 */
class Test extends Model {

    use HasFactory;
    use HasCustom;

    #region Properties

    /**
     * @inheritDoc
     */
    public $table = 'tests';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'position_id',
        'title',
        'data'
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'data' => 'array'
    ];

    /**
     * @var bool Определяет, требуется ли форматировать JSON.
     */
    protected $json_pretty_print = true;

    /**
     * @inheritDoc
     */
    public $timestamps = false;

    #endregion

    #region Relationships

    /**
     * Возвращает должность.
     *
     * @return BelongsTo
     */
    public function position() {
        return $this->belongsTo(Position::class, 'position_id');
    }

    #endregion
}
