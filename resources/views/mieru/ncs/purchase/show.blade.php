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
                        <h1>購入申請詳細 <span class="small-h2-font">{{$status}}</span></h1>
                    </div>
                </div>

                    <div class="form-item"style="display:none;" >
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="select1a">申請番号</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="number" id="text1" class="form-control" max="999999" min = "0" maxlength='6' name="app_id" value=<?= $app['id']; ?> readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="select1a">工程</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <select id="select1a" class="form-control" name="kotei"readonly>
                                    <option>機械加工</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">メーカー</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" id="text1" class="form-control" maxlength='20' name="maker" placeholder="例) アマダ" value="<?= $app['item_co'];?>" required readonly>
                                <input type="text" id="text1" class="form-control" maxlength='20' name="maker" placeholder="例) アマダ" value="<?= $supplier;?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">品名</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" id="text1" class="form-control" maxlength='20' name="hinmei" placeholder="例) 掘削ドリル" value="<?= $app['item_name'];?>"required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">型番</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" id="text1" class="form-control" maxlength='20' name="kataban" placeholder="例) 25T894" value="<?= $app['item_id'];?>" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">数量</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="number" id="text1" class="form-control" maxlength='20' name="suuryou" value="<?= $app['quantity'];?>" value="<?= $app['quantity'];?>" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">合計金額</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="number" id="text1" class="form-control" maxlength='20' name="kingaku" placeholder="例) 100000" value="<?= $app['price'];?>" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">備考(使用用途、リンクなど)</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea class="form-control" maxlength='300' cols="40" rows="3" name="biko" readonly><?= $app['biko'];?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{ route('purchases.edit', $app['id']) }}"><button type="submit" class="btn btn-outline-primary">編集</button></a>
                        </div>
                    </div>

            </div>
        </section>
    </div>
</div>

@endsection
