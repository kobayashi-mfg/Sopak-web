@extends('layouts.nc_default')



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
		<div class="row">
			<div class="col-sm-12">
				<h2>メーカー</h2>
			</div>
		</div>
        <div class="row">
            <div class="col-sm-12">
                <p><a href="{{route('purchases.index')}}">購入申請一覧へ</a></p>
            </div>
        </div>
        <div class="row detail-table">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>メーカー名</th>
                            <th>url</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($suppliers as $sup): ?>
                            <tr>
                                <td class="maker-name text-can-select" id = "maker-<?= $sup['id'];?>">
                                    <a href="{{ route('suppliers.show', $sup['id']) }}"><?= $sup['name']; ?></a>
                                </td>
                                <td><a href="<?= $sup['url']; ?>" target="_blank"><?= $sup['url']; ?></a></td>
                                <td class="delete-btn text-font-alert del" data-id = "<?= $sup['id'];?>" style="cursor : pointer;">
                                    削除
                                    <form method="post" action="{{ route('suppliers.destroy',$sup['id']) }}" id="form_{{$sup['id']}}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@if($maker == null)
    <form action="{{route('suppliers.store')}}" method="post">
        {{ csrf_field() }}
        <div class="f-container">
            <div class="f-item form-paper <?php if(isset($_GET['maker_id'])) echo  "edit-form-paper";?>">
                <section>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php if(isset($_GET['maker_id'])): ?>
                                    <h1>編集</h1>
                                <?php else: ?>
                                    <h1>新規</h1>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-item" style="display:none;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="text1">
                                        社員番号 ()<span class="text-need">必須</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="number" id="text1" class="form-control" max="999999" min = "0" maxlength='6' name="worker_id" placeholder="例) 5060" value="5060" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="select1a">
                                        名前<span class="text-need">必須</span>
                                        @if ($errors->has('maker'))
                                            <span class="error">{{$errors->first('maker')}}</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" id="text1" class="form-control" maxlength='20' name="maker" placeholder="例) ブラザー工業株式会社" value="{{ old('maker') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="text1">
                                        URL<span class="text-need">必須</span>
                                        @if ($errors->has('link'))
                                            <span class="error">{{$errors->first('link')}}</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" id="text1" class="form-control" maxlength='200' name="link" placeholder="例) https://www.brother.co.jp/" value="{{ old('link') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">追加</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@else
<form action="{{route('suppliers.update', $maker->id)}}" method="post">
    {{ csrf_field() }}
    {{ method_field('patch') }}
    <div class="f-container">
        <div class="f-item form-paper edit-form-paper">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1>編集</h1>
                        </div>
                    </div>
                    <div class="form-item" style="display:none;">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">
                                    社員番号 ()<span class="text-need">必須</span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="number" id="text1" class="form-control" max="999999" min = "0" maxlength='6' name="worker_id" placeholder="例) 5060" value="5060" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-item" style="display:none;">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">メーカーID</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="number" id="text1" class="form-control" max="999999" min = "0" maxlength='6' name="maker_id" value="{{  $maker->id }}" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="select1a">
                                    名前<span class="text-need">必須</span>
                                    @if ($errors->has('maker'))
                                        <span class="error">{{$errors->first('maker')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" id="text1" class="form-control" maxlength='20' name="maker" placeholder="例) ブラザー工業株式会社" value="{{ old('maker', $maker->name) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="text1">
                                    URL<span class="text-need">必須</span>
                                    @if ($errors->has('link'))
                                        <span class="error">{{$errors->first('link')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" id="text1" class="form-control" maxlength='200' name="link" placeholder="例) https://www.brother.co.jp/" value="{{ old('link', $maker->url) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">編集</button>
                            <a href="{{ route('suppliers.index') }}" class="ml-2">キャンセル</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>
@endif

<!-- 削除ボタンを押したとき -->
<script type="text/javascript">
(function(){
    'use strict';

    var cmds = document.getElementsByClassName('del');
    var i;

    for(i=0; i<cmds.length; i++){
        cmds[i].addEventListener('click',function(e){
            e.preventDefault();
            if(confirm('本当に削除しますか?')){
                document.getElementById('form_' + this.dataset.id).submit();
            }
        })
    }
})();
</script>


@endsection
