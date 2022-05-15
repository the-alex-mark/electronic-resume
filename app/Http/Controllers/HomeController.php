<?php

namespace App\Http\Controllers;

use App\Models\Summary;
use App\Models\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller {

    /**
     * @inheritDoc
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Обрабатывает маршрут главной страницы сервиса.
     *
     * @param  Request $request Параметры запроса
     * @return View
     */
    public function index(Request $request) {
        if ($request->user()->isRole('candidate')) {
            $summaries = $request->user()
                ->summaries()
                ->with('result')
                ->when($request->get('all', false) == false, function ($query) {
                    $query->limit(1);
                })
                ->get();

            return view('pages.home', [
                'summaries' => $summaries
            ]);
        }

        // Получение списка анкет
        $summaries = Summary::query()
            ->with('user')
            ->when($request->get('all', false) == false, function (Builder $query) {
                return $query
                    ->with('result')
                    ->whereHas('result', function (Builder $query) {
                        return $query->whereNotNull('answers');
                    });
            })
            ->get();

        // Получение списка тестов
        $tests = Test::query()
            ->with('position')
            ->get();

        return view('pages.admin', [
            'summaries' => $summaries,
            'tests'     => $tests
        ]);
    }
}
