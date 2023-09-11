@extends('templates.vide')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تغيير كلمة المرور</div>

                <div class="card-body">


                    <form method="POST" action="{{ route('home.update_password') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password0" class="col-md-4 col-form-label text-md-end">كلمة المرور القديمة</label>

                            <div class="col-md-6">
                                <input id="password0" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password1" class="col-md-4 col-form-label text-md-end">كلمة المرور الجديدة</label>

                            <div class="col-md-6">
                                <input id="password1" type="password" class="form-control @error('password') is-invalid @enderror" name="password1" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$" title="يجب أن تحتوي كلمة المرور على حرف كبير واحد على الأقل، وحرف صغير واحد، ورقم واحد، وألا يقل طولها عن 8 أحرف." autocomplete="off" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password2" class="col-md-4 col-form-label text-md-end">تأكيد كلمة المرور الجديدة</label>

                            <div class="col-md-6">
                                <input id="password2" type="password" class="form-control  @error('password') is-invalid @enderror" name="password2"  autocomplete="off" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    تأكيد
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
