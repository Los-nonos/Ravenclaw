<?php


namespace Infrastructure\Afip\Services;


use Exception;
use Infrastructure\Afip\Afip;
use SoapClient;

/**
 * Base class for AFIP web services
 *
 * @since 0.5
 *
 * @package Afip
 * @author 	Afip SDK afipsdk@gmail.com
 **/
class AfipWebService
{
    /**
     * Web service SOAP version
     *
     * @var string
     **/
    var $soap_version;

    /**
     * File name for the Web Services Description Language
     *
     * @var string
     **/
    var $WSDL;

    /**
     * The url to web service
     *
     * @var string
     **/
    var $URL;

    /**
     * File name for the Web Services Description
     * Language in test mode
     *
     * @var string
     **/
    var $WSDL_TEST;

    /**
     * The url to web service in test mode
     *
     * @var string
     **/
    var $URL_TEST;

    /**
     * The Afip parent Class
     *
     * @var Afip
     **/
    var $afip;

    function __construct($afip)
    {
        $this->afip = $afip;

        if ($this->afip->options['production'] === TRUE) {
            $this->WSDL = __DIR__.'/Afip_res/'.$this->WSDL;
        } else {
            $this->WSDL = __DIR__.'/Afip_res/'.$this->WSDL_TEST;
            $this->URL 	= $this->URL_TEST;
        }

        if (!file_exists($this->WSDL))
            throw new Exception("Failed to open ".$this->WSDL."\n", 3);
    }

    /**
     * Sends request to AFIP servers
     *
     * @since 1.0
     *
     * @param string 	$operation 	SOAP operation to do
     * @param array 	$params 	Parameters to send
     *
     * @return mixed Operation results
     **/
    public function ExecuteRequest($operation, $params = array())
    {
        if (!isset($this->soap_client)) {
            $this->soap_client = new SoapClient($this->WSDL, array(
                'soap_version' 	=> $this->soap_version,
                'location' 		=> $this->URL,
                'trace' 		=> 1,
                'exceptions' 	=> 0
            ));
        }

        $results = $this->soap_client->{$operation}($params);

        $this->_CheckErrors($operation, $results);

        return $results;
    }

    /**
     * Check if occurs an error on Web Service request
     *
     * @since 1.0
     *
     * @param string 	$operation 	SOAP operation to check
     * @param mixed 	$results 	AFIP response
     *
     * @throws Exception if exists an error in response
     *
     * @return void
     **/
    private function _CheckErrors($operation, $results)
    {
        if (is_soap_fault($results))
            throw new Exception("SOAP Fault: ".$results->faultcode."\n".$results->faultstring."\n", 4);
    }
}
