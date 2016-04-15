<?php
require_once(__DIR__."/TerminalEmulationAutoload.php");

$TE = new TerminalEmulation();
$TE->initSoapClient($defaultOptions);
$client = $TE->getSoapClient();


//create session example
$getSessionMsg = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ter="http://www.travelport.com/schema/terminal_v33_0" xmlns:com="http://www.travelport.com/schema/common_v33_0"><soapenv:Header/><soapenv:Body><ter:CreateTerminalSessionReq AuthorizedBy="user" TargetBranch="'.$defaultOptions['targetbranch'].'" LanguageCode="EN" RetrieveProviderReservationDetails="true" Host="'.$defaultOptions['host'].'" SessionTimeout="'.$defaultOptions['connection_timeout'].'"><com:BillingPointOfSaleInfo OriginApplication="UAPI" /><com:OverridePCC ProviderCode="'.$defaultOptions['host'].'" PseudoCityCode="'.$defaultOptions['default_pcc'].'"/></ter:CreateTerminalSessionReq></soapenv:Body></soapenv:Envelope>';
$createTerminalSessionResponse = $client->__doRequest($getSessionMsg, $defaultOptions['target_url'], $defaultOptions['soap_action'], $defaultOptions['soap_version']);
//var_dump($createTerminalSessionResponse);


//send terminal command example
preg_match('@<[^\s]+hosttoken[\s\S]+>[^\s]+<\/[^\s]+hosttoken>@i', $createTerminalSessionResponse, $matches);
$sessionId_xmlContent = $matches[0];
$terminalCommand = 'terminal command';
$sendCommandMsg = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ter="http://www.travelport.com/schema/terminal_v33_0" xmlns:com="http://www.travelport.com/schema/common_v33_0"><soapenv:Header/><soapenv:Body><ter:TerminalReq AuthorizedBy="user" TargetBranch="'.$defaultOptions['targetbranch'].'" LanguageCode="EN" RetrieveProviderReservationDetails="true"><com:BillingPointOfSaleInfo OriginApplication="UAPI" />'.$sessionId_xmlContent.'<ter:TerminalCommand>'.$terminalCommand.'</ter:TerminalCommand></ter:TerminalReq></soapenv:Body></soapenv:Envelope>';

//send terminal command to the remote host
$response = $client->__doRequest($sendCommandMsg, $defaultOptions['target_url'], $defaultOptions['soap_action'], $defaultOptions['soap_version']);
$responseXml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $commandResponse);
$xmlObject = simplexml_load_string($responseXml);
//var_dump($xmlObject);


//end session example
$endSessionMsg = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ter="http://www.travelport.com/schema/terminal_v33_0" xmlns:com="http://www.travelport.com/schema/common_v33_0"><soapenv:Header/><soapenv:Body><ter:EndTerminalSessionReq AuthorizedBy="user" TargetBranch="'.$defaultOptions['targetbranch'].'" LanguageCode="EN" RetrieveProviderReservationDetails="true"><com:BillingPointOfSaleInfo OriginApplication="UAPI" /><com:HostToken Host="'.$defaultOptions['host']..'">'.$sessionId.'</com:HostToken></ter:EndTerminalSessionReq></soapenv:Body></soapenv:Envelope>';
$endTerminalSessionResponse = $client->__doRequest($endSessionMsg, $defaultOptions['value_url'], $defaultOptions['soap_action'], $defaultOptions['soap_version']);
//var_dump($endTerminalSessionResponse);