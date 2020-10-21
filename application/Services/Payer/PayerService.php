<?php


namespace Application\Services\Payer;


interface PayerService
{

  public function findOrCreate($getPayerName, $getPayerDni, $getPayerEmail);
}
