@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="container">
                    <form action="{{route('surveys.saveResponse')}}" method="post">
                        <div class="card-header mt-3">
                            <div class="row">
                                <div class="col">
                                    Titolo: {{$survey->title}}<br>
                                    Descrizione: {{$survey->description}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col">
                                            Titolo: {{$module->title}}<br>
                                            Descrizione: {{$module->description}}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach($module->questions as $key=>$question)
                                        @if($question->type == 'linear_scale')
                                            <div class="container">
                                                <div class="card-body">
                                                    <div class="mx-0 mx-sm-auto">
                                                        <div class="text-center">
                                                            <p>
                                                                <strong>{{$question->question}}</strong>
                                                            </p>
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <div class="d-inline mx-3">
                                                                {{$question->answerLinear->fromAnswer}}
                                                            </div>
                                                            @for($i = $question->answerLinear->from; $i < $question->answerLinear->to+1;$i++)
                                                                <div class="form-check form-check-inline" id="{{$i}}">
                                                                    <input type="radio"
                                                                           name="responses[{{$key}}][answer]"
                                                                           value="{{$i}}"
                                                                    >
                                                                    <input type="hidden" name="responses[{{$key}}][question]"
                                                                           value="{{$question->id }}">


                                                                    <label class="form-check-label"
                                                                           for="inlineRadio1">{{$i}}</label>
                                                                </div>
                                                            @endfor
                                                            <div class="d-inline me-4">
                                                                {{$question->answerLinear->toAnswer}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($question->type == 'single_choice')
                                            <div class="container">
                                                <div class="card-body">
                                                    <div class="row col-5">
                                                        <p class="fw-bold">{{$question->question}}</p>
                                                        @foreach($question->answers as $answer)
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio"
                                                                       name="responses[{{$key}}][answer]"
                                                                       value="{{$answer->answer}}"
                                                                >
                                                                <input type="hidden" name="responses[{{$key}}][question]"
                                                                       value="{{$question->id }}">
                                                                <input type="hidden" name="responses[{{$key}}][next]"
                                                                       value="{{$answer->next_module_id}}">

                                                                <label class="form-check-label" for="radioExample1">
                                                                    {{$answer->answer}}
                                                                </label>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($question->type == 'open-ended')
                                            <div class="container">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="container text-center mt-3">
                                                            <div class="col">
                                                                <p class="fw-bold">{{$question->question}}</p>
                                                            </div>
                                                            @if($question->immagine)
                                                                <div
                                                                    style="width: 100px; height: 100px; overflow: hidden; display: flex; justify-content: center; align-items: center; margin: auto;">
                                                                    <img src="{{ asset($question->immagine) }}"
                                                                         alt="Descrizione dell'immagine"
                                                                         style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="form-group mt-4">
                                                            <input type="text" class="form-control"
                                                                   name="responses[{{$key}}][answer]">
                                                            <input type="hidden" name="responses[{{$key}}][question]"
                                                                   value="{{$question->id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($question->type == 'multiple_choice')
                                            <div class="container">
                                                <div class="card-body">
                                                    <div class="row col-5">
                                                        <p class="fw-bold">{{$question->question}}</p>
                                                        <input type="hidden" name="responses[{{$key}}][question]"
                                                               value="{{$question->id }}">
                                                        @foreach($question->answers as $key2=>$answer)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       name="responses[{{$key}}][{{$key2}}]"
                                                                       value="{{$answer->answer}}"
                                                                       id="flexCheckDefault"/>
                                                                <label class="form-check-label"
                                                                       for="flexCheckDefault">
                                                                    {{$answer->answer}}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-dark mb-3">Avanti</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
