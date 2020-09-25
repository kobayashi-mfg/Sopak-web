@extends('layouts.nc_default')

{{--
@section('title')
Blog Posts
@endsection
--}}

@section('title','NC')

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-sm-12">
        </div>
    </div>
</div>


<form action="{{ route('purchases.store') }}" method="post">
    {{ csrf_field() }}
    <div class="f-container">
        <div class="f-item form-paper">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1>新規購入申請</h1>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="select1a">
                                    工程
                                    @if ($errors->has('kotei'))
                                        <span class="error">{{$errors->first('kotei')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <select id="select1a" class="form-control" name="kotei">
                                    <option>機械加工</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">
                                    社員番号 ({{$user->fullname}})
                                    <span class="text-need">必須</span>
                                    @if ($errors->has('worker_id'))
                                        <span class="error">{{$errors->first('worker_id')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="number" id="text1" class="form-control" max="999999" min = "0" maxlength='6' name="worker_id" placeholder="例) 5060" value="{{ $user->employee_no }}" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">
                                    メーカー
                                    <span class="text-need">必須</span> <a class="a-small" href="{{ route('suppliers.index') }}">>>メーカー追加</a>
                                    @if ($errors->has('maker'))
                                        <span class="error">{{$errors->first('maker')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <select id="select1a" class="form-control" name="maker">
                                    <?php if(!empty($suppliers)): ?>
                                        <?php foreach($suppliers as $sup): ?>
                                            <option value="<?=$sup['id'];?>"><?= $sup['name']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">
                                    品名<span class="text-need">必須</span>
                                    @if ($errors->has('hinmei'))
                                        <span class="error">{{$errors->first('hinmei')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" id="text1" class="form-control" maxlength='20' name="hinmei" placeholder="例) 掘削ドリル" value="{{ old('hinmei') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">
                                    型番<span class="text-need">必須</span>
                                    @if ($errors->has('kataban'))
                                        <span class="error">{{$errors->first('kataban')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" id="text1" class="form-control" maxlength='20' name="kataban" placeholder="例) 25T894" value="{{ old('kataban') }}"  required >
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">
                                    数量<span class="text-need">必須</span>
                                    @if ($errors->has('suuryou'))
                                        <span class="error">{{$errors->first('suuryou')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="number" id="text1" class="form-control" maxlength='20' name="suuryou" placeholder="例) 1" value="{{ old('suuryou',1) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">
                                    合計金額<span class="text-need">必須</span>
                                    @if ($errors->has('kingaku'))
                                        <span class="error">{{$errors->first('kingaku')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="number" id="text1" class="form-control" maxlength='20' name="kingaku" placeholder="例) 100000" value="{{ old('kingaku') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">
                                    備考(使用用途、リンクなど)
                                    @if ($errors->has('biko'))
                                        <span class="error">{{$errors->first('biko')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea class="form-control" maxlength='300' cols="40" rows="3" name="biko" placeholder="例) 研磨に使用。http://kobayashi-mfg.co.jp/" >{{ old('biko') }}</textarea>
                            </div>
                        </div>
                    </div>
                    {{--
                    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                    --}}
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">申請</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>

@endsection
