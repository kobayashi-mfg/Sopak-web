<?php

namespace App\EstimateMachiningClass;

use Illuminate\Http\Request;
use App\EstimateMachiningClass\AppSettings;
use App\EstimateMachiningClass\EndmillClass;
use App\EstimateMachiningClass\DrilClass;
use App\EstimateMachiningClass\ScrewClass;
use App\EstimateMachiningClass\ChamferClass;
use App\EstimateMachiningClass\CounterboringClass;


class EstimateCalculator
{
    // private $worker_id;
    // private $customer_id;
    // private $zuban;
    private $worker_id;
    private $customer_id;
    private $zuban;
    private $count;
    private $material_width;
    private $material_height;
    private $material_depth;
    private $material_type;
    private $material_cost;
    private $is_temporaty_material_cost;
    private $change_count;
    private $coding_min;
    private $dry_run_min;
    private $jig_creation_min;

    /// ワーク座標原点の設定にかかる時間（分）
    public $setup_min;
    /// 準備時間（分）
    public $origin_setting_min;
    /// 準備時間と原点指定時間（分）
    public $setup_and_original_setting_min;
    /// ワークの持ち替え時間（分）
    public $change_min;
    /// バリ取り時間（分)
    public $deburring_min;

    public function __construct(Request $request){
        $this->worker_id = $request->worker_id;
        $this->customer_id = $request->count;
        $this->zuban = $request->figure_id;
        $this->count = $request->quantity;
        $this->material_width = $request->material_width;
        $this->material_height = $request->material_height;
        $this->material_depth = $request->material_depth;
        $this->material_type = $request->material_type;
        $this->material_cost = $request->material_cost;
        $this->is_temporary_material_cost = $request->is_temporary_material_cost;
        $this->change_count = $request->change_count;
        $this->coding_min = $request->coding_time;
        $this->dry_run_min = $request->dry_run_time;
        $this->jig_creation_min = $request->jig_creation_time;

        $this->setup_min = $this->coding_min + $this->dry_run_min + $this->jig_creation_min;
        $this->origin_setting_min = $this->change_count * 2;
        $this->setup_and_original_setting_min = $this->setup_min + $this->origin_setting_min;
        $this->change_min = $this->change_count * 2;
        $this->deburring_min = $this->change_count * 0.5;
    }

    public function Calc($process_arr){
        $cutting_time = 0;
        $blind_hole_count = 0;
        foreach($process_arr as $process){
            $unitCuttingTime = $this->CalculateManufacturingTime($process, $this->material_type);
            $blind_hole_count += $process['is_blindhole']? 1 : 0;
            $cutting_time += $unitCuttingTime;
            $process['cutting_time'] = $unitCuttingTime;
        }

        //検査時間の算出
        $inspection = $this->change_count + ($blind_hole_count*3); //持ち替え回数×１分

        //準備・加工時間の算出
        $arrangement = $this->setup_min;

        //加工時間の算出 = 原点出し時間 + 切削時間 + バリ取り時間 + 検査時間 + 持帰時間
        $manu_min = $this->origin_setting_min + $cutting_time + $this->deburring_min + $inspection + $this->change_min;

        //総合計時間の算出(加工前準備時間+加工時間)
        $total_time = $arrangement + $manu_min;

        //見積もり金額の算出
        (int) $time_unit_price = ceil($total_time * AppSettings::$Charge);//総合計時間にチャージ料100円/分をかけて単価を出す。(小数点以下切り上げ)
        (int) $unit_price = $time_unit_price + $this->material_cost;  //時間単価に材料単価を足す

        //単価の算出
        $one_price = $this->CalcTotalPrice($manu_min, $total_time, $unit_price, $inspection, 1);
        //見積もり金額の算出
        $total_price = $this->CalcTotalPrice($manu_min, $total_time, $unit_price, $inspection, $this->count);

        $result['one_price'] = $one_price;
        $result['total_price'] = $total_price;
        $result['manufacturing_time'] = $manu_min;
        $result['total_time'] = $total_time;
        return $result;

    }

    /// 加工に必要な加工時間を計算します。
    public function CalculateManufacturingTime($process, $material_type){
        $unit_cutting_time = 0;
        switch($process['type']){
            case 'endmill':
                $item = new EndmillClass($process);
                break;
            case 'dril':
                $item = new DrilClass($process);
                break;
            case 'screw':
                $item = new ScrewClass($process);
                break;
            case 'chamfer':
                $item = new ChamferClass($process);
                break;
            case 'counterboring':
                $item = new CounterboringClass($process);
                break;
            default:
                break;
        }
        $unit_cutting_time = $item->CalculateManufacturingTime($material_type);
        return $unit_cutting_time;
    }

	/// 数量を加味して合計金額を計算します。
    private function CalcTotalPrice($manu_min, $total_time, $unit_price, $inspection, $quantity){
        // $quantity = $this->count;
        $inspection_time = $inspection;
        /// 検査回数(数が1なら1、それ以上なら最初と最後と20個に1回
        $inspection_count = $quantity <= 1 ? 1 : (int) (($quantity - 1)/20) + 2;

        // 最終見積金額 = 1個での見積価格単価*数量 - 最初の一個以外の準備・原点出しチャージ - 余分に加えてしまっている検査チャージ
        // （※1個での見積価格単価には毎回検査と原点出し時間が含まれてしまっているので修正している）
        $total_price = ($unit_price * $quantity)
            - ($quantity <= 1 ? 0 :(int)(($quantity - 1) * $this->setup_and_original_setting_min * AppSettings::$Charge))
            - (($quantity - $inspection_count) * $inspection_time * AppSettings::$Charge);
        return $total_price;
    }

}
