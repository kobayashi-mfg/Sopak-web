@extends('layouts.nc_default')



@section('title','NC')

@section('content')


@if($errors->any())
    @foreach($errors->all() as $error)
        <p>{{$error}}</p>
    @endforeach
@endif



<form method="post" action="{{ route('machiningtools.store') }}">
    {{ csrf_field() }}
<div class="f-container mt-4">
	<div class="f-item form-paper">
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h1>機械加工工具追加</h1>
					</div>
				</div>

                <div class="form-item">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="tool_type">
                                工具種類
                                @if ($errors->has('tool_type'))
                                    <span class="text-font-alert">{{$errors->first('tool_type')}}</span>
                                @endif
                            </label>
                            <input type="text" class="form-control" id="tool_type" name="tool_type" maxlength='20' value="<?= old('tool_type', $tool_type); ?>" readonly>
                        </div>
                        <div class="col-sm-9"></div>
                    </div>
                </div>

                <?php switch(old('tool_type', $tool_type)):
                    case 'endmill': ?>
                        <div class="form-item">
        					<div class="row">
                                <div class="col-sm-3">
                                    <label for="endmill_name">
                                        名前
                                        @if ($errors->has('endmill_name'))
                                            <span class="text-font-alert">{{$errors->first('endmill_name')}}</span>
                                        @endif
                                    </label>
                                    <input type="text" id="endmill_name" class="form-control" maxlength='20' name="endmill_name" placeholder="" value="{{ old('endmill_name') }}" required>
                                </div>
        						<div class="col-sm-3">
                                    <label for="diameter">
                                        直径
                                        @if ($errors->has('diameter'))
                                            <span class="text-font-alert">{{$errors->first('diameter')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="diameter" class="form-control" max="9999" min = "0" maxlength='6' name="diameter" placeholder="" value="{{ old('diameter') }}" required>
        						</div>
                                <div class="col-sm-6"></div>
        					</div>
        				</div>
                        <div class="form-item">
        					<div class="row">
                                <div class="col-sm-3">
                                    <label for="ss_grooving_rotation">
                                        溝切削回転速度(SS)
                                        @if ($errors->has('ss_grooving_rotation'))
                                            <span class="text-font-alert">{{$errors->first('ss_grooving_rotation')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="ss_grooving_rotation" class="form-control" max="9999" min = "0" maxlength='20' name="ss_grooving_rotation" placeholder="" value="{{ old('ss_grooving_rotation') }}" required>
                                </div>
        						<div class="col-sm-3">
                                    <label for="sus_grooving_rotation">
                                        溝切削回転速度(SUS)
                                        @if ($errors->has('sus_grooving_rotation'))
                                            <span class="text-font-alert">{{$errors->first('sus_grooving_rotation')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="sus_grooving_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="sus_grooving_rotation" placeholder="" value="{{ old('sus_grooving_rotation') }}" required>
        						</div>
                                <div class="col-sm-3">
                                    <label for="al_grooving_rotation">
                                        溝切削回転速度(Al)
                                        @if ($errors->has('al_grooving_rotation'))
                                            <span class="text-font-alert">{{$errors->first('al_grooving_rotation')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="al_grooving_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="al_grooving_rotation" placeholder="" value="{{ old('al_grooving_rotation') }}" required>
                                </div>
        					</div>
        				</div>
                        <div class="form-item">
        					<div class="row">
                                <div class="col-sm-3">
                                    <label for="ss_grooving_feeding">
                                        溝切削送り速度(SS)
                                        @if ($errors->has('ss_grooving_feeding'))
                                            <span class="text-font-alert">{{$errors->first('ss_grooving_feeding')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="ss_grooving_feeding" class="form-control" max="9999" min = "0" maxlength='20' name="ss_grooving_feeding" placeholder="" value="{{ old('ss_grooving_feeding') }}" required>
                                </div>
        						<div class="col-sm-3">
                                    <label for="sus_grooving_feeding">
                                        溝切削送り速度(SUS)
                                        @if ($errors->has('sus_grooving_feeding'))
                                            <span class="text-font-alert">{{$errors->first('sus_grooving_feeding')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="sus_grooving_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="sus_grooving_feeding" placeholder="" value="{{ old('sus_grooving_feeding') }}" required>
        						</div>
                                <div class="col-sm-3">
                                    <label for="al_grooving_feeding">
                                        溝切削送り速度(Al)
                                        @if ($errors->has('al_grooving_feeding'))
                                            <span class="text-font-alert">{{$errors->first('al_grooving_feeding')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="al_grooving_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="al_grooving_feeding" placeholder="" value="{{ old('al_grooving_feeding') }}" required>
                                </div>
        					</div>
        				</div>
                        <div class="form-item">
        					<div class="row">
                                <div class="col-sm-3">
                                    <label for="ss_sideface_rotation">
                                        側面切削回転速度(SS)
                                        @if ($errors->has('ss_sideface_rotation'))
                                            <span class="text-font-alert">{{$errors->first('ss_sideface_rotation')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="ss_sideface_rotation" class="form-control" max="9999" min = "0" maxlength='20' name="ss_sideface_rotation" placeholder="" value="{{ old('ss_sideface_rotation') }}" required>
                                </div>
        						<div class="col-sm-3">
                                    <label for="sus_sideface_rotation">
                                        側面切削回転速度(SUS)
                                        @if ($errors->has('sus_sideface_rotation'))
                                            <span class="text-font-alert">{{$errors->first('sus_sideface_rotation')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="sus_sideface_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="sus_sideface_rotation" placeholder="" value="{{ old('sus_sideface_rotation') }}" required>
        						</div>
                                <div class="col-sm-3">
                                    <label for="al_sideface_rotation">
                                        側面切削回転速度(Al)
                                        @if ($errors->has('al_sideface_rotation'))
                                            <span class="text-font-alert">{{$errors->first('al_sideface_rotation')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="al_sideface_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="al_sideface_rotation" placeholder="" value="{{ old('al_sideface_rotation') }}" required>
                                </div>
        					</div>
        				</div>
                        <div class="form-item">
        					<div class="row">
                                <div class="col-sm-3">
                                    <label for="ss_sideface_feeding">
                                        側面切削送り速度(SS)
                                        @if ($errors->has('ss_sideface_feeding'))
                                            <span class="text-font-alert">{{$errors->first('ss_sideface_feeding')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="ss_sideface_feeding" class="form-control"  max="9999" min = "0" maxlength='20' name="ss_sideface_feeding" placeholder="" value="{{ old('ss_sideface_feeding') }}" required>
                                </div>
        						<div class="col-sm-3">
                                    <label for="sus_sideface_feeding">
                                        側面切削送り速度(SUS)
                                        @if ($errors->has('sus_sideface_feeding'))
                                            <span class="text-font-alert">{{$errors->first('sus_sideface_feeding')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="sus_sideface_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="sus_sideface_feeding" placeholder="" value="{{ old('sus_sideface_feeding') }}" required>
        						</div>
                                <div class="col-sm-3">
                                    <label for="al_sideface_feeding">
                                        側面切削送り速度(Al)
                                        @if ($errors->has('al_sideface_feeding'))
                                            <span class="text-font-alert">{{$errors->first('al_sideface_feeding')}}</span>
                                        @endif
                                    </label>
                                    <input type="number" id="al_sideface_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="al_sideface_feeding" placeholder="" value="{{ old('al_sideface_feeding') }}">
                                </div>
        					</div>
        				</div>
                    <?php break;?>




                <?php case 'dril': ?>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="diameter">
                                    工具径
                                    @if ($errors->has('diameter'))
                                        <span class="text-font-alert">{{$errors->first('diameter')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="diameter" class="form-control" max="9999" min = "0" maxlength='6' name="diameter" placeholder="" value="{{ old('diameter') }}" required>
                            </div>
                            <div class="col-sm-9"></div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="ss_rotation">
                                    回転速度(SS)
                                    @if ($errors->has('ss_rotation'))
                                        <span class="text-font-alert">{{$errors->first('ss_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="ss_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="ss_rotation" placeholder="" value="{{ old('ss_rotation') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="sus_rotation">
                                    回転速度(SUS)
                                    @if ($errors->has('sus_rotation'))
                                        <span class="text-font-alert">{{$errors->first('sus_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="sus_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="sus_rotation" placeholder="" value="{{ old('sus_rotation') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="al_rotation">
                                    回転速度(Al)
                                    @if ($errors->has('al_rotation'))
                                        <span class="text-font-alert">{{$errors->first('al_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="al_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="al_rotation" placeholder="" value="{{ old('al_rotation') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="ss_feeding">
                                    送り速度(SS)
                                    @if ($errors->has('ss_feeding'))
                                        <span class="text-font-alert">{{$errors->first('ss_feeding')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="ss_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="ss_feeding" placeholder="" value="{{ old('ss_feeding') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="sus_feeding">
                                    送り速度(SUS)
                                    @if ($errors->has('sus_feeding'))
                                        <span class="text-font-alert">{{ $errors->first('sus_feeding') }}</span>
                                    @endif
                                </label>
                                <input type="number" id="sus_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="sus_feeding" placeholder="" value="{{ old('sus_feeding') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="al_feeding">
                                    送り速度(Al)
                                    @if ($errors->has('al_feeding'))
                                        <span class="text-font-alert">{{ $errors->first('al_feeding') }}</span>
                                    @endif
                                </label>
                                <input type="number" id="al_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="al_feeding" placeholder="" value="{{ old('al_feeding') }}" required>
                            </div>
                        </div>
                    </div>
                    <?php break;?>

                <?php case 'screw': ?>
                    <div class="form-item">
                        <div class="row d-flex align-items-end">
                            <div class="col-sm-3">
                                <label for="diameter">
                                    径
                                    @if ($errors->has('diameter'))
                                        <span class="text-font-alert">{{$errors->first('diameter')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="diameter" class="form-control" max="9999" min = "0" maxlength='6' name="diameter" placeholder="" value="{{ old('diameter') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="pich">
                                    ピッチ
                                    @if ($errors->has('pich'))
                                        <span class="text-font-alert">{{$errors->first('pich')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="pich" class="form-control" max="9999" min = "0" maxlength='6' name="pich" placeholder="" value="{{ old('pich') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="pilot_hole_diameter">
                                    下穴径
                                    @if ($errors->has('pilot_hole_diameter'))
                                        <span class="text-font-alert">{{$errors->first('pilot_hole_diameter')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="pilot_hole_diameter" class="form-control" max="9999" min = "0" maxlength='6' name="pilot_hole_diameter" placeholder="" value="{{ old('pilot_hole_diameter') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <input class="form-check-input" type="checkbox" id="is_blind_hole" name="is_blind_hole" value="1" >
                                <label class="form-check-label" for="is_blind_hole">
                                    止まり穴
                                    @if ($errors->has('is_blind_hole'))
                                        <span class="text-font-alert">{{$errors->first('is_blind_hole')}}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="ss_point_rotation">
                                    ポイントタップ回転速度(SS)
                                    @if ($errors->has('ss_point_rotation'))
                                        <span class="text-font-alert">{{$errors->first('ss_point_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="ss_point_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="ss_point_rotation" placeholder="" value="{{ old('ss_point_rotation') }}" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="sus_point_rotation">
                                    ポイントタップ回転速度(SUS)
                                    @if ($errors->has('sus_point_rotation'))
                                        <span class="text-font-alert">{{$errors->first('sus_point_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="sus_point_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="sus_point_rotation" placeholder="" value="{{ old('sus_point_rotation') }}" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="al_point_rotation">
                                    ポイントタップ回転速度(Al)
                                    @if ($errors->has('al_point_rotation'))
                                        <span class="text-font-alert">{{$errors->first('al_point_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="al_point_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="al_point_rotation" placeholder="" value="{{ old('al_point_rotation') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="ss_spiral_rotation">
                                    スクリュータップ回転速度(SS)
                                    @if ($errors->has('ss_spiral_rotation'))
                                        <span class="text-font-alert">{{$errors->first('ss_spiral_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="ss_spiral_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="ss_spiral_rotation" placeholder="" value="{{ old('ss_spiral_rotation') }}" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="sus_spiral_rotation">
                                    スクリュータップ回転速度(SUS)
                                    @if ($errors->has('sus_spiral_rotation'))
                                        <span class="text-font-alert">{{$errors->first('sus_spiral_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="sus_spiral_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="sus_spiral_rotation" placeholder="" value="{{ old('sus_spiral_rotation') }}" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="al_spiral_rotation">
                                    スクリュータップ回転速度(Al)
                                    @if ($errors->has('al_spiral_rotation'))
                                        <span class="text-font-alert">{{$errors->first('al_spiral_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="al_spiral_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="al_spiral_rotation" placeholder="" value="{{ old('al_spiral_rotation') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="ss_center_dril_feeding">
                                    センタードリル送り速度(SS)
                                    @if ($errors->has('ss_spiral_rotation'))
                                        <span class="text-font-alert">{{$errors->first('ss_spiral_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="ss_center_dril_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="ss_center_dril_feeding" placeholder="" value="{{ old('ss_center_dril_feeding') }}" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="sus_center_dril_feeding">
                                    センタードリル送り速度(SUS)
                                    @if ($errors->has('sus_center_dril_feeding'))
                                        <span class="text-font-alert">{{$errors->first('sus_center_dril_feeding')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="sus_center_dril_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="sus_center_dril_feeding" placeholder="" value="{{ old('sus_center_dril_feeding') }}" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="al_center_dril_feeding">
                                    センタードリル送り速度(Al)
                                    @if ($errors->has('al_center_dril_feeding'))
                                        <span class="text-font-alert">{{$errors->first('al_center_dril_feeding')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="al_center_dril_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="al_center_dril_feeding" placeholder="" value="{{ old('al_center_dril_feeding') }}" required>
                            </div>
                        </div>
                    </div>
                    <?php break;?>

                <?php case 'chamfer': ?>
                <div class="form-item">
                    <div class="row d-flex align-items-end">
                        <div class="col-sm-3">
                            <label for="tool_name">
                                工具名
                                @if ($errors->has('tool_name'))
                                    <span class="text-font-alert">{{$errors->first('tool_name')}}</span>
                                @endif
                            </label>
                            <input type="text" id="tool_name" class="form-control" maxlength='20' name="tool_name" placeholder="" value="{{ old('tool_name') }}" required>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="ss_rotation">
                                    回転速度(SS)
                                    @if ($errors->has('ss_rotation'))
                                        <span class="text-font-alert">{{$errors->first('ss_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="ss_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="ss_rotation" placeholder="" value="{{ old('ss_rotation') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="sus_rotation">
                                    回転速度(SUS)
                                    @if ($errors->has('sus_rotation'))
                                        <span class="text-font-alert">{{$errors->first('sus_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="sus_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="sus_rotation" placeholder="" value="{{old('sus_rotation')}}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="al_rotation">
                                    回転速度(Al)
                                    @if ($errors->has('al_rotation'))
                                        <span class="text-font-alert">{{$errors->first('al_rotation')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="al_rotation" class="form-control" max="9999" min = "0" maxlength='6' name="al_rotation" placeholder="" value="{{ old('al_rotation') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="ss_feeding">
                                    送り速度(SS)
                                    @if ($errors->has('ss_feeding'))
                                        <span class="text-font-alert">{{$errors->first('ss_feeding')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="ss_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="ss_feeding" placeholder="" value="{{ old('ss_feeding') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="sus_feeding">
                                    送り速度(SUS)
                                    @if ($errors->has('sus_feeding'))
                                        <span class="text-font-alert">{{$errors->first('sus_feeding')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="sus_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="sus_feeding" placeholder="" value="{{ old('sus_feeding') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="al_feeding">
                                    送り速度(Al)
                                    @if ($errors->has('al_feeding'))
                                        <span class="text-font-alert">{{$errors->first('al_feeding')}}</span>
                                    @endif
                                </label>
                                <input type="number" id="al_feeding" class="form-control" max="9999" min = "0" maxlength='6' name="al_feeding" placeholder="" value="{{ old('al_feeding') }}" >
                            </div>
                        </div>
                    </div>
                </div>
                    <?php break;?>
                <?php default: ?>
                    <?php break;?>

                <?php endswitch; ?>


			</div>
		</section>

		<section>
			<div class="container">
				<div class="row mt-3">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-primary">見積作成</button>
                        <a href="{{ route('machiningtools.index') }}" class="ml-3">工具一覧へもどる</a>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
</form>

<script type="text/javascript" >
    //仮の材料費かとうかチェックボックスの設定
    var is_blind_hole = <?php if(old('is_blind_hole')) echo old('is_blind_hole'); else echo '0';?>;
    var is_blind_hole_check = document.getElementById("is_blind_hole");
    if(is_blind_hole){
        is_blind_hole_check.checked = true;
    }else{
        is_blind_hole_check.checked = false;
    }
</script>

@endsection
