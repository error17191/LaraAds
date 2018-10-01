<?php

namespace App\Console\Commands;

use App\Helpers\DBTool;
use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ExperimentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

//        $results1 = DB::table('countries')
//            ->leftJoin('subadmin1', 'countries.code', '=', 'subadmin1.country_code')
//            ->select('countries.code')->whereNull('subadmin1.country_code')
//            ->get()->pluck('code');
//
//        dump($results1);
//
//        $results2 = DB::table('countries')
//            ->leftJoin('subadmin2', 'countries.code', '=', 'subadmin2.country_code')
//            ->select('countries.code')->whereNull('subadmin2.country_code')
//            ->get()->pluck('code');
//
//        dump($results2);
//
//        $results3 = DB::table('countries')
//            ->leftJoin('cities', 'countries.code', '=', 'cities.country_code')
//            ->select('countries.code')->whereNull('cities.country_code')
//            ->get()->pluck('code');
//
//        dump($results3);



        $final = DB::table('countries')->select('code')
            ->whereNotExists(function (Builder $query) {
                $query->select('*')
                    ->from('cities')
                    ->whereRaw('countries.code = cities.country_code');
            })
            ->whereNotExists(function (Builder $query) {
                $query->select('*')
                    ->from('subadmin1')
                    ->whereRaw('countries.code = subadmin1.country_code');
            })
            ->whereNotExists(function (Builder $query) {
                $query->select('*')
                    ->from('subadmin2')
                    ->whereRaw('countries.code = subadmin2.country_code');
            })
            ->get()->pluck('code');

        dump($final);
    }
}
