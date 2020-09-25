@extends('layouts.nc_default')



@section('title','NC')

@section('content')

<form action="{{ route('estimates.index') }}" method="get">

<section>
    <div class="container margin-bottom-container">
		<div class="row">
			<div class="col-sm-12">
				<h2>見積検索</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label for="text1">図番</label>
			</div>
		</div>
		<div class="row d-flex align-items-end">
			<div class="col-sm-8">
				<input type="text" id="text1" class="form-control" maxlength='20' name="zuban" placeholder="例) 2HR5848209A" value=<?php if(!is_null($zuban)) echo $zuban; ?> >
			</div>
			<div class="col-sm-4">
				<button type="submit" class="btn btn-secondary">検索</button>
			</div>
		</div>
	</div>
	<div class="container margin-bottom-container">
		<div class="row">
			<div class="col-sm-12">
				<h3>検索結果 <?php if(isset($zuban)): ?> :<?= $zuban; ?><?php endif; ?></h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table">
					<thead>
						<tr>
							<th>図番</th>
							<th>客先</th>
							<th>材料</th>
							<th>数量</th>
							<th>見積</th>
							<th>登録日</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($estimates)){
							foreach($estimates as $estimate): ?>
								<tr>
									<td>
										<a href="{{ route('mieru.ncs.show', $estimate['figure_id']) }}" target="_blank" ><?=$estimate['figure_id']; ?></a>
									</td>
									<td>
										<?php
											echo $customer_name;
										?></td>
									<td><?= $estimate['material_type']; ?></td>
									<td><?= $estimate['quantity'];?></td>
									<td>
										<?= number_format((float)$estimate['total_price']);?>
										<?php if($estimate['adjusted_price'] != 0): ?>
											 <span class="ml-1">
												 調整アリ
											 </span>
										<?php endif;?>
									</td>
									<td><?=$estimate['created_at']; ?></td>
									<td><a href="{{ route('estimates.show', $estimate['id']) }}">詳細</a></td>
								</tr>
							<?php endforeach;
						};?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<secion>
	<div class="container margin-bottom-container">
		<div class="row">
			<div class="col-sm-12 mb-1">
				<h2>再計算</h2>
			</div>
		</div>
		<!-- <form action="quote_check.php" method="get"> -->
		<div class="row mb-3">
			<div class="col-sm-12">
				<div class="container">
					<div class="row">
						<div class="col-sm-4 mb-2 p-0">
							<label for="text1">数量:</label>
							<input type="number" id="text1" class="form-control mb-3" max="100000" min="0"maxlength="6" step="1" name="kosuu" placeholder="例) 15" value=<?php if(isset($kosuu)) echo $kosuu; ?> >
							<button type="submit" class="btn btn-primary">計算</button>
						</div>

						<div class="col-sm-8">
							<p>再計算後値段(リピート):</p>
							<div class="container">
								<div class="row">
									<div class="col-sm-2"></div>
									<div class="col-sm-10">
										<?php if(isset($Re_prices)):?>
											<p>個数: <?= $kosuu; ?></p>
                                            @if(gettype($Re_prices) != 'string')
    											<?php foreach($Re_prices as $sale): ?>
    												<p><?= number_format((float)$sale); ?></p>
    											<?php endforeach; ?>
                                            @else
                                                <p><?= $Re_prices; ?></p>
                                            @endif
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</secion>


</form>


<script language="javascript" type="text/javascript">
        function Jump2Pic(obj) {
            var target = obj.innerHTML;
			var host = location.host;
			var url = 'http://localhost/kobayashi_mieru/pic.php?' + 'zuban='+target;
			// alert(url);
			window.open(url);
            return false;
        }
</script>


@endsection
