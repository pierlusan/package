<?php

namespace LP\surveys\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LP\surveys\Models\Module;
use LP\surveys\Models\Question;
use LP\surveys\Models\Survey;

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
        }else{
            $massimoValore = $modules->max(function ($item) {
                return $item->module_number;
            });
            $module->module_number = $massimoValore+1;
        }
        $module->title = $data['titolo'];
        $module->description = $data['descrizione'];
        $module->survey_id = $id;
        $module->save();

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
            $question->answers()->createMany($data['answers']);
        }elseif ($data['type'] == 'open-ended'){
            if($data['image'] == null){
                $question = $module->questions()->create(['question' => $data['question'],'type'=>$data['type'],'points'=> 5]);
            }else{
                $fileName = time().$data->file('image')->getClientOriginalName();
                $path = $data->file('image')->storeAs('images',$fileName,'public');
                $foto = '/storage/'.$path;
                $question = $module->questions()->create(['question' => $data['question'],'type'=>$data['type'],'immagine'=>$foto,'points'=>5]);
            }
        }elseif ($data['type'] == 'linear_scale'){
            $question = $module->questions()->create(['question' => $data['question'],'type'=>$data['type'],'from'=>$data['from'],'to'=> $data['to']]);
            $question->answers()->createMany($data['etichette']);
        }

        return redirect('surveys/edit/'.$idSurvey);
    }

}
