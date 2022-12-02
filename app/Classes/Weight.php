<?php

namespace App\Classes;

use Illuminate\Support\Facades\Redis;
use App\Repositories\MerchantRepository;

class Weight
{
    public function get($payway)
    {
        $weightkey = "Pay_Weight_{$payway}";

        if (!Redis::exists($weightkey)) {
            // 沒有資料就先建立
            $this->create($payway);
        }
        // 取得可用的商戶
        $merchants = json_decode(Redis::get($weightkey), true);
        // 打亂排序
        shuffle($merchants);
        // 取得使用的商戶資料
        $use = count($merchants) - 1;
        $merchant = $merchants[$use];
        $this->delete($weightkey, $merchants, $use);

        return $merchant;
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

    public function delete($weightkey, $merchants, $use)
    {
        unset($merchants[$use]);

        if (count($merchants) == 0) {
            Redis::del($weightkey);
        } else {
            Redis::set($weightkey, json_encode($merchants));
        }
    }
}
