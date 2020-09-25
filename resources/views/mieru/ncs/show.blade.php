@extends('layouts.mieru_nc_default')

{{--
@section('title')
Blog Posts
@endsection
--}}

@section('title','NC')

@section('content')


<section >
    	<div class="container">
    		<div class="row mb-1">
    			<div class="col-sm-12">
    				<h1>図面詳細 <a href="<?= $link; ?>">{{ $zuban }}</a></h1>
    			</div>
    		</div>
            <div class="row">
                <div class="col-sm-12">
                    <iframe src="{{ $link }}" width="600" height="500"></iframe>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mt-2">
                    <p>会社名: {{ $info['customer_name'] }}</p>
                    <p>平均ソフト見積単価: <?= $info['average_cost']; ?></p>
                    <p>制作個数: <?= $info['total_quantity']; ?></p>
                    <p>見積総額: <?= $info['total_sale'];?></p>
                    <p>実際の売り上げ総額: <?= $info['total_real_sale'];?></p>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>過去製造データ</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table">
    					<thead>
    						<tr>
    							<th>出荷日</th>
    							<th>製番</th>
                                <th>個数</th>
                                <th>一個当たり作業時間[分]</th>
    							<th>ソフト見積</th>
                                <th>売上</th>
                                <th>材料費</th>
                                <th>費用</th>
    							<th>利益率(見積)[%]</th>
    						</tr>
    					</thead>
    					<tbody>
                            <?php $i = 0;
                            foreach ($data as  $datum): ?>
                                <tr>
                                    <td><?= $datum['delivery_date']; ?></td>
                                    <td><?= $datum['id']; ?></td>
                                    <td><?= $datum['quantity']; ?></td>
                                    <td><?= $datum['ave_worktime']; ?></td>
                                    <td><?= $datum['sale'];?></td>
                                    <td><?= $datum['real_sale']; ?></td>
                                    <td><?= $datum['material_cost']; ?></td>
                                    <td><?= $datum['cost']; ?></td>
                                    <td><?= $datum['profit_rate']; ?>
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

@endsection
