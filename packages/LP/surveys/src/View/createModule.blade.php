@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="container">
                    <form action="{{route('surveys.storeModule',['survey'=>$survey->id])}}" method="post">
                        @csrf
                        <div class="card-header">
                            Crea nuovo modulo
                        </div>
                        <div class="mb-4 mt-4">
                            <label for="title" class="block text-stone-100">Titolo<span class="font-bold text-base text-red-600">*</span></label>
                            <input name="titolo" id="titolo" class="form-control" type="text" placeholder="Titolo" aria-label="default input example">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-stone-100">Descrizione<span class="font-bold text-base text-red-600">*</span></label></label>
                            <input name="descrizione" id="descrizione" class="form-control" type="text" placeholder="Descrizione" aria-label="default input example">
                        </div>
                        <button type="submit" class="btn btn-dark float-end mt-auto mb-2">Avanti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
