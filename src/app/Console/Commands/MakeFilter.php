<?php

namespace youness_usee\filter\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeFilter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter {filter} {first} {--type=} {--second=} {--relation=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create    a   new     filter.';

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
     * @return int
     */
    public function handle()
    {

            $filter_name = $this->argument('filter');

            $type = $this->option('type');
            $second = $this->option('second');
            $relation = $this->option('relation');
            $first = $this->argument('first');
            $query = '$builder->where($this->applyFirst(), request($this->applyFirst()))';
            $apply_type = 'single';
            if ($type === 'between') {
                if ($second == null || $first == null) {
                    return $this->error("You should pass first and second options!");
                } else {
                    $apply_type = $type;
                    $query = '$builder->where(str_replace("start_", "",$this->applyFirst()), \'>=\' ,request($this->applyFirst())." 00:00:00")
                        ->where(str_replace("end_", "",$this->applySecond()), \'<=\' ,request($this->applySecond())." 23:59:59")';
                }
            }
            if ($type === 'like'){
                $apply_type = $type;
                $query = '$builder->where($this->applyFirst(), \'LIKE\' ,\'%\' . request($this->applyFirst()) .\'%\')';
            }
            if ($type === 'relation'){
                if ($relation === null){
                    return $this->error("in relation type you should insert --relation=relationName");
                }
                $apply_type = $type;
                $query = '$builder->whereHas(\''.$relation.'\', function($q){
                    $q->where($this->applyFirst(), request($this->applyFirst()));
                })';
            }
            $class_name = $this->classNaming($apply_type, $type, $second);
            $contents =
                '<?php
namespace App\QueryFilters;
    
use Illuminate\View\View;
use Illuminate\Support\Str;
use youness_usee\filter\Filter;
        
class ' . $this->classNaming($type, $filter_name, $second) . ' extends Filter
{
        
    ' . $this->optionalFunctions($apply_type, $second, $first) . '
  
        
    protected function applyFilter($builder)
    {
        return ' . $query . ';
    }
    
}';

            $file = "{$this->classNaming($type, $filter_name, $second)}.php";
            $path = app_path();
            $file = $path . "/QueryFilters/$file";
            $composerDir = $path . "/QueryFilters";

            if (!is_dir($composerDir)) {
                mkdir($composerDir, 0775);
            }
            if (file_exists($file)) {
                return $this->error("$file already exist!");
            } else {
                file_put_contents($file, $contents);
                $this->info("$filter_name generated!");
            }

    }

    public function optionalFunctions($type, $second, $first)
    {

        return 'protected function applyType()
    {
        return "' . $type . '";
    }
    
    protected function applySecond()
    {
        return "' . Str::snake($second) . '";
    }
    
    protected function applyFirst()
    {
        return "' . Str::snake($first) . '";
    }';

    }

    public function classNaming($apply_type, $filter_name, $second)
    {
        if ($apply_type == null){
            return $filter_name;
        }else{
            return $apply_type . $filter_name . $second;
        }

    }
}
