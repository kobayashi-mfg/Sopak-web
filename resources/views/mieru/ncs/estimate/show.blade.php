@extends('layouts.nc_default')



@section('title','NC')

@section('content')

<section>
    <div class="container">
		<div class="row">
			<div class="col-sm-12">
				<p><a href="#" onclick="window.history.back();">見積照会に戻る</a></p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h2>見積詳細</h2>
			</div>
		</div>
	</div>
</section>
<section>
    <div class="container">
		<?php if($estimate!=null): ?>
			<div class="unvisible">
				<div class="row">
					<div class="col-sm-12">
						<p>見積番号:<span class="ml-1"><?= $estimate['id']; ?></span></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<p>グループID: <span class="ml-1"><?= $estimate['group_id']; ?></span></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<p>版: <span class="ml-1"><?= $estimate['revision_number']; ?></span></p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<p>作業者: <span class="ml-1"><?= $worker_name; ?></span></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>客先コード: <span class="ml-1"><?= $customer_name; ?></span></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>図番: <span class="ml-1"><a href="{{ route('mieru.ncs.show',$estimate['figure_id']) }}" target="_blank"><?= $estimate['figure_id']; ?></a></span></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>材料: <span class="ml-1"><?= $estimate['material_type']; ?></span></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>幅×奥行き×高さ:  <span class="ml-1"><?= $estimate['material_width']; ?>×<?=$estimate['material_depth'];?>×<?=$estimate['material_height'];?></span></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>材料費:
						<span class="ml-1"><?=$estimate['material_cost'];?>円</span>
						<?php if($estimate['is_temporary_material_cost']): ?>
							<span class="ml-1"><-仮の材料費</span>
						<?php endif;?>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>持ち替え回数:  <span class="ml-1"><?=$estimate['change_count'];?></span>回</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>コーディング時間:  <span class="ml-1"><?=$estimate['coding_time'];?></span>分</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>ドライラン時間:  <span class="ml-1"><?=$estimate['dry_run_time'];?></span>分</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>治具作成時間:  <span class="ml-1"><?=$estimate['jig_creation_time'];?></span>分</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>加工時間:  <span class="ml-1">約<?=round($estimate['manufacturing_time']*10)/10;?></span>分</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>合計時間:  <span class="ml-1">約<?=round($estimate['total_time']*10)/10;?></span>分</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>単価:  <span class="ml-1"><?=number_format((float)$estimate['unit_price']);?></span>円</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>数量:  <span class="ml-1"><?=$estimate['quantity'];?></span>個</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p>合計見積金額:  <span class="ml-1"><?=number_format((float)$estimate['total_price']);?></span>円</p>
				</div>
			</div>
			<?php if($estimate['adjusted_price'] != 0): ?>
				<div class="row">
					<div class="col-sm-12">
						<p>調整後金額:  <span class="ml-1"><?=number_format((float)$estimate['adjusted_price']);?></span></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<p>調整理由:  <span class="ml-1"><?=$estimate['adjustment_reason'];?></span></p>
					</div>
				</div>
			<?php endif;?>
			<div class="row">
				<div class="col-sm-12">
					<p>作成日:  <span class="ml-1"><?=$estimate['created_at'];?></span></p>
				</div>
			</div>
		<?php else: ?>
			<div class="row">
				<div class="col-sm-12">
					<h2>該当する見積がありません。</h2>
				</div>
			</div>
		<?php endif;?>
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<table class="table">
				<thead>
					<tr>
						<th>種類</th>
						<th>直径</th>
						<th>距離</th>
						<th>深さ</th>
						<th>一回あたりの深さ</th>
						<th>個数</th>
						<th>止まり穴</th>
						<th>C</th>
						<th>サンダー</th>
						<th>加工時間</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($manufacturings as $manu): ?>
						<tr>
							<td><?= $manu_type[$manu['type']];?></td>
							<td><?= $manu['diameter'];?></td>
							<td><?= $manu['distance'];?></td>
							<td><?= $manu['depth'];?></td>
							<td><?= $manu['depth_of_once'];?></td>
							<td><?= $manu['quantity'];?></td>
							<td><?php if($manu['is_blind_hole']) echo '〇';?></td>
							<td><?php if($manu['chamfer_size']) echo $manu['chamfer_size'];?></td>
							<td><?php if($manu['is_sanding']) echo '〇';;?></td>
							<td><?= round($manu['cutting_time']*100)/100;?></td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>

		</div>
	</div>
</section>


@endsection
