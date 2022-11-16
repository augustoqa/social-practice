@extends('layouts.app')

@section('content')
<div class="container"></div>
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card border-0 bg-light">
                <form action="{{ route('statuses.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <textarea name="body" class="form-control border-0 bg-light" placeholder="¿Qué estás pensando César?"></textarea>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="create-status" class="btn btn-primary">Publicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection