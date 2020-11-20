<?php

namespace KMLaravel\GeographicalCalculator\Providers;
use Illuminate\Support\ServiceProvider;
use KMLaravel\GeographicalCalculator\Classes\GeographicalCalculator;

class GeographicalCalculatorServiceProviders extends ServiceProvider
{

    public function boot(){
        $this->registerFacades();
        $this->publishesPackages();
    }
    public function register(){}
    /**
     *
     */
    protected function registerFacades()
    {
        $this->app->singleton("GeographicalCalculatorFacade" , function ($app){
            return new GeographicalCalculator();
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
