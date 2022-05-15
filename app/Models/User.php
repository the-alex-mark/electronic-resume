<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Представляет пользователя.
 *
 * @property int $id Идентификатор записи
 * @property int $role_id Идентификатор записи роли
 * @property string $name Имя
 * @property string $email Адрес электронной почты
 * @property-read Role $role Роль
 * @property-read Collection $summaries Анкеты
 *
 * @method static Builder ofRole($slug) Возвращает список пользователей по указанной роли.
 */
class User extends Authenticatable {

    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    #region Properties

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
    ];

    /**
     * @inheritDoc
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #endregion

    #region Relationships

    /**
     * Возвращает роль.
     *
     * @return BelongsTo
     */
    public function role() {
        return $this->belongsTo(Role::class);
    }

    /**
     * Возвращает список анкет.
     *
     * @return HasMany
     */
    public function summaries() {
        return $this->hasMany(Summary::class);
    }

    #endregion

    #region Scopes

    /**
     * Возвращает список пользователей по указанной роли.
     *
     * @param  Builder $query Запрос.
     * @param  string  $slug  Ярлык роли.
     * @return Builder
     */
    public function scopeOfRole(Builder $query, $slug) {
        return $query
            ->join('roles', 'roles.id', '=', 'role_id', null)
            ->where('roles.slug', $slug);
    }

    #endregion

    /**
     * Определяет, принадлежит ли указанная роль пользователю.
     *
     * @param  array|string $slug Ярлык роли.
     * @return bool
     */
    public function isRole($slug) {
        if (is_string($slug))
            return $this->role->slug === $slug;

        return in_array($this->role->slug, $slug);
    }
}
