<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CheckingController extends Controller {

    /**
     * Обрабатывает маршрут прохождения теста.
     *
     * @param  Request $request Параметры запроса.
     * @return View
     */
    public function check(Request $request, Result $result) {
        $questions = $result->questions;
        $answers   = $result->answers;

        for ($i = 0; $i < count($questions['questions']); $i++) {
            $questions['questions'][$i] = array_merge(
                $questions['questions'][$i],
                $answers['results'][$i]
            );
        }

        return view('pages.checking', array_merge($questions, [
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
        $id      = $request->get('id', -1);
        $results = $request->only('results');

        /** @var Result $model */
        $model = Result::query()->find($id);

        $model->update([
            'answers' => array_replace_recursive($model->answers, $results),
            'checked_at' => Carbon::now()->setTimezone('UTC')
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
