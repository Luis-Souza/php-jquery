<?php

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator {

  protected $erros;

  public function validate($data, array $rules)
  {
    foreach($rules as $field => $rule) {
      try{
        $rule->setName(ucfirst($field))->assert($data[$field]);

      }catch(NestedValidationException $e) {
        $this->erros[$field] = $e->getFullMessage();
      }

      return $this;
    }
  }

  public function getErros()
  {
    return $this->erros;
  }

  public function failed() 
  {
    return !empty($this->erros);
  }
}