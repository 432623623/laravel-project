<x-layout>
    <div class="container--narrow account-section">
        <h2>My Account</h2>
        <p>Hello <strong>{{auth()->user()->username}}</strong></p>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="section-title">Change Email</div>
        <p>Your email is {{auth()->user()->email}}</p>

        <form method="POST" action="{{ route('account.email') }}" 
            onsubmit="return confirm('Change email?');">
            @csrf
            <input type="email" name="email" placeholder="New email" required>
            <button type="submit">Change Email</button>
        </form>
        <div class="section-title">Change Password</div>
        <form method="POST" action="{{ route('account.password') }}" 
            onsubmit="return confirm('Change password?');">
            @csrf
            <input type="password" name="current_password" placeholder="Current password" required>
            <input type="password" name="password" placeholder="New password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm new password" required>
            <button type="submit">Change Password</button>
        </form>
        <div class="section-title">Delete Account</div>
        <form method="POST" action="{{ route('account.delete') }}"                     
            onsubmit="return confirm('Delete account?');">
            @csrf
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</x-layout>