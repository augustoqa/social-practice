<form action="{{ route('login') }}" method="post">
	@csrf
	<input type="email" name="email" id="">
	<input type="password" name="password" id="">
	<button id="login-btn">Login</button>
</form>