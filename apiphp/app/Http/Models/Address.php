<?php

namespace App\Http\Models;

class Address {
  private string $publicPlace;
  private string $complement;
  private int $number;
  private string $city;
  private string $state;
  private string $district;
  private string $cep;

  public function getPublicPlace(): string 
  {
    return $this->publicPlace;
  }

  public function setPublicPlace(string $publicPlace) 
  {
    $this->publicPlace = strtolower($publicPlace);
  }

  public function getComplement(): string 
  {
    return $this->complement;
  }

  public function setComplement(string $complement) 
  {
    $this->complement = strtolower($complement);
  }

  public function getNumber(): int 
  {
    return $this->number;
  }

  public function setNumber(int $number)
  {
    $this->number = strtolower($number);
  }

  public function getCity(): string 
  {
    return $this->city;
  }

  public function setCity(string $city)
  {
    $this->city = strtolower($city);
  }

  public function getState(): string 
  {
    return $this->state;
  }

  public function setState(string $state)
  {
    $this->state = strtolower($state);
  }

  public function getDistrict(): string 
  {
    return $this->district;
  }

  public function setDistrict(string $district)
  {
    $this->district = strtolower($district);
  }

  public function getCep(): string 
  {
    return $this->cep;
  }
  
  public function setCep(string $cep)
  {
    $this->cep = strtolower($cep);
  }

  public function toAddress(array $args = array())
  {
    if(!empty($args)){
      $this->setPublicPlace($args['public_place']);
      $this->setComplement($args['complement']);
      $this->setCep($args['cep']);
      $this->setDistrict($args['district']);
      $this->setCity($args['city']);
      $this->setNumber((int)$args['number']);
      $this->setState($args['state']);
    }
  }

  public function toData()
  {
    return [
      'public_place' => $this->getPublicPlace(),
      'complement' => $this->getComplement(),
      'number' => $this->getNumber(),
      'city' => $this->getCity(),
      'state' => $this->getState(),
      'district' => $this->getDistrict(),
      'cep' => $this->getCep(),
    ];
  }
}