<?php

namespace App\View\Components;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Positions extends Component {

    /**
     * Инициализирует компонент "`<x-positions/>`".
     *
     * @param  string $id    Идентификатор элемента.
     * @param  string $name  Имя элемента.
     * @param  string $value Текущее значение.
     * @return void
     */
    public function __construct($id = '', $name = '', $value = '') {
        $this->list  = Position::all();
        $this->id    = $id;
        $this->name  = $name;
        $this->value = $value;
    }

    #region Properties

    /**
     * @var Collection
     */
    private $list;

    /**
     * @var string Идентификатор элемента
     */
    public $id = null;

    /**
     * @var string Имя элемента
     */
    public $name = null;

    /**
     * @var string Текущее значение
     */
    public $value = null;

    #endregion

    /**
     * @inheritDoc
     */
    public function render() {
        return view('components.positions', [
            'list'  => $this->list,
            'id'    => $this->id,
            'name'  => $this->name,
            'value' => $this->value
        ]);
    }
}
