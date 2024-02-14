@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="container">
                    <form action="{{route('surveys.createModule',['survey'=>$survey->id])}}" method="get">
                        @csrf
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    Titolo: {{$survey->title}}<br>
                                    Descrizione: {{$survey->description}}
                                </div>
                                <div class="col text-end">
                                    <button type="submit" class="btn btn-dark mt-1">Aggiungi modulo</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="container">
                         @if($survey->modules)
                             @foreach($survey->modules as $module)
                                <form action="./add_question/{{$survey->id}}/{{$module->id}}" method="get">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col">
                                                Titolo: {{$module->title}}<br>
                                                Descrizione: {{$module->description}}
                                            </div>
                                            <div class="col text-end">
                                                <button type="submit" class="btn btn-dark mt-1">Aggiungi domanda</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        @if($module->questions)
                                            @foreach($module->questions as $question)
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col">
                                                            Domanda: {{$question->question}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </form>
                             @endforeach
                         @endif
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

<script>
    window.onload = function () {
        // Nascondi gli elementi tranne scelta_multipla al caricamento della pagina
        document.getElementById('scelta_multipla_a_piu_scelte').style.display = 'none';
        document.getElementById('scala_lineare').style.display = 'none';
        document.getElementById('risposta_aperta').style.display = 'none';
    };

    function addOption() {
        var dynamicOptions = document.getElementById('dinamicOptions');
        var nuovaOpzione = document.createElement('div');

        nuovaOpzione.className = 'nuova-opzione';
        nuovaOpzione.innerHTML =
            '<div class="form-check mb-2">' +
            '<input  placeholder="Opzione" name="answers[][answer]" type="text" name="exampleForm" id="radioExample1">' +
            '</div>'

        dynamicOptions.appendChild(nuovaOpzione);
    }

    function aggiungiDomanda() {
        var dynamicModules = document.getElementById('dynamicModules');
        var nuovaDomanda = document.createElement('div');

        nuovaDomanda.className = 'nuova-domanda';
        nuovaDomanda.innerHTML =
            '<div class="form-check mb-2">' +
            '<input  placeholder="Opzione" name="answers[][answer]" type="text" name="exampleForm" id="radioExample1">' +
            '</div>'

        dynamicModules.appendChild(nuovaDomanda);
    }

    function aggiungiModulo() {

        var nuovoModulo = document.createElement('div');
        var dynamicModules = document.getElementById('dynamicModules');

        nuovoModulo.className = 'nuovo-modulo';
        nuovoModulo.innerHTML =
            '<div class="row justify-content-center">' +
            '<div class="col-md-8">' +
            '<div class="card">' +
            '<div class="container">' +
            '<div class="card-header">' +
            '</div>' +
            '<div class="card-body">' +
            '<select name="type" id="type" onchange="toggleAnswerFields()">' +
            '<option value="scelta_multipla">Risposta Multipla</option>' +
            '<option value="risposta_aperta">Risposta Aperta</option>' +
            '<option value="scelta_multipla_a_piu_scelte">Scelta multipla a più scelte</option>' +
            '<option value="scala_lineare">Scala Lineare</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        '</div>';

        dynamicModules.appendChild(nuovoModulo);
    }

    function toggleAnswerFields() {
        var questionType = document.getElementById('type').value;

        var rispostaMultipla = document.getElementById('scelta_multipla')
        var rispostaMultpliaPiuRisposte = document.getElementById('scelta_multipla_a_piu_scelte')
        var scalaLineare = document.getElementById('scala_lineare')
        var rispostaAperta = document.getElementById('risposta_aperta')

        if (questionType === 'scelta_multipla') {
            rispostaMultipla.style.display = 'block'
            rispostaMultpliaPiuRisposte.style.display = 'none'
            scalaLineare.style.display = 'none'
            rispostaAperta.style.display = 'none'
        } else if (questionType === 'scelta_multipla_a_piu_scelte') {
            rispostaMultipla.style.display = 'none'
            rispostaMultpliaPiuRisposte.style.display = 'block'
            scalaLineare.style.display = 'none'
            rispostaAperta.style.display = 'none'
        } else if (questionType === 'scala_lineare') {
            rispostaMultipla.style.display = 'none'
            rispostaMultpliaPiuRisposte.style.display = 'none'
            scalaLineare.style.display = 'block'
            rispostaAperta.style.display = 'none'
        } else if (questionType === 'risposta_aperta') {
            rispostaMultipla.style.display = 'none'
            rispostaMultpliaPiuRisposte.style.display = 'none'
            scalaLineare.style.display = 'none'
            rispostaAperta.style.display = 'block'
        }
    }

    function scegliModulo() {

    }
</script>
