<?php

namespace App\Http\Controllers;

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
}
