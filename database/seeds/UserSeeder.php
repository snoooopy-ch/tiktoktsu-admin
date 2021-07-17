<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected $table = 'tbl_admin';

    protected $admin_id = 'admin';
    protected $admin_pass = 'admin#2021';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        print_r("UserSeeder has started!\n");

        $records = DB::table($this->table)
            ->where('user_login', $this->admin_id)
            ->select('id')
            ->get();
        if (isset($records) && count($records) > 0) {
            return;
        }

        $ret = DB::table($this->table)
            ->insert([
                'user_login'    => $this->admin_id,
                'password'      => bcrypt($this->admin_pass),
            ]);

        print_r("UserSeeder has finished!\n");
    }
}
