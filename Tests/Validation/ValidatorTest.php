<?php
namespace Acme\Tests;

//use Acme\Http\Response;
//use Acme\Http\Request;
use Acme\Validation\Validator;
use Kunststube\CSRFP\SignatureGenerator;
use Dotenv;
use duncan3dc\Laravel\BladeInstance;


class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    
    protected $request;
    protected $response;
    protected $validator;
    protected $session;
    protected $blade;
    
    protected function setUp()
    {
        $signer = $this->getMockBuilder('Kunststube\CSRFP\SignatureGenerator')
                ->setConstructorArgs(['abc123'])
                ->getMock();
        
        $this->request = $this->getMockBuilder('Acme\Http\Request')
                ->getMock();
        
        $this->session = $this->getMockBuilder("Acme\Http\Session")
                ->getMock();
        
        $this->blade = $this->getMockBuilder("duncan3dc\Laravel\BladeInstance")
                ->setConstructorArgs(['abc123', 'abc'])
                ->getMock();
                
        $this->response = $this->getMockBuilder('Acme\Http\Response')
                ->setConstructorArgs([$this->request, $signer, $this->blade, $this->session])
                ->getMock();            
    }   
    
    public function getReq($input = "")
    {
        $req = $this->getMockBuilder('Acme\Http\Request')
                ->getMock();
        
        // essentially, The Acme\Http\Request object has a method, called 'input'.
        // and input takes a value (yellow) and grabs it from the global session.
        // we are simulating that.
        $req->expects($this->once())
                ->method('input')
                ->will($this->returnValue($input));
        
        return $req;
    }
    
    
    public function testGetIsValidReturnsTrue()
    {
        $this->setUp();
        $validator = new Validator($this->request, $this->response, $this->blade);
        $validator->setIsValid(true);
        $this->assertTrue($validator->getIsValid());        
    }
//    
    public function testGetIsValidReturnsFalse()
    {
        $this->setUp();
        $validator = new Validator($this->request, $this->response);
        $validator->setIsValid(false);
        $this->assertFalse($validator->getIsValid());  
    }
//    
    public function testCheckForMinStringLengthWithValidData()
    {  
        $this->setUp();
        $req = $this->getReq("yellow");
        $validator = new Validator($req, $this->response);
        $errors = $validator->check(['mintype' => 'min:3']);
        
        $this->assertCount(0, $errors); //lets make sure there are no errors with the rule and the field's value being tested.
    }
//    
    public function testCheckForMinStringLengthWithInvalidData()
    {                  
        $this->setUp();
        $req = $this->getReq("x");
        $validator = new Validator($req, $this->response);
        $errors = $validator->check(['mintype' => 'min:3']);
        
        $this->assertCount(1, $errors); //lets make sure there are no errors with the rule and the field's value being tested.
    }
//    
//    
    public function testCheckForEmailWithValidData()
    {
        $this->setUp();
        $req = $this->getReq('ladams@yahoo.com');                
        $validator = new Validator($req, $this->response);
        $errors = $validator->check(['mintype' => 'email']);
        
        $this->assertCount(0, $errors);
    }
    
    public function testCheckForEmailWithInvalidData()
    {                
        $this->setUp();
        $req = $this->getReq('whatever');
        $validator = new Validator($req, $this->response);
        
        $errors = $validator->check(['mintype' => 'email']);
        
        $this->assertCount(1, $errors);
    }
    
    public function testValidateWithValidData()
    {
        $this->setUp();
        $req = $this->getReq('ladams@yahoo.com');                
        $validator = new Validator($req, $this->response);
        
        $this->assertTrue($validator->validate(['check_field' => 'email'], '/error'));
    }


    public function testValidateWithInvalidData()
    {        
        $this->setUp();
        $this->getReq('ladams@yahoo.com');
        $validator = new Validator($req, $this->response);
        
        $validator->validate(['check_field' => 'email'], '/register');
    }


}
