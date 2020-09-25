@extends('layouts.mieru_nc_default')

{{--
@section('title')
Blog Posts
@endsection
--}}

@section('title','NC')

@section('content')

{{--
<section >
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3>収支</h3>
			</div>
			<div class="col-sm-12">
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th>売上</th>
							<th>費用</th>
							<th>利益</th>
							<th>利益率[%]</th>
						</tr>
					</thead>
					<tbody>

						<tr>
							<td>見積</td>
							<!-- <td><?=  $total_money['sales']; ?></td> -->
							<td><?=  number_format((float)$total_money['sales']); ?></td>
							<td><?= number_format((float)$total_money['expense']); ?></td>
							<td><?= number_format((float)$total_money['profit']); ?></td>
							<td><?= $total_money['profit_rate']; ?></td>
						</tr>

						<tr>
							<td>実際</td>
							<!-- <td><?=  $total_money['sales']; ?></td> -->
							<td><?=  number_format((float)$total_money['real_sales']); ?></td>
							<td></td>
							<td><?= number_format((float)$total_money['real_profit']); ?></td>
							<td><?= $total_money['real_profit_rate']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<h3>費用詳細</h3>
			</div>
			<div class="col-sm-12">
				<table class="table">
					<!-- 利益profit = 売上(材料費抜き済)sales - 人件費labour - 原価償却費(工具費用+材料費ってことになっているが工具費用のこと)depreciation - その他other, 　expense=費用 -->
					<thead>
						<tr>
							<th>材料費</th>
							<th>人件費</th>
							<th>減価償却費</th>
							<th>その他費用</th>
							<th>費用計</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= number_format((float)$total_money['material']); ?></td>
							<td><?= number_format((float)$total_money['labour']); ?></td>
							<td><?= number_format((float)$total_money['depreciation']); ?></td>
							<td><?= number_format((float)$total_money['other']); ?></td>
							<td><?= number_format((float)$total_money['expense']); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
--}}


<section class="section-sales-trend">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2>
					売上推移
					<span class="small-h2-font">
						(累計収支
						: <?= number_format((float)$total_money['profit']); ?>円)
						<a href="#" class="tooltip-a" data-toggle="tooltip" data-placement="right" data-original-title="機械加工事業開始日からの見積額を使用した収支">
							<i class="fas fa-info-circle"></i>
						</a>
					</span>

				</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<canvas id="total-product-count_chart">
			        Canvas not supported
			    </canvas>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<form method="get" action="{{ route('mieru.ncs.index') }}">
            {{ csrf_field() }}
			<div class="row" style="margin-bottom:10px;">

				<div class="col-sm-3">
					<label class="col-form-label">開始日</label>
					<input class="form-control" type="date" value="<?= $setting->startday;?>" name="startday">
				</div>
				<div class="col-sm-3">
					<label class="col-form-label">終了日</label>
					<input class="form-control" type="date" value="<?= $setting->finishday;?>" name="finishday">
				</div>
				<div class="col-sm-6 d-flex flex-column align-items-start justify-content-end">
					<p class="mb-1">表示間隔</p>
					<div class="btn-group btn-group-toggle" data-toggle="buttons">

						<label class="btn btn-outline-secondary">
							<input type="radio" name="display_interval" value = "month" <?= $setting->display_interval == "month"? 'checked':'' ;?>> 月
						</label>

						<label class="btn btn-outline-secondary">
							<input type="radio" name="display_interval" value = "day" <?= $setting->display_interval == "day"? 'checked':'' ;?>> 日
						</label>
					</div>
				</div>
			</div>
			<div class="row mt-3 mb-2">
				<div class="col-sm-12">
					<div class="form-check">
					  <input class="form-check-input" type="checkbox" id="check_exclude_bankin" name="without_bankin" value="true" <?=  $setting->without_bankin == "true"? 'checked':'' ;?>>
					  <label class="form-check-label" for="check_exclude_bankin">
						  機械加工のみの製品で絞込む
							<a href="#" class="tooltip-a" data-toggle="tooltip" data-placement="right" data-original-title="制作製品数グラフには反映されない">
								<i class="fas fa-info-circle"></i>
							</a>
	  					</span>
					  </label>
					</div>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-sm-6">
					<a href="{{ route('mieru.ncs.index') }}"><button class="btn btn-outline-secondary" type="button">今月分を表示</button></a>
					<button type="submit" class="btn btn-primary ml-2">絞込<i class="fas fa-filter"></i></button>
				</div>
				<div class="col-sm-6"></div>
			</div>
		</form>
	</div>
</section>

<section class = "top-section">
	<div class="container">
		<div class="row mb-1">
			<div class="col-sm-12">
				<h2>粗利</h2>
			</div>
		</div>



		<div class="row">
			<div class="col-sm-12">
				<h3>収支</h3>
			</div>
			<div class="col-sm-12">
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th>売上</th>
							<th>費用</th>
							<th>利益</th>
							<th>利益率(見積)[%]</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>見積</td>
							<!-- <td><?=  $money['sales']; ?></td> -->
							<td><?= number_format((float)$money['sales']); ?></td>
							<td><?= number_format((float)$money['expense']); ?></td>
							<td><?= number_format((float)$money['profit']); ?></td>
							<td><?= $money['profit_rate']; ?></td>
						</tr>

						<tr>
							<td>実際</td>
							<!-- <td><?=  $money['sales']; ?></td> -->
							<td><?=  number_format((float)$money['real_sales']); ?></td>
							<td></td>
							<td><?= number_format((float)$money['real_profit']); ?></td>
							<td><?= $money['real_profit_rate']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<h3>費用詳細</h3>
			</div>
			<div class="col-sm-12">
				<table class="table">
					<!-- 利益profit = 売上(材料費抜き済)sales - 人件費labour - 原価償却費(工具費用+材料費ってことになっているが工具費用のこと)depreciation - その他other, 　expense=費用 -->
					<thead>
						<tr>
							<th>材料費</th>
							<th>人件費</th>
							<th>減価償却費</th>
							<th>その他費用</th>
							<th>費用計</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= number_format((float)$money['material']); ?></td>
							<td><?= number_format((float)$money['labour']); ?></td>
							<td><?= number_format((float)$money['depreciation']); ?></td>
							<td><?= number_format((float)$money['other']); ?></td>
							<td><?=  number_format((float)$money['expense']); ?></td>
						</tr>
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
					制作製品数
					<span class="small-h2-font">
						(合計: <?= $product_total; ?>個)
						<a href="#" class="tooltip-a" data-toggle="tooltip" data-placement="right" data-original-title="機械加工機作動時間より算出した製品制作個数">
							<i class="fas fa-info-circle"></i>
						</a>
					</span>
				</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<canvas id="product-count_chart">
			        Canvas not supported
			    </canvas>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2>
					作業時間
					<span class="small-h2-font">
						(合計:<?= $work_time_total; ?>分)
						<a href="#" class="tooltip-a" data-toggle="tooltip" data-placement="right" data-original-title="作業台帳および機械加工機稼働時間を使用">
							<i class="fas fa-info-circle"></i>
						</a>
					</span>
				</h2>
			</div>
			<div class="col-sm-12">
				<canvas id="working-time_chart">
			        Canvas not supported
			    </canvas>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2>製造台帳</h2>
			</div>
		</div>
		<div class="row detail-table">
			<div class="col-sm-12">
				<table class="table">
					<thead>
						<tr>
							<th>機械加工終了日</th>
							<th>会社名</th>
							<th>製造番号</th>
							<th>製品名</th>
							<th>図版</th>

							<th>制作数量</th>

							<th>見積</th>
							<th>売上</th>
							<th>材料費</th>
							<th>費用</th>
							<th>利益率(見積)[%]</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($packing_list as $item): ?>
							<tr>
								<td><?= $item[0];?></td>
								<td><?= $item[1];?></td>
								<td><?= $item[2];?></td>
								<td><?= $item[3];?></td>
								@if(is_null($item[4]))
									<td><a href="" target="_blank"><?= $item[4];?></td>
								@else
									<td><a href="{{ route('mieru.ncs.show', $item[4]) }}" target="_blank"><?= $item[4];?></td>
								@endif
								<td><?= $item[5];?></td>
								<td><?= number_format((float) $item[6]);?></td>
								<td><?= number_format((float) $item[7]);?></td>
								<td><?= number_format((float) $item[8]);?></td>
								<td><?=  $item[9];?></td>
								<td><?= $item[10];?></td>
								<!-- <td></td> -->
							</tr>
						<?php endforeach; ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script type="text/javascript" src="https://github.com/nagix/chartjs-plugin-colorschemes/releases/download/v0.2.0/chartjs-plugin-colorschemes.min.js"></script>
<script src="{{asset('/js/main.js')}}"></script>
<!-- 時間間隔選択ラジオボタン用 -->
<script type="text/javascript">
	window.onload=function(){
		var checked_radio = "";
		var radio = document.getElementsByName("display_interval");

		for (var i = 0; i < radio.length; i++){
			if(radio[i].checked){
				checked_radio = radio[i];
				break;
			}
		}
		var label = checked_radio.parentNode;
		label.classList.add('active');
	}
</script>

<script >
	(function() {
		'use strict';

		var days_array=[];

		var data_2nd = <?php echo json_encode($total_sale_each_month, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
		var data_arr =[];

		for(var key in data_2nd){
			let hiduke = key.split('-');
			let show = hiduke[1] + "/" + hiduke[2];
			days_array.push(show);
			data_arr.push(data_2nd[key]);
		}

		var type = 'bar';

		var data = {
		labels: days_array,
		datasets: [{
			label: '見積売上',
			data: data_arr,

			borderWidth: 0
		}
		],
		};

		var options = {
			scales: {
				yAxes: [
				{
				  ticks: {
				    beginAtZero: true,
				    min: 0
				  }
				}
				]
			},
			plugins: {
				colorschemes: {
					scheme: 'brewer.Paired3'
				}
		    },
			animation: {
	            duration: 0, // 一般的なアニメーションの時間
	        },
	        hover: {
	            animationDuration: 0, // アイテムのマウスオーバー時のアニメーションの長さ
	        },
	        responsiveAnimationDuration: 0, // サイズ変更後のアニメーションの長さ
		};

		var ctx = document.getElementById('total-product-count_chart').getContext('2d');
		ctx.canvas.height = 50;
		var chart = new Chart(ctx, {
			type: type,
			data: data,
			options: options
		});
	})();
</script>

<script >
	(function() {
		'use strict';

		var days_array=[];

		var data_2nd = <?php echo json_encode($made_products_count, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
		var data_arr =[];

		for(var key in data_2nd){
			let hiduke = key.split('-');
			let show = hiduke[1] + "/" + hiduke[2];
			days_array.push(show);
			data_arr.push(data_2nd[key]);
		}

		var type = 'bar';

		var data = {
		labels: days_array,
		datasets: [{
			label: '製品数',
			data: data_arr,
			backgroundColor: "rgba(166,206,227,255)",
			borderWidth: 0
		}
		],
		};

		var options = {
			scales: {
				yAxes: [
				{
				  ticks: {
				    beginAtZero: true,
				    min: 0
				  }
				}
				]
			},
			plugins: {
				colorschemes: {
					scheme: 'brewer.Paired3'
				}
		    },
			animation: {
	            duration: 0, // 一般的なアニメーションの時間
	        },
	        hover: {
	            animationDuration: 0, // アイテムのマウスオーバー時のアニメーションの長さ
	        },
	        responsiveAnimationDuration: 0, // サイズ変更後のアニメーションの長さ
		};

		var ctx = document.getElementById('product-count_chart').getContext('2d');
		var chart = new Chart(ctx, {
			type: type,
			data: data,
			options: options
		});
	})();
</script>

<script >
	(function() {
		'use strict';

		var days_array=[];
		var data =<?php echo json_encode($work_time, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
		var brother_data =<?php echo json_encode($brother_work_time, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

		var line_data = [];
		var data_arr = [];
		var brother_data_arr = [];
		for(var key in data){
			let hiduke = key.split('-');
			let show = hiduke[1] + "/" + hiduke[2];
			days_array.push(show);
			data_arr.push(data[key]);
			brother_data_arr.push(brother_data[key]);
			line_data.push(495);
		}

		var type = 'bar';

		var radio = $('input[name="display_interval"]:checked');
		if(radio.val() == 'day'){
			var data = {
				labels: days_array,
				datasets: [{
					label: '残業ライン',
					data: line_data,
					borderColor: "rgba(178,223,138,255)",
					backgroundColor: "rgba(178,223,138,255)",
					type: 'line',
					pointRadius: 0,
					fill: false,
					order: 3
				},{
					label: 'ブラザー稼働時間',
					data: brother_data_arr,
					borderColor: "rgba(31,120,180,255)",
					backgroundColor: "rgba(31,120,180,255)",
					type: 'line',
					pointRadius: 3,
					fill: false,
					order: 2
				},{
					label: '制作時間 [分]',
					data: data_arr,
					backgroundColor: "rgba(166,206,227,255)",
					borderWidth: 0,
					order: 1
				}]
			};
		}else{
			var data = {
				labels: days_array,
				datasets: [{
					label: 'ブラザー稼働時間',
					data: brother_data_arr,
					borderColor: "rgba(31,120,180,255)",
					backgroundColor: "rgba(31,120,180,255)",
					type: 'line',
					pointRadius: 3,
					fill: false,
					order: 2
				},{
					label: '制作時間 [分]',
					data: data_arr,
					backgroundColor: "rgba(166,206,227,255)",
					borderWidth: 0,
					order: 1
				}]
			};
		}


		var options = {
			elements:{
				line: {
					tension: 0,	//ベジェ曲線を無効にする
				}
			},
			scales: {
				yAxes: [
					{
						stacked: false,
					  ticks: {
					    beginAtZero: true,
					    min: 0
					  }
					}
				],
				xAxes:[
					{
						stacked: true
					}
				]
			},
			animation: {
	            duration: 0, // 一般的なアニメーションの時間
	        },
	        hover: {
	            animationDuration: 0, // アイテムのマウスオーバー時のアニメーションの長さ
	        },
	        responsiveAnimationDuration: 0, // サイズ変更後のアニメーションの長さ
		};

		var ctx = document.getElementById('working-time_chart').getContext('2d');
		var chart = new Chart(ctx, {
			type: type,
			data: data,
			options: options
		});
	})();
</script>


@endsection
