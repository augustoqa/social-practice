@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 mx-auto">
            @include('partials.validation-errors')
			<div class="card border-0 bg-light py-2 px-4">
				<form action="{{ route('login') }}" method="post">
					@csrf
					<div class="card-body">
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" class="form-control border-0" id="email" placeholder="Tu email...">
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input type="password" name="password" class="form-control border-0" id="password" placeholder="Tu Contraseña">
						</div>
						<button dusk="login-btn" class="btn btn-primary btn-block">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
