<?php
namespace Acme\Tests;

use Acme\Http\Response;
use Acme\Http\Request;
use Acme\Validation\Validator;


class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    
    protected $request;
    protected $response;
    protected $validator;
    protected $testdata;
    
    protected function setUpRequestResponse() 
    {
        if ($this->testdata == null) {
            $this->testdata = [];
        }
        
        $this->request = new Request($this->testdata);
        $this->response = new Response($this->request);
        
        $this->validator = new Validator($this->request, $this->response);
    }
    
    public function testGetIsValidReturnsTrue()
    {
        $this->setUpRequestResponse();
        $this->validator->setIsValid(true);                
        
        $this->assertTrue($this->validator->getIsValid());        
    }
    
    public function testGetIsValidReturnsFalse()
    {
        $this->setUpRequestResponse();
        $this->validator->setIsValid(false);
        
        $this->assertFalse($this->validator->getIsValid());  
    }
    
    public function testCheckForMinStringLengthWithValidData()
    {
        $request = new Request(['mintype' => 'yellow']); //simulate a field with the name of mintype as a get variable, with the value yellow.
        $response = new Response($request);        
        $validator = new Validator($request, $response);
        
        $errors = $validator->check(['mintype' => 'min:3']);
        
        $this->assertCount(0, $errors); //lets make sure there are no errors with the rule and the field's value being tested.
    }
    
    public function testCheckForMinStringLengthWithInvalidData()
    {
        $request = new Request(['mintype' => 'x']); //simulate a field with the name of mintype as a get variable, with the value yellow.
        $response = new Response($request);        
        $validator = new Validator($request, $response);
        
        $errors = $validator->check(['mintype' => 'min:3']);
        
        $this->assertCount(1, $errors); //lets make sure there are no errors with the rule and the field's value being tested.
    }
    
    
    public function testCheckForEmailWithValidData()
    {
        $request = new Request(['mintype' => 'ladams@yahoo.com']); //simulate a field with the name of mintype as a get variable, with the value yellow.
        $response = new Response($request);        
        $validator = new Validator($request, $response);
        
        $errors = $validator->check(['mintype' => 'email']);
        
        $this->assertCount(0, $errors);            
    }
    
    public function testCheckForEmailWithInvalidData()
    {
        $request = new Request(['mintype' => 'whatever']); //simulate a field with the name of mintype as a get variable, with the value yellow.
        $response = new Response($request);        
        $validator = new Validator($request, $response);
        
        $errors = $validator->check(['mintype' => 'email']);
        
        $this->assertCount(1, $errors);
    }
}
