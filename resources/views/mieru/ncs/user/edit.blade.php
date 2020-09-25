@extends('layouts.nc_default')



@section('title','NC')

@section('content')
<div class="container mt-3">
    <div class="row">
        <div class="col-sm-12">
            <p><a href="{{ route('users.index') }}">ユーザーへもどる</a></p>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">編集</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}

                        <div class="form-group row">
                            <label for="employee_no" class="col-md-4 col-form-label text-md-right">社員番号</label>

                            <div class="col-md-6">
                                <input id="employee_no" type="number" class="form-control @error('employee_no') is-invalid @enderror" name="employee_no" value="{{ old('employee_no', $user->employee_no) }}" min="0" max="9999" required readonly>

                                @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ユーザー名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" max-length="15" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fullname" class="col-md-4 col-form-label text-md-right">氏名</label>

                            <div class="col-md-6">
                                <input id="fullname" type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname', $user->fullname) }}" max-length="15" required >

                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">電話番号</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="25" required>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @can('system-only')
                            <div class="form-group row">
                                <label for="privilege-select" class="col-md-4 col-form-label text-md-right">権限</label>

                                <div class="col-md-6">
                                    <select id="privilege-select" class="form-control @error('privilege') is-invalid @enderror" name="privilege" required>
                                        <option value="10">一般</option>
                                        <option value="5">マネージャー</option>
                                        <option value="1">シス管</option>
                                    </select>
                                    @error('privilege')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @elsecan('admin-higher')
                            <div class="form-group row">
                                <label for="privilege-select" class="col-md-4 col-form-label text-md-right">権限</label>

                                <div class="col-md-6">
                                    <select id="privilege-select" class="form-control @error('privilege') is-invalid @enderror" name="privilege" required>
                                        <option value="10">一般</option>
                                        <option value="5">マネージャー</option>
                                    </select>
                                    @error('privilege')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @elsecan('user-higher')
                            <div class="form-group row" style="display:none;">
                                <label for="privilege-select" class="col-md-4 col-form-label text-md-right">権限</label>

                                <div class="col-md-6">
                                    <input id="privilege-selector" type="hidden" class="form-control @error('privilege') is-invalid @enderror" name="privilege" value="{{ old('privilege', $user->privilege) }}" max-length="3" required>
                                    @error('privilege')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" max-length="30" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4 d-flex justify-content-start">
                                <button type="submit" class="btn btn-primary">
                                    確定
                                </button>
                                <div class="ml-3 d-flex align-items-center" >
                                    <p style="margin:0;"><a href="{{ route('users.index') }}">キャンセル</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">パスワード変更</div>

                <div class="card-body">

                    <form method="POST" action="{{route('users.update_pass', $user)}}">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}

                        <div class="form-group row">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right">現在のパスワード</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required autocomplete="old_password">

                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">新しいパスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">新しいパスワード（確認）</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="password_confirmation">
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 d-flex justify-content-start">
                                <button type="submit" class="btn btn-primary">
                                    確定
                                </button>
                                <div class="ml-3 d-flex align-items-center" >
                                    <p style="margin:0;"><a href="{{ route('users.index') }}">キャンセル</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- メーカーselectタグ選択 -->
<script type="text/javascript">
    window.onload=function(){
        document.getElementById('privilege-select').value = <?= $user['privilege']; ?>;
    }
</script>
@endsection
