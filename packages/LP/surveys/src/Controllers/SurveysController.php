<?php

namespace LP\surveys\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use LP\surveys\Models\Answer;
use LP\surveys\Models\FlowLogic;
use LP\surveys\Models\Module;
use LP\surveys\Models\Question;
use LP\surveys\Models\Survey;
use LP\surveys\Models\Survey_responses;
use LP\surveys\Models\SurveyUser;

class SurveysController extends Controller
{

    public function create()
    {
        return view('surveys::create');
    }

    public function edit($id)
    {
        //$survey = Survey::where('id','3')->first();
        //dd($survey);
        $survey = Survey::findOrFail($id);
        return view('surveys::edit',compact('survey'));
    }

    public function store(){
        //dd(request()->all());
        $data = request();

        $survey = new Survey();
        $survey->title = $data['titolo'];
        $survey->description = $data['descrizione'];
        $survey->save();
        return redirect("surveys/edit/".$survey->id);

    }

    public function createModule($id)
    {
        $survey = Survey::findOrFail($id);
        return view('surveys::createModule',compact('survey'));
    }

    public function storeModule($id)
    {
        //dd(request()->all());
        $data = request();
        $survey = Survey::findOrFail($id);
        $modules = Module::where('survey_id', $id)->get();
        $module = new Module();
        //dd($modules->all());

        if(empty($modules->all())){
            $module->module_number = 1;
            $module->title = $data['titolo'];
            $module->description = $data['descrizione'];
            $module->survey_id = $id;
            $module->save();
        }else{
            $massimoValore = $modules->max(function ($item) {
                return $item->module_number;
            });

            $previousModule = Module::where('survey_id', $id)->where('module_number',$massimoValore)->first();
            //dd($previousModule);
            $module->title = $data['titolo'];
            $module->description = $data['descrizione'];
            $module->survey_id = $id;
            $module->module_number = $massimoValore+1;
            $module->save();
            $flowLogic = new FlowLogic();
            $flowLogic->current_module_id = $previousModule->id;
            $flowLogic->next_module_id = $module->id;
            $flowLogic->save();

        }


        return redirect('surveys/edit/'.$id);
    }

    public function createQuestion($idSurvey,$idModule)
    {
        $survey = Survey::findOrFail($idSurvey);
        $module = Module::findOrFail($idModule);
        return view('surveys::createQuestion',compact('survey'),compact('module'));
    }

    public function storeQuestion($idSurvey,$idModule)
    {
        //dd(request()->all());
        $data = request();
        //dd($data);
        //dd(time().$data->file('image'));


        $module = Module::findOrFail($idModule);

        if($data['type'] == 'single_choice' || $data['type'] == 'multiple_choice'){
            $question = $module->questions()->create(['question' => $data['question'],'type'=>$data['type'],'points'=> 5]);
            //dd($data['answers']);
            $question->answers()->createMany($data['answers']);
        }elseif ($data['type'] == 'open-ended'){
            if($data['image'] == null){
                $question = $module->questions()->create(['question' => $data['question'],'type'=>$data['type']]);
            }else{
                $fileName = time().$data->file('image')->getClientOriginalName();
                $path = $data->file('image')->storeAs('images',$fileName,'public');
                $foto = '/storage/'.$path;
                $question = $module->questions()->create(['question' => $data['question'],'type'=>$data['type'],'immagine'=>$foto]);
            }
        }elseif ($data['type'] == 'linear_scale'){
            $question = $module->questions()->create(['question' => $data['question'],'type'=>$data['type'],'from'=>$data['from'],'to'=>$data['to'],'fromAnswer'=>$data['fromAnswer'],'toAnswer'=>$data['toAnswer']]);
            //dd($question->answerLinear());
            $answers=[];
            for ($i = $data['from'] ; $i < $data['to']+1;$i++){
                $l = ['answer'=>$i];
                $answers[]=$l;
            }
            //dd($answers);
            $question->answers()->createMany($answers);
        }

        return redirect('surveys/edit/'.$idSurvey);
    }


    public function showSurvey($idSurvey,$idModulo = null)
    {
        $survey = Survey::findOrFail($idSurvey);

        if($idModulo == null){
            $module = Module::where('survey_id',$idSurvey)->where('module_number',1)->first();
        }else{
            $module = Module::where('id',$idModulo)->first();
            //dd($module);
        }
        return view('surveys::complete', compact('survey','module'));
    }



    public function saveResponse($idSurvey,$idModule)
    {
        //dd(request()->all());
        $data = request();
        $nextModule = null;
        foreach ($data['responses'] as $response){
            if(array_key_exists('answer',$response)){
                $surveyResponse = new Survey_responses();
                $surveyResponse->question_id = $response['question'];
                $surveyResponse->survey_id = $idSurvey;
                $surveyResponse->answer_id = $response['answer'];
                $surveyResponse->user = Auth::user()->id;
                if(array_key_exists('questionPoints',$response)){
                    $answer = Answer::where('id',$response['answer'])->first();
                    $surveyResponse->valore_risposta = $answer->value;
                    $surveyResponse->valore_domanda = $response['questionPoints'];
                    $nextModule = $answer->next_module_id;
                    //dd($nextModule);
                }
                $surveyResponse->save();
            }
            if(!array_key_exists('answer',$response)){
                if(!array_key_exists('textAnswer',$response)){
                   foreach($response['answers'] as $item){
                       $surveyResponse = new Survey_responses();
                       $surveyResponse->question_id = $response['question'];
                       $surveyResponse->survey_id = $idSurvey;
                       $surveyResponse->answer_id = $item;
                       $surveyResponse->user = Auth::user()->id;
                       $surveyResponse->save();
                   }
                }else{
                    $surveyResponse = new Survey_responses();
                    $surveyResponse->question_id = $response['question'];
                    $surveyResponse->survey_id = $idSurvey;
                    $surveyResponse->text_answer = $response['textAnswer'];
                    $surveyResponse->user = Auth::user()->id;
                    $surveyResponse->save();
                }
            }
            //dd(Auth::user());
        }
        //dd($nextModule);
        if($nextModule == null){
            $module = FlowLogic::where('current_module_id',$idModule)->first();
            //dd($module->next_module_id);
            if($module == null){
               return redirect('surveys/create');
            }
            return redirect('surveys/'.$idSurvey.'/'.$module->next_module_id);
        }else{
            return redirect('surveys/'.$idSurvey.'/'.$nextModule);
        }

    }

    public function showResponses($idSurvey,$user)
    {
        $responses = Survey_responses::where('survey_id',$idSurvey)->where('user',$user)->get();
        return view('surveys::showResults',compact('responses'));
    }


    public static function allSurveys()
    {
        $surveys = Survey::all();
        return $surveys;
    }

    public static function setSurveyToUser($user,$idSurvey)
    {
        $surveyUser = new SurveyUser();
        $surveyUser->user = $user;
        $surveyUser->survey_id = $idSurvey;
        $surveyUser->save();
        return redirect('/');
    }

    public static function getUserSurveys($user)
    {
        $userSurveys = SurveyUser::where('user', $user)->get();
        $surveys = [];
        foreach ($userSurveys as $userSurvey) {
            $survey = Survey::where('id',$userSurvey->survey_id)->first();
            $surveys[]= $survey;

        }

        return $surveys;
    }



}
