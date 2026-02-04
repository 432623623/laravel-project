<form >
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="New Password">
    <input type="password" name="password_confirmation" required placeholder="Confirm Pasword">
    <button>Reset Password</button>
</form>