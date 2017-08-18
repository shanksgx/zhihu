<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Auth;

class AnswersController extends Controller
{
    //
    protected $answer;

    /**
     * AnswersController constructor.
     * @param $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    /**
     * 回答问题
     *
     * @param StoreAnswerRequest $request
     * @param integer $question question_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAnswerRequest $request, $question)
    {
        // 回答问题
        $answer = $this->answer->create([
            'question_id' => $question,
            'user_id' => Auth::id(),
            'body' => $request->get('body')
        ]);

        // 问题的回答数+1
        $answer->question()->increment('answers_count');
        return back();
    }
}
