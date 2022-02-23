<?php
namespace App\Http\Models;

use App\Http\Models\Address;

class User {
  private ?string $id;
  private string $name;
  private string $lastName;
  private string $birthDate;
  private string $email;
  private Address $address;

  public function getId(): string 
  {
    return $this->id ?? '';
  }

  public function setId(string $id)
  {
    $this->id = $id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setName(string $name)
  {
    $this->name = strtolower($name);
  }

  public function getLastName(): string
  {
    return $this->lastName;
  }

  public function setLastName(string $lastName)
  {
    $this->lastName = strtolower($lastName);
  }

  public function getBirthDate(): string
  {
    return $this->birthDate;
  }

  public function setBirthDate(string $birthDate)
  {
    $this->birthDate = strtolower($birthDate);
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function setEmail(string $email)
  {
    $this->email = strtolower($email);
  }

  public function getAddress(): Address
  {
    return $this->address;
  }

  public function setAddress(Address $address)
  {
    $this->address = $address;
  }

  public function toUser(array $args = array(), Address $address)
  {
    if(!empty($args) || isset($address)){
      if(isset($args['id'])){
        $this->setId($args['id']);
      }
      $this->setName($args['name']);
      $this->setLastName($args['last_name']);
      $this->setBirthDate($args['birth_date']);
      $this->setEmail($args['email']);
      $this->setAddress($address);
    }
  }

  public function toData()
  {
    return [
      'id' => $this->getId(),
      'name' => $this->getName(),
      'last_name' => $this->getLastName(),
      'email' => $this->getEmail(),
      'birth_date' => $this->getBirthDate(),
      'address' => $this->getAddress()->toData(),
    ];
  }
}