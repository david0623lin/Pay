<?php

namespace App\Classes;

use Illuminate\Support\Facades\Redis;
use App\Repositories\MerchantRepository;

class Weight
{


    // public function createWeight($payway)
    // {
    //     $key = "Pay_Weight_{$payway}";

    //     $weightLists = [];
    //     $merchants = MerchantRepository::getAll();

    //     foreach ($merchants as $merchant) {
    //         if (!$merchant['status']) {
    //             continue;
    //         }
    //         $webSuppoets = json_decode($merchant['web_atm_suppoets'], true);
    //         $storeSuppoets = json_decode($merchant['store_suppoets'], true);

    //         if (($merchant['web_atm'] && array_key_exists($mode, $webSuppoets)) || ($merchant['store'] && array_key_exists($mode, $storeSuppoets))) {
    //             // 當該付款模式的權重快取無資料
    //             if (!Redis::exists($key) || json_decode(Redis::get($key), true) == []) {
    //                 for ($i = 0; $i < $merchant['weight']; $i++) {
    //                     $weightLists[] = $merchant;
    //                 }
    //             }
    //         }
    //     }
    //     if ($weightLists != []) {
    //         Redis::set($key, json_encode($weightLists));
    //     }
    // }
    public function get($payway)
    {
        $weightkey = "Pay_Weight_{$payway}";
        // 取得可用的商戶
        $merchants = json_decode(Redis::get($weightkey), true);
        // 打亂排序
        shuffle($merchants);
        // 取得使用的商戶資料
        $use = count($merchants) - 1;
        $merchant = $merchants[$use];

        return $merchant;
    }

    public function delete($payway)
    {
        // 更新 (刪除用調的資料)
        $weightkey = "Pay_Weight_{$payway}";
        $merchants = json_decode(Redis::get($weightkey), true);
        $use = count($merchants) - 1;
        unset($merchants[$use]);
        Redis::set($weightkey, json_encode($merchants));
    }

    public function create($payway)
    {
        $weightkey = "Pay_Weight_{$payway}";
        $merchants = MerchantRepository::getAll();

        foreach ($merchants as $merchant) {
            // 沒有啟用不執行
            if (!$merchant['status']) {
                continue;
            }
            $supports = json_decode($merchant['supports'], true);

            foreach ($supports as $key => $value) {
                if ($payway != $key) {
                    continue;
                }
                $lists = [];

                if (Redis::exists($weightkey)) {
                    // 更新
                    $lists = json_decode(Redis::get($weightkey), true);
                }
                // 新增
                $resp = $this->add($merchant, $lists);
                Redis::set($weightkey, json_encode($resp));
            }
        }
    }

    public function add($merchant, $lists = [])
    {
        for ($i = 0; $i < $merchant['weight']; $i++) {
            if ($lists != []) {
                array_push($lists, $merchant);
            } else {
                $lists[] = $merchant;
            }
        }

        return $lists;
    }

    public function update()
    {

    }
}
