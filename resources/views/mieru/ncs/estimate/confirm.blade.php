@extends('layouts.nc_default')



@section('title','NC')

@section('content')


<form method="post" action="{{ route('estimates.store') }}">
{{csrf_field()}}

<div class="f-container mt-4">
	<div class="f-item form-paper">
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h1>新規見積 <span class="confirm-title">確認</span></h1>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-3">
                            <label for="worker_id">
                                社員番号 (<?php if(isset($user->fullname)) echo $user->fullname; ?>)
                                @if ($errors->has('worker_id'))
                                    <span class="error">{{$errors->first('worker_id')}}</span>
                                @endif
                            </label>
                            <input type="number" id="worker_id" class="form-control" max="9999" min = "1" maxlength='6' name="worker_id" placeholder="" value="<?php if(isset($user->employee_no)) echo $user->employee_no;?>"  readonly>
						</div>
					</div>
				</div>
				<div class="form-item mb-5">
					<div class="row d-flex align-items-end">
                        <div class="col-sm-4">
							<label for="customer-id">客先コード</label>
							<input type="number" id="customer_id" class="form-control" max="9999" min = "1" maxlength='6' name="customer_id" value="<?= $input->customer_id;?>" required readonly>
						</div>
						<div class="col-sm-4">
							<label for="figure_id">図番</label>
							<input type="text" id="figure_id" class="form-control" maxlength='20' name="figure_id" value="<?= $input->figure_id;?>" required readonly>
						</div>
						<div class="col-sm-4">
						</div>
					</div>
					<div class="form-item">
						<div class="row d-flex align-items-end">
							<div class="col-sm-4">
								<label for="before_time">加工前準備時間 [分]</label>
								<input type="number" id="before_time" class="form-control" min='0' max='100000' maxlength='20' name="before_time" value="<?= $time['before_time'];?>" disabled>
							</div>
							<div class="col-sm-4">
								<label for="manufacturing_time">加工時間 [分]</label>
								<input type="number" id="manufacturing_time" class="form-control" min='0' max='100000' maxlength='20' name="manufacturing_time" value="<?= $time['manufacturing_time'];?>" required readonly>
							</div>
							<div class="col-sm-4">
								<label for="total_time">総合計時間 [分]</label>
								<input type="number" id="total_time" class="form-control" min='1' max='100000' maxlength='20' name="total_time" value="<?= $time['total_time'];?>" required readonly>
							</div>
						</div>
					</div>
				</div>


				<div class="form-item">
					<div class="row d-flex align-items-end">
						<div class="col-sm-4">
							<label for="quantity">個数</label>
							<input type="number" id="quantity" class="form-control" min='1' max='100000' maxlength='20' name="quantity" value="<?= $input->quantity;?>" required readonly>
						</div>
						<div class="col-sm-4">
							<label for="unit_price">単価 (1つ注文した場合の値段)</label>
							<input type="number" id="unit_price" class="form-control" min='1' max='100000' maxlength='20' name="unit_price" value="<?= $price['one_price'];?>" required readonly>
						</div>
						<div class="col-sm-4">

						</div>
					</div>
				</div>

				<div class="form-item">
					<div class="row d-flex align-items-end">
						<div class="col-sm-4">
							<label for="total_price">合計額</label>
							<input type="number" id="total_price" class="form-control input-stressed" min='1' max='10000000' maxlength='20' name="total_price" value="<?= $price['total_price'];?>" required readonly>
						</div>
						<div class="col-sm-4">
							<label for="adjusted_price">修正値段</label>
							<input type="number" id="adjusted_price" class="form-control" min='0' max='10000000' maxlength='20' name="adjusted_price">
						</div>
						<div class="col-sm-4">
							<label for="adjustment_reason">修正理由</label>
							<input type="text" id="adjustment_reason" class="form-control" maxlength='150' name="adjustment_reason" value="">
						</div>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-12  d-flex justify-content-start">
							<button type="submit" class="btn  btn-link fake-a mr-3" name="goto_cancel" value="1">キャンセル</button>
							<button type="submit" class="btn btn-primary">確定</button>
							<!-- おそらくキャンセルボタンを押すとhiddenのinputに値を入れてpostして、中身をみて基に戻す処理を行う -->
							<!-- <div class="ml-3 d-flex align-items-center">
								<p style="margin:0;"><a href="{{ route('users.index') }}">キャンセル</a></p>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section-create-estimate-info">
			<div class="container">
				<div class="form-item">
					<div class="row mb-2">
						<div class="col-sm-12">
							<h2 class="light-gray-font">詳細</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label for="material_width">幅 ( x[mm] )</label>
							<input type="number" id="material_width" class="form-control" max="100000" min="1" maxlength='20' name="material_width" value="<?= $input->material_width;?>" required readonly>
						</div>
						<div class="col-sm-4">
							<label for="material_height">高さ ( y[mm] )</label>
							<input type="number" id="material_height" class="form-control" max="100000" min="1" maxlength='20' name="material_height" value="<?= $input->material_height;?>" required readonly>
						</div>
						<div class="col-sm-4">
							<label for="material_depth">奥行き ( z[mm] )</label>
							<input type="text" id="material_depth" class="form-control" max="100000" min="1" maxlength='20' name="material_depth" value="<?= $input->material_depth;?>" required readonly>
						</div>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-4">
							<label for="material_type">材質</label>
                            <select id="material_type" class="form-control" name="material_type" readonly>
                                <option value="Ss">鉄(SS400)</option>
                                <option value="Sus">ステン(SUS304)</option>
                                <option value="Al">アルミ(A5052)</option>
                            </select>
						</div>
						<div class="col-sm-4">
							<label for="material_cost">材料仕入れ価格</label>
							<input type="number" id="material_cost" class="form-control" max="10000000" min="0" maxlength='20' name="material_cost" value="<?=$input->material_cost;?>" required readonly>
						</div>
						<div class="col-sm-4 d-flex align-items-end">
							<div>
								<label class="form-check-label" for="is_temporary_material_cost">仮の材料価格か？</label>
								<input class="form-control" type="text" id="is_temporary_material_cost" name="is_temporary_material_cost" value="<?php if($input->is_temporary_material_cost > 0 ) echo true; else echo false ?>" readonly>
							</div>
						</div>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-4">
							<label for="change_count">持ち替え回数</label>
							<input type="number" id="change_count" class="form-control" max="10" min="1" maxlength='20' name="change_count" value="<?=$input->change_count; ?>" required readonly>
						</div>
					</div>
				</div>
				<div class="form-item">
					<div class="row">
						<div class="col-sm-4">
							<label for="coding_time">コーディング時間[分]</label>
							<input type="number" id="coding_time" class="form-control" max="1000" min="0" maxlength='20' name="coding_time" value="<?= $input->coding_time;?>" required readonly>
						</div>

						<div class="col-sm-4">
							<label for="dry_run_time">ドライラン時間[分]</label>
							<input type="number" id="dry_run_time" class="form-control" max="1000" min="0" maxlength='20' name="dry_run_time" value="<?= $input->dry_run_time;?>" required readonly>
						</div>

						<div class="col-sm-4">
							<label for="jig_creation_time">治具作成時間[分]</label>
							<input type="text" id="jig_creation_time" class="form-control" max="1000" min="0" maxlength='20' name="jig_creation_time"  value="<?=$input->jig_creation_time; ?>" required readonly>
						</div>
					</div>
				</div>

				<div class="form-item">
					<div class="row">
						<div class="col-sm-10 d-flex align-items-end">
							<h2 class="light-gray-font">登録済み加工工程</h2>
							<!-- <p class="mb-2 ml-3 fake-a" id="register-reset">&laquo;&nbsp;リセット</p>
							<p class="mb-2 ml-3 fake-a" id="register-one-return">&lt;&nbsp;1つ戻る</p> -->
						</div>
						<div class="col-sm-2"></div>
					</div>
					<div class="row">
						<div class="col-sm-10">
							<input type="text" id="" class="form-control" maxlength='50' placeholder="" value="例) 種類, 直径, 距離, 深さ, 一回当たりの深さ, 個数, 止まり穴, C, サンダー" disabled>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[0]; ?>'  readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[1]; ?>' readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[2]; ?>' readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[3]; ?>' readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[4]; ?>' readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[5]; ?>' readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[6]; ?>' readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[7]; ?>' readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[8]; ?>' readonly>
							<input type="text" id="" class="form-control process-input" maxlength='50' name="register_process[]" placeholder="" value='<?= $input->register_process[9]; ?>' readonly>
						</div>
						<div class="col-sm-2"></div>
					</div>
				</div>
			</div>
		</section>
		<section>
			<div class="container">
				<div class="form-item">
					<div class="row">
						<div class="col-sm-12">
							<button type="submit" class="btn  btn-link fake-a mr-3" name="goto_cancel" value="1">キャンセル</button>
							<button type="submit" class="btn btn-primary">確定</button>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
</form>


<script>

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

</script>


@endsection
