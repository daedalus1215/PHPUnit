<?php
namespace Acme\Controllers;

use Acme\Interfaces\ControllerInterface;
use duncan3dc\Laravel\BladeInstance;
use Kunststube\CSRFP\SignatureGenerator;
use Acme\Http\Response;
use Acme\Http\Request;
use Acme\Http\Session;

/**
 * Class BaseController
 * @package Acme\Controllers
 */
class BaseControllerWithDI implements ControllerInterface {

    protected $blade;
    protected $signer;
    public $response;
    public $request;


    public function __construct(
            Request $request, 
            \Acme\Http\Response $response, 
            \Acme\Http\Session $session,
            \Kunststube\CSRFP\SignatureGenerator $signer,
            BladeInstance $blade, 
            $type = 'text/html'
    ){
        $this->signer = $signer;
        $this->blade = $blade;
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
    }

}
