<?php

namespace App\Http\Controllers;

use App\Http\Requests\SummaryRequest;
use App\Models\Summary;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SummaryController extends Controller {

    /**
     * ...
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
     * ...
     *
     * @param  Request $request Параметры запроса.
     * @param  Summary $summary Анкета.
     * @return View
     */
    public function edit(Request $request, Summary $summary) {
        $summary = Summary::query()
            ->with('educations', 'experiences')
            ->find($summary->id);

        return view('pages.summary', $summary->toArray());
    }

    /**
     * ...
     *
     * @param  Request $request Параметры запроса.
     * @param  int $type Идентификатор записи резюме.
     * @return View
     */
    public function place(Request $request, $type = null) {
        return view("components.$type", [ 'index' => $request->get('index') ]);
    }

    /**
     * ...
     *
     * @param  SummaryRequest $request Параметры запроса.
     * @return RedirectResponse
     */
    public function save(SummaryRequest $request) {
        $summary     = $request->except([ 'educations', 'experiences' ]);
        $educations  = $request->get('educations');
        $experiences = $request->get('experiences');

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
