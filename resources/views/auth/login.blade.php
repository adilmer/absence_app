@extends('templates.vide')

@section('content')
<div class="row justify-content-center ">
          <div class="col-md-6">
            <div class="card mb-0">
              <div class="card-body">
              <form method="POST" action="{{ route('login') }}">
                        @csrf
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/logo.png" width="200" alt="">
                </a>

                <p class="text-center h3">تسجيل الدخول</p>
                <form>
                  <div class="mb-3">
                    <label for="email" class="form-label"> البريد الإلكتروني</label>
                    <input type="email" class="form-control"  autocomplete="off"  name="email" id="email" aria-describedby="emailHelp">
                    @error('email')
                    <p class="alert small  alert-danger p-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </p>
                                @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">الرمز السري</label>
                    <input type="password" class="form-control "  autocomplete="off"  name="password" id="password">
                    @error('password')
                                    <p class="alert small  alert-danger p-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                @enderror
                  </div>

                  <div class="row mb-3">
                            <div class="col-md-6 offset-md-4 ">
                                <div class="form-group ">
                                    <input class="form-check-inline" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        تذكرني
                                    </label>

                                </div>
                                <button type="submit" class="btn btn-primary m-3">
                                    دخول
                                </button>
                            </div>
                        </div>


                </form>
              </div>
            </div>
          </div>
        </div>
@endsection
