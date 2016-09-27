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
        $this->testdata = ['mintype' => 'yellow'];
        $this->setUpRequestResponse();                       
        
        $errors = $this->validator->check(['mintype' => 'min:3']);
        
        $this->assertCount(0, $errors); //lets make sure there are no errors with the rule and the field's value being tested.
    }
    
    public function testCheckForMinStringLengthWithInvalidData()
    {        
        $this->testdata = ['mintype' => 'x'];
        $this->setUpRequestResponse();
        
        $errors = $this->validator->check(['mintype' => 'min:3']);
        
        $this->assertCount(1, $errors); //lets make sure there are no errors with the rule and the field's value being tested.
    }
    
    
    public function testCheckForEmailWithValidData()
    {
        $this->testdata = ['mintype' => 'ladams@yahoo.com'];
        $this->setUpRequestResponse();
        
        $errors = $this->validator->check(['mintype' => 'email']);
        
        $this->assertCount(0, $errors);            
    }
    
    public function testCheckForEmailWithInvalidData()
    {        
        $this->testdata = ['mintype' => 'whatever'];
        $this->setUpRequestResponse();
        
        $errors = $this->validator->check(['mintype' => 'email']);
        
        $this->assertCount(1, $errors);
    }
    
    
    public function testValidateWithValidData()
    {
        $this->testdata = ['check_field' => 'john@legere.com'];
        $this->setUpRequestResponse();
        
        $this->assertTrue($this->validator->validate(['check_field' => 'email'], '/error'));
    }
    
    
    public function testValidateWithInvalidData()
    {
        $this->testdata = ['check_field' => 'x'];
        $this->setUpRequestResponse();
        
        $this->validator->validate(['check_field' => 'email'], '/register');
    }
    
    
}
