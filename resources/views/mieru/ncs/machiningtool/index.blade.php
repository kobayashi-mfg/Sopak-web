@extends('layouts.nc_default')



@section('title','NC')

@section('content')

@if (session('flash_message'))
	<div class="alert alert-success  alert-dismissible fade show" role="alert">
	  {{ session('flash_message') }}
	  <button type="submit" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
@endif

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p class="small-h2-font"><a href="{{ route('estimates.create') }}">新規見積作成へもどる</a></p>
            </div>
        </div>
		<div class="row">
			<div class="col-sm-12">
				<h1>
                    工具一覧
                </h1>
			</div>
		</div>
    </div>
</section>

<form method="get" action="{{ route('machiningtools.create') }}">
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    エンドミル(endmill)
                    <span class="small-h2-font"><button type="submit" name="tool_type" class="btn btn-link small-h2-font fake-a" name="tool_type" value="endmill"><i class="fas fa-plus-square"></i></button></span>
                </h2>
            </div>
        </div>
        <div class="row narrow-detail-table">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>直径</th>
                            <th>名前</th>
                            <th>溝切削回転速度(SS)</th>
                            <th>溝切削回転速度(SUS)</th>
                            <th>溝切削回転速度(Al)</th>
                            <th>溝切削送り速度(SS)</th>
                            <th>溝切削送り速度(SUS)</th>
                            <th>溝切削送り速度(Al)</th>
                            <th>側面切削回転速度(SS)</th>
                            <th>側面切削回転速度(SUS)</th>
                            <th>側面切削回転速度(Al)</th>
                            <th>側面切削送り速度(SS)</th>
                            <th>側面切削送り速度(SUS)</th>
                            <th>側面切削送り速度(Al)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($endmills as $endmill)
                            <tr>
                                <td>{{ $endmill->diameter }}</td>
                                <td>{{ $endmill->endmill_name }}</td>
                                <td>{{ $endmill->ss_grooving_rotation }}</td>
                                <td>{{ $endmill->sus_grooving_rotation }}</td>
                                <td>{{ $endmill->al_grooving_rotation }}</td>
                                <td>{{ $endmill->ss_grooving_feeding }}</td>
                                <td>{{ $endmill->sus_grooving_feeding }}</td>
                                <td>{{ $endmill->al_grooving_feeding }}</td>
                                <td>{{ $endmill->ss_sideface_rotation }}</td>
                                <td>{{ $endmill->sus_sideface_rotation }}</td>
                                <td>{{ $endmill->al_sideface_rotation }}</td>
                                <td>{{ $endmill->ss_sideface_feeding }}</td>
                                <td>{{ $endmill->sus_sideface_feeding }}</td>
                                <td>{{ $endmill->al_sideface_feeding }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    ドリル(dril)
                    <span class="small-h2-font"><button type="submit" name="tool_type" class="btn btn-link small-h2-font fake-a" value="dril"><i class="fas fa-plus-square"></i></button></span>
                </h2>
            </div>
        </div>
        <div class="row narrow-detail-table">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>工具径</th>
                            <th>回転速度(SS)</th>
                            <th>回転速度(SUS)</th>
                            <th>回転速度(Al)</th>
                            <th>送り速度(SS)</th>
                            <th>送り速度(SUS)</th>
                            <th>送り速度(Al)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($drils as $dril)
                            <tr>
                                <td>{{ $dril->diameter }}</td>
                                <td>{{ $dril->ss_rotation }}</td>
                                <td>{{ $dril->sus_rotation }}</td>
                                <td>{{ $dril->al_rotation }}</td>
                                <td>{{ $dril->ss_feeding }}</td>
                                <td>{{ $dril->sus_feeding }}</td>
                                <td>{{ $dril->al_feeding }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    ねじ切り(screw)
                    <span class="small-h2-font"><button type="submit" name="tool_type" class="btn btn-link small-h2-font fake-a" value="screw"><i class="fas fa-plus-square"></i></button></span>
                </h2>
            </div>
        </div>
        <div class="row narrow-detail-table">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>径</th>
                            <th>ピッチ</th>
                            <th>下穴径</th>
                            <th>止まり穴かどうか</th>
                            <th>ポイントタップ回転速度(SS)</th>
                            <th>ポイントタップ回転速度(SUS)</th>
                            <th>ポイントタップ回転速度(Al)</th>
                            <th>スクリュータップ回転速度(SS)</th>
                            <th>スクリュータップ回転速度(SUS)</th>
                            <th>スクリュータップ回転速度(Al)</th>
                            <th>センタードリル送り速度(SS)</th>
                            <th>センタードリル送り速度(SUS)</th>
                            <th>センタードリル送り速度(Al)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($screws as $screw)
                            <tr>
                                <td>{{ $screw->diameter }}</td>
                                <td>{{ $screw->pich }}</td>
                                <td>{{ $screw->pilot_hole_diameter }}</td>
                                <td>{{ $screw->is_blind_hole }}</td>
                                <td>{{ $screw->ss_point_rotation }}</td>
                                <td>{{ $screw->sus_point_rotation }}</td>
                                <td>{{ $screw->al_point_rotation }}</td>
                                <td>{{ $screw->ss_spiral_rotation }}</td>
                                <td>{{ $screw->sus_spiral_rotation }}</td>
                                <td>{{ $screw->al_spiral_rotation }}</td>
                                <td>{{ $screw->ss_center_dril_feeding }}</td>
                                <td>{{ $screw->sus_center_dril_feeding }}</td>
                                <td>{{ $screw->al_center_dril_feeding }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    C面取り(chamfer)
                    <span class="small-h2-font"><button type="submit" name="tool_type" class="btn btn-link small-h2-font fake-a" value="chamfer"><i class="fas fa-plus-square"></i></button></span>
                </h2>
            </div>
        </div>
        <div class="row narrow-detail-table">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>工具名</th>
                            <th>回転速度(SS)</th>
                            <th>回転速度(SUS)</th>
                            <th>回転速度(Al)</th>
                            <th>送り速度(SS)</th>
                            <th>送り速度(SUS)</th>
                            <th>送り速度(Al)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chamfers as $chamfer)
                            <tr>
                                <td>{{ $chamfer->tool_name }}</td>
                                <td>{{ $chamfer->ss_rotation }}</td>
                                <td>{{ $chamfer->sus_rotation }}</td>
                                <td>{{ $chamfer->al_rotation }}</td>
                                <td>{{ $chamfer->ss_feeding }}</td>
                                <td>{{ $chamfer->sus_feeding }}</td>
                                <td>{{ $chamfer->al_feeding }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</form>


@endsection
