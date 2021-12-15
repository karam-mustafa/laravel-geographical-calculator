<?php

namespace KMLaravel\GeographicalCalculator\Providers;

use Illuminate\Support\ServiceProvider;
use KMLaravel\GeographicalCalculator\Classes\Geo;
use KMLaravel\GeographicalCalculator\Commands\InstallCommand;

class GeoServiceProviders extends ServiceProvider
{
    public function boot()
    {
        $this->registerFacades();
        $this->publishesPackages();
        $this->resolveCommands();
    }

    public function register()
    {
    }

    /**
     * register facades dependence's.
     */
    protected function registerFacades()
    {
        $this->app->singleton('GeoFacade', function () {
            return new Geo();
        });
    }

    /**
     * @desc publish files
     *
     * @author karam mustafa
     */
    protected function publishesPackages()
    {
        $this->publishes([
            __DIR__.'/../Config/geographical_calculator.php' => config_path('geographical_calculator.php'),
        ], 'geographical-calculator-config');
    }

    /**
     * @author karam mustafa
     */
    private function resolveCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
