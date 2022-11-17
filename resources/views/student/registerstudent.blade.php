
@section('contentregister')
<div class="row flex-grow">
    <div class="col-md-4 mx-auto">
        <div class="auth-form-light p-5 border border-dark">
            <form method="POST" action="{{ route('student.register') }}" novalidate>
                @csrf
                <div class="form-group">
                    <label for="name" class="sr-only">Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="sr-only">Registration Number</label>
                    <input type="text" id="text" name="regno" class="form-control @error('email') is-invalid @enderror" value="{{ old('regno') }}" required placeholder="Registration number">
                    @error('regno')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" name="passWord" class="form-control @error('password') is-invalid @enderror" required placeholder="Password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="sr-only">Confirm Password</label>
                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" required placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-block btn-primary">
                   Add student
                </button>
               
            </form>
        </div>
    </div>
</div>
@endsection