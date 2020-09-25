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
            <p><a href="{{ route('purchases.index') }}">購入申請一覧へもどる</a></p>
        </div>
    </div>
</div>


    <div class="f-container">
        <div class="f-item form-paper edit-form-paper">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-10">
                            <h1>購入申請編集 <span class="small-h2-font">{{$status}}</span></h1>
                        </div>
                        <div class="col-sm-2 d-flex justify-content-end" id="delete-btn">
                            <div class="btn-delete text-center">
                                ｘ
                            </div>
                            <form method="post" action="{{ route('purchases.delete',$app) }}" id="form_destory">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
                        </div>
                    </div>
                    <form action="{{ route('purchases.update', $app->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
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
                                        メーカー
                                        <span class="text-need">必須</span>  <a class="a-small" href="{{ route('suppliers.index') }}">>>メーカー追加</a>
                                        @if ($errors->has('maker'))
                                            <span class="error">{{$errors->first('maker')}}</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <select id="maker-select" class="form-control" name="maker">
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
                                    <input type="text" id="text1" class="form-control" maxlength='20' name="hinmei" placeholder="例) 掘削ドリル" value="<?= $app['item_name'];?>"required >
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
                                    <input type="text" id="text1" class="form-control" maxlength='20' name="kataban" placeholder="例) 25T894" value="<?= $app['item_id'];?>" required >
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
                                    <input type="number" id="text1" class="form-control" maxlength='20' name="suuryou" value="<?= $app['quantity'];?>" value="<?= $app['quantity'];?>" required >
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
                                    <input type="number" id="text1" class="form-control" maxlength='20' name="kingaku" placeholder="例) 100000" value="<?= $app['price'];?>" required >
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
                                    <textarea class="form-control" maxlength='300' cols="40" rows="3" name="biko" ><?= $app['biko'];?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <p class="mb-2">*編集確定を行った場合、状態は「申請中」になります。</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">編集確定</button>
                                <a href="{{ route('purchases.show', $app->id) }}" class="ml-2">キャンセル</a>
                            </div>
                        </div>

                    </form>
                </div>
            </section>
        </div>
    </div>

<!-- 削除ボタンを押したとき -->
<script type="text/javascript">
    document.getElementById("delete-btn").onclick = function() {
        // alert('hello');
        var result = window.confirm('本当に削除しますか？');
        if( result ) {
            document.getElementById('form_destory').submit();
        }
    };
</script>



<!-- メーカーselectタグ選択 -->
<script type="text/javascript">
    window.onload=function(){
        document.getElementById('maker-select').value = <?= $app['item_co']; ?>;
    }
</script>

@endsection
