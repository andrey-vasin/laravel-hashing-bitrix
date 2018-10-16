<?php
namespace AndreyVasin\LaravelHashingBitrix;

use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelHashingBitrixServiceProvider
 *
 * @package AndreyVasin\LaravelHashingBitrix
 */
class LaravelHashingBitrixServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app('hash')->extend('bitrix',  function () {
            return new BitrixHasher();
        });
    }
}
