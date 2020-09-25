@extends('layouts.nc_default')

{{--
@section('title')
Blog Posts
@endsection
--}}

@section('title','NC')

@section('content')

<!-- フラッシュメッセージ -->
@if (session('flash_message'))
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
	  {{ session('flash_message') }}
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
@endif

<?php if(isset($input->figure_id) && !session('flash_message')): ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  検索結果を表示しました。
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
<?php endif; ?>

<?php if(session('flash_good_message')): ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  {{ session('flash_good_message') }}
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
<?php endif; ?>

<form method="get" action="{{ route('estimates.confirm') }}">
<div class="f-container mt-4">
	<div class="f-item form-paper">
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h1>新規見積 作成</h1>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-3">
                            <label for="worker_id">
                                社員番号 (<?php if(isset($user->fullname)) echo $user->fullname; ?>)
                                @if ($errors->has('worker_id'))
                                    <span class="text-alert">{{$errors->first('worker_id')}}</span>
                                @endif
                            </label>
                            <input type="number" id="worker_id" class="form-control" max="9999" min = "1" maxlength='6' name="worker_id" placeholder="" value="<?php if(isset($user->employee_no)) echo $user->employee_no;?>" required readonly>
						</div>
					</div>
				</div>
				<div class="form-item mb-5 under-dashed-line-div">
					<div class="row d-flex align-items-end">
                        <div class="col-sm-4">
							<label for="customer-id">客先コード<span class="text-need">必須</span>
								@if ($errors->has('customer_id'))
									<span class="text-alert">{{$errors->first('customer_id')}}</span>
								@endif
							</label>
							<input type="number" id="customer_id" class="form-control" max="9999" min = "1" maxlength='6' name="customer_id" value="{{ old('customer_id', '107') }}">
						</div>
						<div class="col-sm-4">
							<label for="figure_id">図番<span class="text-need">必須</span>
								@if ($errors->has('figure_id'))
									<span class="text-alert">{{$errors->first('figure_id')}}</span>
								@endif
							</label>
							<input type="text" id="figure_id" class="form-control" maxlength='20' name="figure_id" value="<?php if(isset($input->figure_id)) echo $input->figure_id; else echo old('figure_id')?>" required>
						</div>
						<div class="col-sm-4 d-flex align-items-end">
							<button type="button" class="btn btn-secondary" onclick="jumpWithZuban()">検索</button>
						</div>
					</div>
				</div>

				<div class="form-item">
					<div class="row d-flex align-items-end">
						<div class="col-sm-4">
							<label for="count">個数<span class="text-need">必須</span>
								@if ($errors->has('quantity'))
									<span class="text-alert">{{$errors->first('quantity')}}</span>
								@endif
							</label>
							<input type="number" id="quantity" class="form-control" min='1' max='100000' maxlength='20' name="quantity" value="<?php if(!empty($input->quantity)) echo $input->quantity; else echo old('quantity', '1')?>" required>
						</div>
						<div class="col-sm-8"></div>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-4">
							<label for="material_width">幅 ( x[mm] )<span class="text-need">必須</span>
								@if ($errors->has('material_width'))
									<span class="text-alert">{{$errors->first('material_width')}}</span>
								@endif
							</label>
							<input type="number" id="material_width" class="form-control" max="100000" min="1" maxlength='20' name="material_width" value="<?php if(!empty($input->material_width)) echo $input->material_width; else echo old('material_width')?>" required>
						</div>
						<div class="col-sm-4">
							<label for="material_height">高さ ( y[mm] )<span class="text-need">必須</span>
								@if ($errors->has('material_height'))
									<span class="text-alert">{{$errors->first('material_height')}}</span>
								@endif
							</label>
							<input type="number" id="material_height" class="form-control" max="100000" min="1" maxlength='20' name="material_height" value="<?php if(!empty($input->material_height)) echo $input->material_height; else echo old('material_height')?>" required>
						</div>
						<div class="col-sm-4">
							<label for="material_depth">奥行き ( z[mm] )<span class="text-need">必須</span>
								@if ($errors->has('material_depth'))
									<span class="text-alert">{{$errors->first('material_depth')}}</span>
								@endif
							</label>
							<input type="text" id="material_depth" class="form-control" max="100000" min="1" maxlength='20' name="material_depth" value="<?php if(!empty($input->material_depth)) echo $input->material_depth; else echo old('material_depth')?>" required>
						</div>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-4">
							<label for="material_type">材質<span class="text-need">必須</span></label>
                            <select id="material_type" class="form-control" name="material_type">
                                <option value="Ss">鉄(SS400)</option>
                                <option value="Sus">ステン(SUS304)</option>
                                <option value="Al">アルミ(A5052)</option>
                            </select>
						</div>
						<div class="col-sm-4">
							<label for="material_cost">材料仕入れ価格<span class="text-need">必須</span>
								@if ($errors->has('material_cost'))
									<span class="text-alert">{{$errors->first('material_cost')}}</span>
								@endif</label>
							<input type="number" id="material_cost" class="form-control" max="10000000" min="0" maxlength='20' name="material_cost" value="<?php if(!empty($input->material_cost)) echo $input->material_cost; else echo old('material_cost','0')?>" required>
						</div>
						<div class="col-sm-4 d-flex align-items-end">
							<div>
								<input class="form-check-input" type="checkbox" id="is_temporary_material_cost" name="is_temporary_material_cost" value="929">
								<label class="form-check-label" for="is_temporary_material_cost">仮の材料価格
	                                @if ($errors->has('is_temporary_material_cost'))
	                                    <span class="text-alert">{{$errors->first('is_temporary_material_cost')}}</span>
	                                @endif</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-4">
							<label for="change_count">持ち替え回数<span class="text-need">必須</span>
								@if ($errors->has('change_count'))
									<span class="text-alert">{{$errors->first('change_count')}}</span>
								@endif</label>
							<input type="number" id="change_count" class="form-control" max="10" min="1" maxlength='20' name="change_count" value="<?php if(!empty($input->change_count)) echo $input->change_count; else echo old('change_count', '1')?>" required>
						</div>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-4">
							<label for="coding_time">コーディング時間[分]<span class="text-need">必須</span>
                                @if ($errors->has('coding_time'))
	                                <span class="text-alert">{{$errors->first('coding_time')}}</span>
                                @endif</label>
							<input type="number" id="coding_time" class="form-control" max="1000" min="0" maxlength='20' name="coding_time" value="<?php if(!empty($input->coding_time)) echo $input->coding_time; else echo old('coding_time')?>" required>
						</div>

						<div class="col-sm-4">
							<label for="dry_run_time">ドライラン時間[分]<span class="text-need">必須</span>
								@if ($errors->has('dry_run_time'))
                                    <span class="text-alert">{{$errors->first('dry_run_time')}}</span>
                                @endif
							</label>
							<input type="number" id="dry_run_time" class="form-control" max="1000" min="0" maxlength='20' name="dry_run_time" value="<?php if(!empty($input->dry_run_time)) echo $input->dry_run_time; else echo old('dry_run_time')?>" required>
						</div>

						<div class="col-sm-4">
							<label for="jig_creation_time">治具作成時間[分]<span class="text-need">必須</span>
								@if ($errors->has('jig_creation_time'))
                                    <span class="text-alert">{{$errors->first('jig_creation_time')}}</span>
                                @endif
							</label>
							<input type="text" id="jig_creation_time" class="form-control" max="1000" min="0" maxlength='20' name="jig_creation_time"  value="<?php if(!empty($input->jig_creation_time)) echo $input->jig_creation_time; else echo old('jig_creation_time', '0')?>" required>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section-create-estimate-info">
			<div class="container">

				<div class="process-form-item">
					<div class="row">
						<div class="col-sm-12">
							<h2>
								登録加工工程
								<span class="small-h2-font"><a href="{{ route('machiningtools.index') }}" target="_blank">工具一覧<i class="fas fa-tools"></i></a></span>
							</h2>
						</div>
					</div>
					<div class="row d-flex mb-2 mb-2">
						<div class="col-sm-1"></div>

						<div class="col-sm-2 process-column">
							<p class="bigger-p">エンドミル</p>
							<div class="process-row">
								<label for="endmill_type">種類</label>
								<select id="endmill_type" class="form-control endmill" name="endmill_type">
									@foreach($endmills as $endmill)
										<option value="{{ $endmill->diameter }}">{{ $endmill->endmill_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="process-row">
								<label for="text1">距離 [mm]</label>
								<input type="number" id="endmill_distance" class="form-control" min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<label for="endmill_depth">深さ [mm]</label>
								<input type="number" id="endmill_depth" class="form-control" min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<label for="endmill_depth_onetime">深さ/1回 [mm]</label>
								<input type="number" id="endmill_depth_onetime" class="form-control" min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<button type="button" class="btn btn-outline-secondary process-add-btn" data-processtype="endmill">登録</button>
							</div>
						</div>

						<div class="col-sm-2 process-column">
							<p class="bigger-p">ドリル</p>
							<div class="process-row">
								<label for="dril_diameter">穴径 [mm]</label>
								<input type="number" id="dril_diameter" class="form-control" min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<label for="dril_depth">深さ [mm]</label>
								<input type="number" id="dril_depth" class="form-control" min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<label for="dril_count">個数</label>
								<input type="number" id="dril_count" class="form-control" min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
							</div>
							<div class="process-row">
								<button type="button" class="btn btn-outline-secondary process-add-btn" data-processtype="dril">登録</button>
							</div>
						</div>

						<div class="col-sm-2 process-column">
							<p class="bigger-p">ねじ切り</p>

							<div class="process-row">
								<label for="screw_diameter">ねじ径 [mm]</label>
	                            <select id="screw_diameter" class="form-control" name="screw_diameter">
									@foreach($screws as $screw)
	                                <option value="{{ $screw->diameter }}">{{ $screw->diameter }}</option>
									@endforeach
	                            </select>
							</div>
							<div class="process-row">
								<label for="screw_depth">深さ [mm]</label>
								<input type="number" id="screw_depth" class="form-control" min='1' max='10000'maxlength='20'>
							</div>
							<div class="process-row">
								<label for="screw_count">個数</label>
								<input type="number" id="screw_count" class="form-control" min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="screw_stop" name="screw_stop" value="true" >
									<label class="form-check-label" for="screw_stop">止まり穴</label>
								</div>
							</div>
							<div class="process-row">
								<p>該当タップがなければスパイラルタップを使用</p>
							</div>
							<div class="process-row">
								<button type="button" class="btn btn-outline-secondary process-add-btn" data-processtype="screw">登録</button>
							</div>
						</div>

						<div class="col-sm-2 process-column">
							<p class="bigger-p">C面取り</p>
							<div class="process-row">
								<label for="chamfer_size">C</label>
								<input type="number" id="chamfer_size" class="form-control"  min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<label for="chamfer_distance">距離</label>
								<input type="number" id="chamfer_distance" class="form-control" min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="chamfer_thunder" name="without_bankin" value="true">
									<label class="form-check-label" for="chamfer_thunder">サンダー</label>
								</div>
							</div>
							<div class="process-row">
								<label for="chamfer_count">個数</label>
								<input type="number" id="chamfer_count" class="form-control" maxlength='20'>
							</div>
							<div class="process-row">
								<button type="button" class="btn btn-outline-secondary process-add-btn" data-processtype="chamfer">登録</button>
							</div>
						</div>

						<div class="col-sm-2">
							<p class="bigger-p">座ぐり</p>
							<div class="process-row">
								<label for="counterboring_diameter">穴径 [mm]</label>
								<input type="number" id="counterboring_diameter" class="form-control" min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<label for="counterboring_depth">深さ [mm]</label>
								<input type="number" id="counterboring_depth" class="form-control"  min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<label for="counterboring_count">個数</label>
								<input type="number" id="counterboring_count" class="form-control"  min='1' max='10000' maxlength='20'>
							</div>
							<div class="process-row">
								<button type="button" class="btn btn-outline-secondary process-add-btn" data-processtype="counterboring">登録</button>
							</div>
							<div clas
							s="process-row">

							</div>
						</div>
						<div class="col-sm-1"></div>
					</div>

				</div>
			</div>
		</section>



		<section>
			<div class="container">
				<div class="form-item">
					<div class="row">
						<div class="col-sm-10 d-flex align-items-end">
							<h2>登録済み加工工程
                                @if ($errors->has('register_process'))
	                                <span class="text-alert">{{$errors->first('register_process')}}</span>
	                            @endif
							</h2>
							<p class="mb-2 ml-3 fake-a" id="register-reset"><i class="fas fa-angle-double-left"></i>リセット</p>
							<p class="mb-2 ml-3 fake-a" id="register-one-return"><i class="fas fa-angle-left"></i>1つ戻る</p>
						</div>
						<div class="col-sm-2"></div>
					</div>
					<div class="row">
						<div class="col-sm-10">
							<input type="text" id="" class="form-control" maxlength='50' placeholder="" value="例) 種類, 直径, 距離, 深さ, 一回当たりの深さ, 個数, 止まり穴, C, サンダー" disabled>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.0') }}" readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.1') }}" readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.2') }}" readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.3') }}" readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.4') }}" readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.5') }}" readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.6') }}" readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.7') }}" readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.8') }}" readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value="{{ old('register_process.9') }}" readonly>
						</div>
						<div class="col-sm-2"></div>
					</div>
				</div>
			</div>
		</section>
		<section>
			<div class="container">
				<div class="row mt-3">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-primary">見積作成</button>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
</form>

<script type="text/javascript" src="{{asset('/js/estimate_create.js')}}"></script>
<script type="text/javascript" >

	//材料セレクタの設定
	var material_select = document.getElementById("material_type");
	var options = material_select.options;
	var option_value = "<?php if(isset($input->material_type)) echo $input->material_type; else echo old('material_type', 'Ss'); ?>";
	for(let i = 0; i < options.length; i++){
		if(options[i].value == option_value){
			options[i].selected = true;
			break;
		}
	}

	//仮の材料費かとうかチェックボックスの設定
	var is_temporary_material_cost = <?php if(isset($input->is_temporary_material_cost)) echo $input->is_temporary_material_cost; else echo '0';?>;
	var material_cost_check = document.getElementById("is_temporary_material_cost");
	if(is_temporary_material_cost){
		material_cost_check.checked = true;
	}else{
		material_cost_check.checked = false;
	}

	//図番検索のリンク
	function jumpWithZuban(){
		var figure_id_inputs = document.getElementsByName("figure_id");
		var figure_id = figure_id_inputs[0].value;
		location.href = "{{ route('estimates.create') }}"+"?figure_id="+figure_id;
	}
</script>
@endsection
