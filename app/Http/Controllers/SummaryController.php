<?php

namespace App\Http\Controllers;

use App\Http\Requests\SummaryRequest;
use App\Models\Summary;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SummaryController extends Controller {

    #region Helpers (AJAX)

    /**
     * Возвращает шаблон "Место ..." (Образование, Опыт работы).
     *
     * @param  Request $request Параметры запроса.
     * @param  int $type Идентификатор записи резюме.
     * @return View
     */
    public function place(Request $request, $type = null) {
        return view("components.$type", [
            'index' => $request->get('index')
        ]);
    }

    #endregion

    /**
     * Обрабатывает маршрут создания анкеты.
     *
     * @param  Request $request Параметры запроса.
     * @return View|RedirectResponse
     */
    public function create(Request $request) {

        /** @var Collection $summaries */
        $summaries = $request->user()->summaries;

        if ($summaries->isNotEmpty())
            return response()->redirectToRoute('summary.edit', [ 'summary' => $summaries->first() ]);

        return view('pages.summary');
    }

    /**
     * Обрабатывает маршрут редактирования анкеты.
     *
     * @param  Request $request Параметры запроса.
     * @param  Summary $summary Анкета.
     * @return View
     */
    public function edit(Request $request, Summary $summary) {

        // "Жадная" загрузка зависимостей
        $summary->load('educations', 'experiences');

        return view('pages.summary', $summary->toArray());
    }

    /**
     * Обрабатывает маршрут просмотра анкеты.
     *
     * @param  Request $request Параметры запроса.
     * @param  Summary $summary Анкета.
     * @return View
     */
    public function read(Request $request, Summary $summary) {

        // "Жадная" загрузка зависимостей
        $summary->load('educations', 'experiences');

        return view('pages.summary', array_merge($summary->toArray(), [
            'readonly' => true
        ]));
    }

    /**
     * Обрабатывает маршрут сохранения анкеты.
     *
     * @param  SummaryRequest $request Параметры запроса.
     * @return RedirectResponse
     */
    public function save(SummaryRequest $request) {
        $summary     = $request->except([ 'educations', 'experiences' ]);
        $educations  = $request->get('educations', []);
        $experiences = $request->get('experiences', []);

        /** @var Summary $model */
        $model = Summary::query()->updateOrCreate([ 'id' => data_get($summary, 'id', -1) ], $summary);

        foreach ($educations as $education) {
            $model
                ->educations()
                ->updateOrCreate([ 'id' => data_get($education, 'id', -1) ], $education);
        }

        foreach ($experiences as $experience) {
            $model
                ->experiences()
                ->updateOrCreate([ 'id' => data_get($experience, 'id', -1) ], $experience);
        }

        return response()->redirectToRoute('summary.edit', [ 'summary' => $model ]);
    }
}
