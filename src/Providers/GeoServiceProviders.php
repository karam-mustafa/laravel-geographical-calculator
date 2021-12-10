<?php

namespace KMLaravel\GeographicalCalculator\Providers;
use Illuminate\Support\ServiceProvider;
use KMLaravel\GeographicalCalculator\Classes\Geo;

class GeoServiceProviders extends ServiceProvider
{

    public function boot(){
        $this->registerFacades();
        $this->publishesPackages();
    }

    public function register(){}

    /**
     * register facades dependence's
     */
    protected function registerFacades()
    {
        $this->app->singleton("GeoFacade" , function ($app){
            return new Geo();
        });
    }

    /**
     * @desc publish files
     * @author karam mustafa
     */
    protected function publishesPackages()
    {
        $this->publishes([
            __DIR__."/../Config/geographical_calculator.php" => config_path("geographical_calculator.php")
        ] , "geographical-calculator-config");
    }

}
