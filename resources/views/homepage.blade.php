<x-layout>
    <div class="container py-md-1">
      <div class="row align-items-center">
        <div class="col-lg-7 py-3 py-md-5">
          <h1 class="display-4">Laravel Blog App</h1>
          <p class="lead text-muted">This app features: </p>
          <ul class="lead text-muted"> 
            <li>blog posting</li>  
            <li>member registration</li>
            <li>login/logout</li>
            <li>follow</li>
            <li>search</li>            
          </ul> 
          <p class="lead text-muted">Users have authored {{$postCount}} posts</p>
        </div>
        <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">
          <form action="/register" method="POST" id="registration-form">
            <div class="form-group">
              @csrf
              <label for="username-register" 
                class="text-muted mb-1"><small>Username</small></label>
              <input value="{{old('username')}}" 
                name="username" 
                id="username-register" 
                class="form-control" 
                type="text" 
                placeholder="Pick a username" 
                autocomplete="off" />
              @error('username')
              <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
            </div>

            <div class="form-group">
              <label for="email-register" class="text-muted mb-1">
                <small>Email</small></label>
              <input value="{{old('email')}}" 
                name="email" 
                id="email-register" 
                class="form-control" 
                type="text" 
                placeholder="you@example.com" 
                autocomplete="off" />
              @error('email')
              <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
            </div>

            <div class="form-group">
              <label for="password-register" class="text-muted mb-1">
                <small>Password</small></label>
              <input name="password" 
                id="password-register" 
                class="form-control" 
                type="password" 
                placeholder="Create a password" />
              @error('password')
              <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
            </div>

            <div class="form-group">
              <label for="password-register-confirm" class="text-muted mb-1">
                <small>Confirm Password</small></label>
              <input name="password_confirmation" 
                id="password-register-confirm" 
                class="form-control" 
                type="password" 
                placeholder="Confirm password" />
              @error('password_confirmation')
              <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
            </div>

            <button type="submit" 
            class="py-3 mt-4 btn btn-lg btn-success btn-block">Sign up for OurApp</button>
          </form>

        </div>
      </div>
    </div>
</x-layout>