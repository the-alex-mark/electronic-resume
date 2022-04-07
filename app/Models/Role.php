<?php

namespace App\Models;

use App\Database\Eloquent\Concerns\HasCustom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ...
 *
 * @property int $id Идентификатор записи
 * @property string $slug Ярлык
 * @property string $title Название
 */
class Role extends Model {

    use HasFactory;
    use HasCustom;

    #region Properties

    /**
     * @inheritDoc
     */
    public $table = 'roles';

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
}
