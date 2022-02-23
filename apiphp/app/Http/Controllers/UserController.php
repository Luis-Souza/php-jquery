<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

use App\Http\Models\User;
use App\Http\Models\Address;
use App\Responses\CustomResponses;
use App\Http\Repositories\Persistences\MongoUserRepository;

use App\Validation\Validator;

class UserController
{
    private $repository;
    private $validator;
    private $user;
    private $address;

    public function __construct(MongoUserRepository $mongo, Validator $validator)
    {
        $this->user = new User();
        $this->address = new Address();
        $this->repository = $mongo;
        $this->validator = $validator;
    }

    public function find(Request $request, Response $response, $name): Response
    {
        try{
            $result = $this->repository->findByName($name);
    
            if(!empty($result)){
                return CustomResponses::withDataEndMessage(
                    $response,
                    'Users with name: ' . strtoupper($name),
                    $result
                );
            }else {
                return CustomResponses::withMessage(
                    $response,
                    "User Not Found!"
                );
            }
        }catch(\Exception $e){
            return CustomResponses::withMessage(
                $response,
                "Error try again later!",
                500
            );
        }
    }

    public function listAll(Request $request, Response $response): Response
    {
        try{
            $result = $this->repository->listAll();

            if(!empty($result)){
                return CustomResponses::withDataEndMessage(
                    $response,
                    "All Users!",
                    $result
                );
            }else {
                return CustomResponses::withMessage(
                    $response,
                    "Users Not Found!",
                );
            }
        }catch(\Exception $e){
            return CustomResponses::withMessage(
                $response,
                "Error try again later!",
                500
            );
        }
    }

    public function store(Request $request, Response $response): Response
    {
        try{
            $data = $request->getParsedBody();

            $validation = $this->validator->validate($data, [
                'email' => v::notBlank()->noWhitespace(),
            ]);

            if($validation->failed()){
                return CustomResponses::withMessage(
                    $response,
                    "Campo e-mail é obrigatorio",
                    400
                );
            }

            $this->address->toAddress($data['address']);
            $this->user->toUser(
                [
                    'name' => $data['name'],
                    'last_name' => $data['last_name'],
                    'birth_date' => $data['birth_date'],
                    'email' => $data['email'],
                ],
                $this->address
            );
    
            $userAlreadyExists = $this->repository->findByEmail($data['email']);
            
            if(!empty($userAlreadyExists)){
                return CustomResponses::withMessage(
                    $response,
                    "User Already Exists!"
                );
            }
    
            $result = $this->repository->save($this->user);

            return CustomResponses::withDataEndMessage(
                $response,
                "User Created!",
                $result,
                201
            );
        }catch(\Exception $e){
            return CustomResponses::withMessage(
                $response,
                "Error try again later!",
                500
            );
        }
    }

    public function update(Request $request, Response $response): Response
    {
        try{
            $data = $request->getParsedBody();

            $validation = $this->validator->validate($data, [
                'email' => v::notBlank()->noWhitespace(),
            ]);

            if($validation->failed()){
                return CustomResponses::withMessage(
                    $response,
                    "Campo e-mail é obrigatorio",
                    400
                );
            }

            $this->address->toAddress($data['address']);
            $this->user->toUser(
                [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'last_name' => $data['last_name'],
                    'birth_date' => $data['birth_date'],
                    'email' => $data['email'],
                ],
                $this->address
            );

            $result = $this->repository->update($this->user);

            if(!empty($result)){
                return CustomResponses::withDataEndMessage($response, "Updated with success!", $result);
            }else {
                return CustomResponses::withMessage($response, "Error on update!");
            }
        }catch(\Exception $e){
            return CustomResponses::withMessage(
                $response,
                $e->getMessage(),
                500
            );
        }
    }

    public function delete(Request $request, Response $response, $id)
    {
        try{
            $result = $this->repository->delete($id);
    
            if($result > 0){
                return CustomResponses::withMessage(
                    $response,
                    "User deleted with success!"
                );
            }else {
                return CustomResponses::withMessage(
                    $response,
                    "User not exists!"
                );
            }
        }catch(\Exception $e){
            return CustomResponses::withMessage(
                $response,
                $e->getMessage(),
                500
            );
        }
    }
}