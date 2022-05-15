<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PassageController extends Controller {

    /**
     * Обрабатывает маршрут прохождения теста.
     *
     * @param  Request $request Параметры запроса.
     * @return View
     */
    public function create(Request $request) {

        /** @var User $user */
        $user = $request->user();

        /** @var Result $result */
        $result = $user->summaries()
            ->first()
            ->result;

        return view('pages.passage', array_merge($result->questions, [
            'id' => $result->id
        ]));
    }

    /**
     * Обрабатывает маршрут сохранение пройденного теста.
     *
     * @param  Request $request Параметры запроса.
     * @return RedirectResponse
     */
    public function save(Request $request) {
        $id = $request->get('id', -1);
        $results = $request->only('results');

        /** @var Result $model */
        $model = Result::query()->updateOrCreate([ 'id' => $id ], [
            'answers' => $results
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
