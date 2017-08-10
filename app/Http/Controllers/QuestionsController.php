<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;
use Auth;

class QuestionsController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        // 验证是否登录，except中的方法不受影响
        $this->middleware('auth')->except(['index', 'show']);
        // 依赖注入
        $this->questionRepository = $questionRepository;
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

        // 获取topics，并将之全部转换为topic_id数组
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        // 封装问题数据并插入
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];
        // 将模型的操作进行封装
        $question = $this->questionRepository->create($data);

        // 使用关联方法更新中间表question_count
        $question->topics()->attach($topics);

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
//        $question = Question::find($id);
        // 使用topics方法关联获取Topic信息
//        $question = Question::where('id', $id)->with('topics')->first();
        // 将模型的操作进行封装
        $question = $this->questionRepository->byIdWithTopics($id);
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
        // 根据id获取问题信息
        $question = $this->questionRepository->byId($id);
        // 问题发布者才允许编辑
        if (Auth::user()->owns($question)) {
            return view('questions.edit', compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreQuestionRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        // 更新问题
        $question = $this->questionRepository->byId($id);
        // 获取topics，并将之全部转换为topic_id数组
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body')
        ]);

        // sync方法只有数组中的topic_id会存在关系表中
        $question->topics()->sync($topics);

        // 使用路由中配置的别名进行跳转
        return redirect()->route('question.show', [$question->id]);
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
