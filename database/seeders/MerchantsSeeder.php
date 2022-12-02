<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerchantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name' => 'Pepay',
                'status' => 1,
                'supports' => '{"822":"\u4e2d\u570b\u4fe1\u8a17","808":"\u7389\u5c71\u9280\u884c","008":"\u83ef\u5357\u9280\u884c","700":"\u4e2d\u83ef\u90f5\u653f","ibon":"7-Eleven","fami":"\u5168\u5bb6\u4fbf\u5229\u5546\u5e97\u02c7","life":"\u840a\u723e\u5bcc","ok":"OK\u8d85\u5546"}',
                'weight' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test',
                'status' => 1,
                'supports' => '{"ibon":"7-Eleven","fami":"\u5168\u5bb6\u4fbf\u5229\u5546\u5e97\u02c7","life":"\u840a\u723e\u5bcc","ok":"OK\u8d85\u5546"}',
                'weight' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        DB::table('merchants')->insert($datas);
    }
}
