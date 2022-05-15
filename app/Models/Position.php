<?php

namespace App\Models;

use App\Database\Eloquent\Concerns\HasOverrides;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Представляет должность.
 *
 * @property int $id Идентификатор записи
 * @property string $slug Ярлык
 * @property string $title Название
 * @property-read Collection|Summary[] $summaries Список анкет
 */
class Position extends Model {

    use HasFactory;
    use HasOverrides;

    #region Properties

    /**
     * @inheritDoc
     */
    public $table = 'positions';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'slug',
        'title'
    ];

    /**
     * @inheritDoc
     */
    public $timestamps = false;

    #endregion

    #region Relationships

    /**
     * Возвращает список анкет.
     *
     * @return HasMany
     */
    public function summaries() {
        return $this->hasMany(Summary::class);
    }

    #endregion
}
