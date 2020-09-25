@extends('layouts.nc_default')

{{--
@section('title')
Blog Posts
@endsection
--}}

@section('title','NC')

@section('content')


@if (session('flash_message'))
	<div class="alert alert-success  alert-dismissible fade show" role="alert">
	  {{ session('flash_message') }}
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
@endif

<section>
    <div class="container">
		{{--
        <div class="row">
            @if(Auth::check())
            <p>USER: {{$user->name}}</p>
            @else
            <p>ログインしていません。</p>
            @endif
        </div>
		--}}
		<div class="row">
			<div class="col-sm-12">
				<p><a href="{{ route('purchases.create') }}">新規購入申請</a></p>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-sm-12">
				<h2>購入申請一覧</h2>
			</div>
		</div>
		<form method="get" action="{{ route('purchases.index') }}">
			<div class="row mb-2">
					<div class="col-sm-3 pr-1">
						<select id="choice_status" class="form-control" name="choice_status">
							<option value="">削除以外すべて</option>
							<option value="0">削除</option>
							<option value="1">申請中</option>
							<option value="2">承認</option>
							<option value="3">受取</option>
						</select>
					</div>
					<div class="col-sm-9">
	                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i></button>
					</div>
			</div>
		</form>

		<table class="table">
			<thead>
				<tr>
					<th>日付</th>
					<th>状態</th>
					<th>申請品名</th>
					<th>合計価格</th>
					<th>申請者</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($info_arr as $app): ?>
					<tr>
						<td><?= explode(' ', $app['created_at'])[0]; ?></td>
						<td>
                            @can('user-higher')
							<form action="purchase_claim_edit.php"method="get">
								<a href="{{ route('purchases.show_status', $app['id'])}}"><?= $status_msg[$app['status']]; ?></a>
							</form>
                            @endcan
						</td>
						<td>
							<a href="{{ route('purchases.show', $app['id']) }}"><?=$app['item_name']; ?></a>
						</td>
                        <td><?= number_format((float) $app['price']); ?></td>
						<td><?= $app['worker_id']; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="row">
			<div class="col-sm-12 d-flex justify-content-end">
				{{$applications->links()}}
			</div>
		</div>
    </div>
</section>

<script  type="text/javascript" >
	//材料セレクタの設定
	var material_select = document.getElementById("choice_status");
	var options = material_select.options;
	var option_value = "<?php if(isset($choice_status)) echo $choice_status; else echo ''; ?>";
	for(let i = 0; i < options.length; i++){
		if(options[i].value == option_value){
			options[i].selected = true;
			break;
		}
	}
</script>
@endsection
