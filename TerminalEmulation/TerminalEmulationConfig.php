<?php
/**
 * File to load default options
 * @package TerminalEmulation
 * @version 20150429-01
 * @date 2015-10-23
 */
$defaultOptions = array(
	'login' => 'Universal API login',
	'password' => 'password',
	'target_url' => 'https://emea.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/TerminalService',
	'wsdl' => __DIR__.'/schema/terminal_v33_0/Terminal.wsdl',
	'targetbranch' => 'target branch',
	'soap_version' => 'soap version',
	'soap_action' => 'soap action',
	'host' => '1G - for example',
	'connection_timeout' => 'session timeout in milliseconds (optional)',
	'default_pcc' => 'pcc to override, if need (optional)'
);