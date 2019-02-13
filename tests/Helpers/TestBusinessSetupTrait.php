<?php

use App\Business;
use App\User;

trait TestBusinessSetupTrait
{
    protected $user;
    protected $business;

    protected function setUpBusiness()
    {
        $this->user     = factory(User::class)->create(["name" => "revo"]);
        $this->business = factory(Business::class)->create();
    }
}
