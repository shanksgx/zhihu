<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Question;
use Auth;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function __construct()
    {
        // 验证是否登录，except中的方法不受影响
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return 'index';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 发布问题页面
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreQuestionRequest $request)
    {
        // post发布问题
        // 图片上传问题暂未搞定
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];
        $question = Question::create($data);
        // 使用路由中配置的别名进行跳转
        return redirect()->route('question.show', [$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 显示问题页面
        $question = Question::find($id);
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
