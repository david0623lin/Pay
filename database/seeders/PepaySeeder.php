<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PepaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            // WEB ATM 付款
            ['id' => '822', 'prod_id' => 'PD-WEBATM-CTCB', 'name' => '中國信託WEB-ATM', 'currency' => 'TWD', 'sub_pay_type' => 'ST-ATM'],
            ['id' => '808', 'prod_id' => 'PD-WEBATM-ESUN', 'name' => '玉山銀行WEB-ATM', 'currency' => 'TWD', 'sub_pay_type' => 'ST-ATM'],
            ['id' => '008', 'prod_id' => 'PD-WEBATM-HNCB', 'name' => '華南WEB-ATM', 'currency' => 'TWD', 'sub_pay_type' => 'ST-ATM'],
            ['id' => '700', 'prod_id' => 'PD-WEBATM-POST', 'name' => '郵局WEB-ATM', 'currency' => 'TWD', 'sub_pay_type' => 'ST-ATM'],
            // 便利超商代收
            ['id' => 'fami', 'prod_id' => 'PD-STORE-FAMI', 'name' => '全家FAMIPORT', 'currency' => 'TWD', 'sub_pay_type' => ''],
            ['id' => 'life', 'prod_id' => 'PD-STORE-HILIFEET', 'name' => '萊爾富Life-ET', 'currency' => 'TWD', 'sub_pay_type' => ''],
            ['id' => 'ibon', 'prod_id' => 'PD-STORE-IBON', 'name' => 'ibon便利生活站', 'currency' => 'TWD', 'sub_pay_type' => ''],
            ['id' => 'ok', 'prod_id' => 'PD-STORE-OKGO', 'name' => 'OK超商OK-go', 'currency' => 'TWD', 'sub_pay_type' => ''],
        ];
        DB::table('pepay')->insert($datas);
    }
}
