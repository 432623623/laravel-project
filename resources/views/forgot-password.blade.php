<form method="POST" action="{{ route('password.email')}}">
    @csrf
    <input type="email" name="email" required placeholder="Email">
    <button type="submit">Send Reset Link</button>
</form>