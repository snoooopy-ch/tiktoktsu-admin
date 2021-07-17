<?php

namespace App\Console\Commands;

use DB;
use Log;
use DateTime;
use Illuminate\Console\Command;

class CheckLoginStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check-login-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $table_user = 'ea_users';
    protected $table_access = 'ea_access';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        print_r("CheckLoginStatus has started!!!\n");

        $now = date('Y-m-d H:i:s');
        $now = new DateTime($now);
        $now = $now->add(date_interval_create_from_date_string('-' . ACCESS_INTERVAL . ' seconds'));
        $now = $now->format('Y-m-d H:i:s');
        print_r("Now : " . $now . "\n");

        $records = DB::table($this->table_user)
            ->leftJoin($this->table_access, $this->table_access . '.user_id', '=', $this->table_user . '.id')
            ->where($this->table_user . '.status', STATUS_ACTIVE)
            ->where($this->table_access . '.access', '<=', $now)
            ->select($this->table_user . '.id')
            ->get();

        $ids = [];
        foreach ($records as $index => $record) {
            $ids[] = $record->id;
        }

        $ret = DB::table($this->table_user)
            ->whereIn('id', $ids)
            ->update([
                'loginned'  => NOT_LOGINNED,
            ]);

        print_r(">> Finished, Updated = " . count($ids) . "\n");
    }
}
