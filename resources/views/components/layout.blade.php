<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
      @isset($doctitle)
      {{$doctitle}} | Example App
      @else 
      Example App
      @endisset
    </title>
    <link rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <livewire:styles />
   </head>
  <body>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
    <header class="header-bar mb-3">
      <div class="container-fluid d-flex flex-column flex-md-row 
      align-items-center align-items-md-end py-3 text-center text-md-left">
        <h4 class="my-0 mr-md-auto font-weight-normal">
          <a wire:navigate href="/" class="text-white">
            <img src="{{ asset('logo.png') }}" alt="Example App" style="height: 40px;">
          </a>
        </h4>
        <nav class="top-nav d-flex align-items-end">
          <a href="{{ route('posts.index')}}" title="All User Posts" data-toggle="tooltip">Posts</a>
          <a href="{{ route('users.index')}}" title="All Users" data-toggle="tooltip">Users</a>
          @auth
          @if( auth()->user()->is_admin && !Route::is('admin.dashboard'))
            <a href="{{ route('admin.dashboard')}}" 
            title="Admin Dashboard" data-toggle="tooltip">Admin</a>
          @endif
          <a href="{{ route('account.manage') }}" title="My Account" 
          data-toggle="tooltip">Account</a>
          @endauth
        </nav>
        @auth
            <div class="d-flex flex-column align-items-end">
              <form action="{{ route('search.index') }}" method="GET" 
                class="d-flex align-items-center" >
                <input type="text" name="q" 
                  class="form-control form-control-sm mb-2"                   
                  placeholder = "Search posts... " 
                  autocomplete="off" value="{{ request('q')}}">
                <button type="submit" class="btn btn-sm btn-primary ml-2 mr-4 mb-2">
                  <i class= "fas fa-search"></i>
                </button>
              </form>
              <div class="d-flex align-items-end">
              <a wire:navigate href="/profile/{{auth()->user()->username}}" 
                class="mr-2"><img title="My Profile" data-toggle="tooltip" 
                data-placement="bottom" style="width: 32px; height: 32px; border-radius: 16px" 
                src="{{auth()->user()->avatar}}" /></a>
              <a wire:navigate class="btn btn-sm btn-success mr-2" 
                href="/create-post">Create Post</a>
              <form action="/logout" method="POST" class="d-inline mr-4">
                @csrf
                <button class="btn btn-sm btn-secondary">Sign Out</button>
              </form>
              </div>
            </div>
        @else            
        <div class="d-flex flex-column align-items-center">
            <form action="/login" method="POST" class="mb-0 pt-2 pt-md-0 needs-validation">
              @csrf
              <div class="form-row align-items-center">
                <div class="col-14 col-md-4 mb-2 mb-md-0">
                  <input name="loginusername" 
                  class="form-control form-control-sm input-dark" 
                  type="text" placeholder="Username" autocomplete="off" required />
                </div>
                <div class="col-14 col-md-4 mb-2 mb-md-0">
                  <input name="loginpassword" 
                  class="form-control form-control-sm input-dark" 
                  type="password" placeholder="Password" required/>
                </div>
                <div class="col-14 col-md-auto">
                  <button 
                  class="btn btn-primary btn-sm btn-block btn-md-inline">
                  Sign In</button>
                </div>
              </div>
            </form>
          </div>
        @endauth
      
</header>
        <!-- header ends here -->
        @if (session()->has('success'))
        <div class="container container--narrow">
          <div class="alert alert-success text-center">
            {{session('success')}}
          </div>
        </div>
        @endif
        @if (session()->has('failure'))
        <div class="container container--narrow">
          <div class="alert alert-danger text-center">
            {{session('failure')}}
          </div>
        </div>
        @endif

    {{$slot}}

    <!-- footer begins -->
    <footer class="border-top text-center small text-muted py-3">
      <p class="m-0">Copyright &copy; {{date('Y')}} <a wire:navigate href="/" class="text-muted">Example App</a>. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
      $('[data-toggle="tooltip"]').tooltip()
    </script>
      <livewire:scripts />
      @stack('scripts')
      
  </body>
</html>