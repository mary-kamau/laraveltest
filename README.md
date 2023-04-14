laravel.com

1. Log DB Queries  Add thiese to AppServiceProvider:

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

    public function boot()
    {
        DB::listen(function ($query) {
            // This function will be called each time a query is executed
            Log::info($query->sql, $query->bindings, $query->time);
        });
    }


You can use a model observer to clear Cache if the model data is Cached whenever a new model is created, updated or deleted. 
    Add protected clearCache() method in the ModelObserver:

    protected function clearCache()
    {
        \Cache::forget('cache_name') categories here references the cache id or name.
    }

    Then call this function in the  created, updated or deleted events as $this->clearCache()

    Make sure the Obser is registered in the EventServiceProvider:
        app\Providers\EventServiceProvider.php, boot method
        Model::observe(ModelObserver::class)


Many to Many relationship 


