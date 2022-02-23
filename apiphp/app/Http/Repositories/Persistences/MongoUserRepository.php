<?php

namespace App\Http\Repositories\Persistences;

use App\Http\Models\User;
use App\Config\DBConnection;
use App\Http\Repositories\iUserRepository;

use MongoDB\BSON\ObjectID;

class MongoUserRepository implements iUserRepository {
  private $dbConnection;
  
  public function __construct(DBConnection $db)
  {
    $this->dbConnection = $db->getConnection()->selectDatabase('backend');
  }

  public function save(User $user)
  {
    $data = [
      'name'       => $user->getName(),
      'last_name'  => $user->getLastName(),
      'email'      => $user->getEmail(),
      'birth_date' => $user->getBirthDate(),
      'address'    => $user->getAddress()->toData()
    ];

    $collection = $this->dbConnection->selectCollection('users');
    $result = $collection->insertOne($data);

    if($result->getInsertedId()){
      return $data;
    }

    return [];
    
  }

  public function update(User $user)
  {
    $data = [
      'name'       => $user->getName(),
      'last_name'  => $user->getLastName(),
      'email'      =>  $user->getEmail(),
      'birth_date' => $user->getBirthDate(),
      'address'    => $user->getAddress()->toData()
    ];

    $collection = $this->dbConnection->selectCollection('users');

    $idBson = new ObjectID($user->getId());

    $updateResult = $collection->updateOne(
      ['_id' => $idBson],
      ['$set' => $data]
    );

    if($updateResult->getMatchedCount()>0){
      return $user->toData();
    }

    return [];
  }

  public function delete($id)
  {
    $deleteResult = $this->dbConnection->selectCollection('users')
      ->deleteOne(["_id" => new ObjectID($id)]);

    if($deleteResult->getDeletedCount() > 0){
      return true;
    }

    return false;
  }

  public function findByName(string $name)
  {
    $data = $this->dbConnection->selectCollection('users')->find(["name" => $name]);

    $users = [];
    foreach($data as $obj){
      array_push($users,$this->parseObjectMongoToData($obj));
    }

    if(empty($users)){
      return [];
    }

    return $users;
  }

  public function findByEmail(string $email)
  {
    $data = $this->dbConnection->selectCollection('users')
      ->findOne(['email' => $email]);

    if(is_null($data)){
      return null;
    }
    return $data;
  }

  public function listAll()
  {
    $data = $this->dbConnection->selectCollection('users')->find();

    $users = [];
    foreach($data as $obj){
      array_push($users, $this->parseObjectMongoToData($obj));
    }
    
    return $users;
  }

  private function parseObjectMongoToData($object)
  {
    return [
      'id' => $object['_id'].$oid,
      'name' => $object['name'],
      'last_name' => $object['last_name'],
      'email' => $object['email'],
      'birth_date' => $object['birth_date'],
      'address' => [
        'public_place' => $object['address']['public_place'],
        'complement'   => $object['address']['complement'],
        'number'       => $object['address']['number'],
        'city'         => $object['address']['city'],
        'state'        => $object['address']['state'] ,
        'cep'          => $object['address']['cep'],
        'district'     => $object['address']['district'],
      ],
    ];
  }
}