<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRequest;
use App\Models\Test;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TestController extends Controller {

    #region Helpers (AJAX)

    /**
     * Возвращает шаблон "Вопрос".
     *
     * @param  Request $request Параметры запроса.
     * @return View
     */
    public function question(Request $request) {
        return view("components.test.question", array_merge($request->all(), [
            'show' => true
        ]));
    }

    /**
     * Возвращает шаблон "Вариант ответа".
     *
     * @param  Request $request Параметры запроса.
     * @return View
     */
    public function answer(Request $request) {
        return view("components.test.answer", [
            'question' => $request->get('question'),
            'index'    => $request->get('index')
        ]);
    }

    #endregion

    /**
     * Обрабатывает маршрут создания теста.
     *
     * @param  Request $request Параметры запроса.
     * @return View
     */
    public function create(Request $request) {
        return view('pages.test');
    }

    /**
     * Обрабатывает маршрут редактирования теста.
     *
     * @param  Request $request Параметры запроса.
     * @param  Test $test Тест.
     * @return View
     */
    public function edit(Request $request, Test $test) {
        return view('pages.test', array_merge($test->data, [
            'id'          => $test->id,
            'position_id' => $test->position_id,
        ]));
    }

    /**
     * Обрабатывает маршрут сохранения теста.
     *
     * @param  TestRequest $request Параметры запроса.
     * @return RedirectResponse
     */
    public function save(TestRequest $request) {
        $id = $request->get('id', -1);
        $title = $request->get('title', '');
        $position_id = $request->get('position_id');
        $data = $request->only([ 'title', 'description' ]);
        $data = array_merge($data, [ 'questions' => $request->get('questions') ]);

        /** @var Test $model */
        $model = Test::query()->updateOrCreate([ 'id' => $id ], [
            'title'       => $title,
            'position_id' => $position_id,
            'data'        => $data
        ]);

        return response()->redirectToRoute('test.edit', [ 'test' => $model ]);
    }

    /**
     * Обрабатывает маршрут экспорта (загрузки) теста.
     *
     * @param  Request $request Параметры запроса.
     * @param  Test $test Тест.
     * @return StreamedResponse
     */
    public function export(Request $request, Test $test) {
        $path = 'public/tests/test-' . Carbon::now()->timestamp . '.json';

        // Создание файла
        if (!Storage::exists($path))
            Storage::put($path, json_encode($test->data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return Storage::download($path, $test->title . '.json');
    }

    /**
     * Обрабатывает маршрут удаления теста.
     *
     * @param  Request $request Параметры запроса.
     * @param  Test $test Тест.
     * @return RedirectResponse
     */
    public function delete(Request $request, Test $test) {
        $title  = $test->title;
        $result = $test->delete();

        return back()->with('response', [
            'result'  => $result,
            'message' => ($result) ? 'Тест «' . $title . '» успешно удалён.' : 'Не удалось удалить тест «' . $title . '». Повторите, пожалуйста, попытку через некоторое время.'
        ]);
    }
}
