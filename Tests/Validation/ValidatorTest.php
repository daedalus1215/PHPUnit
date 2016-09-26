<?php
namespace Acme\Tests;

use Acme\Http\Response;
use Acme\Http\Request;
use Acme\Validation\Validator;


class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetIsValidReturnsTrue()
    {
        $request = new Request([]);
        $response = new Response($request);
        
        $validator = new Validator($request, $response);
        
        $validator->setIsValid(true);
        
        $this->assertTrue($validator->getIsValid());        
    }
    
    public function testGetIsValidReturnsFalse()
    {
        $request = new Request([]);
        $response = new Response($request);        
        $validator = new Validator($request, $response);
        
        $validator->setIsValid(false);
        
        $this->assertFalse($validator->getIsValid());  
    }
    
    public function testCheckForMinStringLengthWithValidData()
    {
        $request = new Request(['mintype' => 'yellow']); //simulate a field with the name of mintype as a get variable, with the value yellow.
        $response = new Response($request);        
        $validator = new Validator($request, $response);
        
        $errors = $validator->check(['mintype' => 'min:3']);
        
        $this->assertCount(0, $errors); //lets make sure there are no errors with the rule and the field's value being tested.
    }
}
