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
                            <h1>購入申請承認 <span class="small-h2-font"><?= $status_msg[$app['status']];?></span></h1>
                        </div>
                    </div>


                        <!-- <div class="form-item" >
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>申請番号: <span class="bigger-p"><?= $app['id']; ?></span></p>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>工程: <span class="bigger-p">機械加工</span></p>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>社員名: <span class="bigger-p">{{ $worker['worker_name'] }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>メーカー: <span class="bigger-p">{{ $supplier }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>品名: <span class="bigger-p"><?= $app['item_name'];?></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>型番: <span class="bigger-p"><?= $app['item_id'];?></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>数量: <span class="bigger-p"><?= $app['quantity'];?></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p >金額: <span class="bigger-p"><?= number_format((float)$app['price']);?>円</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>備考: <span class="bigger-p"><?= $app['biko'];?></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>状態: <span class="bigger-p"><?= $status_msg[$app['status']];?></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 d-flex justify-content-start">
                                <form action="{{route('purchases.update_status', $app['id'] )}}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('patch') }}
                                    @can('admin-higher')
                                        <button type="submit" class="btn btn-outline-dark mr-3" name="status" value="1">申請中へもどす</button>
                                    @endcan
                                    <button type="submit" class="btn btn-secondary mr-3" name="status" value="0"><i class="fas fa-trash"></i></button>
                                    <button type="submit" class="btn btn-dark mr-3" name="status" value="3">受取</button>
                                    @can('admin-higher')
                                        <button type="submit" class="btn btn-primary" name="status" value="2">承認</button>
                                    @endcan
                                </form>
                            </div>
                        </div>
                </div>
            </section>
        </div>
    </div>

@endsection
