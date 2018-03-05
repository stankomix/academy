<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Bluefolder Class
 *
 * Make REST requests to Bluefolder with simple syntax.
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Joe Edwards, derived from SCH's original
 */
class BluefolderAPI {
	/**
	 * @property string $base_url
	 */
	protected $base_url = 'https://app.bluefolder.com/api/1.0/';
	/**
	 * @property string $apikey Without the trailing ':X'
	 */
	private $api_key = null;

	public function __construct($config = array())
	{
		$this->api_key = '6773dafd-4ff5-4c06-b485-ac0dcb2ab631';
		//$this->api_key = $this->_ci->config->item('bluefolder_apikey');
		if (empty($this->api_key))
		{
			throw new BluefolderAPI_Exception("Bluefolder Api Key not set!");
			// if you want show error properly then comment above line and uncomment following line (Nov 18 2011)
			//show_error("Bluefolder Api Key not set! ");
			exit(0);
		}

		log_message('debug', 'Bluefolder Class Initialized');

		// To override, re-call initialize() after instantiating.
		$config['server'] = $this->base_url;
		$config['http_auth'] = 'basic';
		$config['http_user'] = $this->api_key;
		$config['http_pass'] = 'X';

		//in case we need to clear the cache
		$this->bClearCache = FALSE;

	}


	/**
	 *
	 * @param string $customerID
	 * @return SimpleXMLElement $objCustomer
	 */
	function getCustomer($customerID)
	{
		$strURI = 'customers/get.aspx';

		$arRequest = array('customerID' => $customerID);
		$arResult = $this->postRequest($strURI, $arRequest);
		// will only ever be one customer.
		return isset($arResult['customer']) ? $arResult['customer'] : NULL;
	}

	function getCustomer_fh($customerID)
		{
			$strURI = 'customers/get.aspx';

			$arRequest = array('customerID' => $customerID, "customerList_fh" => true);
			$arResult = $this->postRequest($strURI, $arRequest);
			// will only ever be one customer.
			return isset($arResult['customer']) ? $arResult['customer'] : NULL;
		}

	/**
	 *
	 * @param string $equipmentID
	 * @return array of SimpleXMLElement equipment
	 */
	public function getEquipment($equipmentID)
	{
		$strURI = 'customers/getEquipment.aspx';

		$arRequest = array('equipmentItemID' => $equipmentID);
		//$this->bClearCache = TRUE;
		$arResult = $this->postRequest($strURI, $arRequest);
		// will only ever be one equipment item.

		if (isset($arResult['equipmentItem']))
		{
			//get any custom fields
			$lastServiceDate = $this->_getCustomField($arResult['equipmentItem'], 'LAST SERVICE DATE');
			$arResult['equipmentItem']->lastServiceDate = (string)$lastServiceDate;
			$quantity = $this->_getCustomField($arResult['equipmentItem'], 'quantity');
			$arResult['equipmentItem']->quantity = (string)$quantity;
			return $arResult['equipmentItem'];
		}

		return  NULL;
	}

	/**
	 *
	 * @param string $customerID
	 * @return array of SimpleXMLElement equipment
	 */
	public function getCustomerEquipment($customerID)
	{
		$objCustomer = $this->getCustomer($customerID);

		if ($objCustomer && $objCustomer->equipment) {
			return $this->_getXMLChildren($objCustomer->equipment, 'equipmentItem');
		}
		return NULL;
	}

	/**
	 *
	 * @param SimpleXMLElement instance
	 * @return array of SimpleXMLElement equipment
	 */
	public function getServiceRequestEquipment($objServiceRequest)
	{
		if ($objServiceRequest && $objServiceRequest->equipmentToService) {
			return $this->_getXMLChildren($objServiceRequest->equipmentToService, 'equipmentItem');
		}
		return NULL;
	}

	/**
	 *
	 * @param type $customerID
	 * @return array of SimpleXMLElement locations
	 */
	public function getCustomerLocations($customerID)
	{
		$objCustomer = $this->getCustomer($customerID);

		if ($objCustomer && $objCustomer->locations) {
			return $this->_getXMLChildren($objCustomer->locations, 'location');
		}
		return NULL;
	}


	/**
	 *
	 * @param SimpleXMLElement instance, string $strChildNameSpace
	 * @return array of SimpleXMLElement comments
	 */
	public function getServiceRequestComments(SimpleXMLElement &$objLog)
	{
		$arKeepers = array();
		if ($objLog && $objLog->logEntry)
		{
			//loop and get all - array of SXMLE logEntries
			foreach ($objLog->logEntry as $entries)
			{
				if ( ! empty($entries->comment_public))
					$arKeepers[] = $entries;
			}
		}
		return count($arKeepers) > 0 ? $arKeepers : NULL;
	}


	/**
	* if work order/service request has an equipment, match them up
	* @param object SimpleXMLElement customer
	* @return object of array of SimpleXMLElement Equipment and serviceRequests
	*
	*/
	public function getWorkOrdersAndEquipment($objCustomer)
	{
		$objData = new stdClass();

		$arServices = $this->getServiceRequestListByCustomerID((string)$objCustomer->customerID);
		//loop all workorders (aka service requests) and get all equipment ID's
		foreach ($arServices as $services)
		{
			$objSR = $this->getServiceRequest($services->serviceRequestID);
			if ($objSR['serviceRequest']->equipmentToService)
			{
				$equip = $this->getServiceRequestEquipment($objSR['serviceRequest']);
				foreach ($equip as $objEquip)
				{
					//due to getCustomerEquipment uses ID vs id
					$objEquip->ID = $objEquip->id;
					$objEquip->SRID = $services->serviceRequestID;
					$arEquipment[] = $objEquip;
				}
			}
		}

		$objData->arEquipment = $arEquipment;
		$objData->arServices = $arServices;
		return $objData;
	}

	/**
	 *
	 * @param int $iRoldID, string RoleType
	 * @return array of SXMLE appointment objects
	 */
	public function getUpcomingEquipmentServiceByRoleID($iRoleID, $strRoleType = 'customerID', $days = 31)
	{
		$arUpcoming = array();

		if (strcasecmp($strRoleType, 'customerID') == 0)
		{
			$objCustomer = $this->getCustomer($iRoleID);
			$objEquip = $this->getCustomerEquipment($objCustomer->customerID);

			if ($objEquip)
			{

				foreach($objEquip AS $equip)
				{
					//log_message('debug', '_getXMLChildren [l' . __LINE__ . ']: ' . print_r($equip, TRUE));
					//get past 30 days and newer
					if(strtotime($equip->nextServiceDate) > time() - (86400*$days))
					{
						//add billtoname
						$equip->customerName = $objCustomer->customerName;
						$arUpcoming[] = $equip;
					}

				}
			}
		}
		else
		{
			$arAllCustomers = $this->getCustomerList('full');
			foreach ($arAllCustomers as $objCustomer)
			{
				//get all the customer ID's
				if ($this->_getCustomField($objCustomer, $strRoleType) == $iRoleID)
				{
					$objEquip = $this->getCustomerEquipment($objCustomer->customerID);
					if ($objEquip)
					{
						foreach($objEquip AS $equip)
						{
							//log_message('debug', '_getXMLChildren [l' . __LINE__ . ']: ' . print_r($equip, TRUE));
							//get past 30 days and newer
							if(strtotime($equip->nextServiceDate) > time() - (86400*$days))
							{
								//add billtoname
								$equip->customerName = $objCustomer->customerName;
								$arUpcoming[] = $equip;
							}

						}
					}

				}
			}
		}


		return $arUpcoming;

	}


	/**
	 *
	 * @param int customer id $iCustomerID, string list type $strType
	 * @return array of SXMLE contract objects
	 */
	public function getContractListByCustomerID($iCustomerID, $strType = 'basic')
	{
		try
		{
			$strURI = 'contracts/list.aspx';
			// Ensure type is either 'full' or 'basic'
			$arRequest['listType'] = ($strType != 'full' ? 'basic' : 'full');
			$arRequest['customerID'] = $iCustomerID;
			return $this->postRequest($strURI, $arRequest);
		}
		catch (BluefolderAPI_DataNotFoundException $e)
		{
			return NULL;
			// if you want show error properly then comment above line and uncomment following line (Nov 18 2011)
			//show_error("Unable to load the requested driver: ");
			exit(0);
		}
	}

	/**
	 *
	 * @param SimpleXMLElement instance, string $strChildNameSpace
	 * @return array of XML children
	 */
	private function _getXMLChildren(SimpleXMLElement &$objCustomer, $strChildNameSpace)
	{
		$arData = array();
		foreach($objCustomer->{$strChildNameSpace} AS $objChild)
		{
			$arData[] = $objChild;
		}
		return $arData;
	}

	private function _getXMLChildren_fh_db(SimpleXMLElement &$objCustomer, $strChildNameSpace)
		{
			$arData = array();
			foreach($objCustomer->{$strChildNameSpace} AS $objChild)
				{
					$arData[] = $objChild;
				}
			return $arData;
		}

	/**
	 *
	 * @param SimpleXMLElement instance, string $strField (namespace)
	 * @return string field value
	 */
	public function _getCustomField(SimpleXMLElement &$objCustomer, $strField)
	{
		if ($objCustomer->customFields)
		{
			// find out how much time this buys if we do this via new endpoint in apiv2
			foreach ($objCustomer->customFields->customField as $objNameValue)
			{
				//log_message('debug', 'CustomField: ' . var_export($objNameValue, true));
				if ($objNameValue->name == $strField)
				{
					return $objNameValue->value;
				}
			}
		}
		return NULL;
	}


	/**
	 *
	 * @param type $iAppointmentID
	 * @return type
	 */
	public function getAppointment($iAppointmentID)
	{
		$strURI = 'appointments/get.aspx';
		$arRequest = array(
			'appointmentGet' => array('apptID' => $iAppointmentID)
		);

		$arResult = $this->postRequest($strURI, $arRequest); // cache 24h - reverted to default
		return isset($arResult['appointment']) ? $arResult['appointment'] : NULL;
	}

	/**
	 *
	 * @param DateTime $objRangeStart
	 * @param DateTime $objRangeEnd
	 * @return array $arResponse
	 */
	public function getAppointmentList(DateTime $objRangeStart, DateTime $objRangeEnd)
	{
		$strDateFormat = 'Y.m.d H:i';
		$strURI = 'appointments/list.aspx';

		$arRequest = array('appointmentList' => array(
			'dateRangeStart' => $objRangeStart->format($strDateFormat),
			'dateRangeEnd' => $objRangeEnd->format($strDateFormat)
		));
		//log_message('debug', __METHOD__ . " - Request: " . var_export($arRequest, true));
		//echo(__METHOD__ . " - Request: " . var_export($arRequest, true));
		$arResult = $this->postRequest($strURI, $arRequest); // cache for 60 min - reverted to default
		//echo(__METHOD__ . " - Result: " . var_export($arResult, true));

		return isset($arResult['appointment']) ? $arResult['appointment'] : NULL;
	}

	/**
	 *
	 * @param array $arFilters Asssociative array containing list filters.<br>
	 * Supported Filters (case sensitive):
	 * <ul>
	 *   <li>customerID: a customerID</li>
	 *   <li>customerName: customer name</li>
	 *   <li>status: a status value</li>
	 *   <li>billingStatus: a billing status value</li>
	 *   <li>invoiceNo: an invoice number</li>
	 *   <li>referenceNo: a reference number</li>
	 * </ul>
	 * @param string $strType [optional] Type of list to fetch. default: basic
	 * @param bool $bCustomerNameExactMatch default: true
	 * @return array $arResponse
	 */
	public function getServiceRequestList($arFilters, $strType = 'basic', $bCustomerNameExactMatch = true)
	{
		$strURI = 'serviceRequests/list.aspx';
		$arSupportedFilters = array('customerID', 'customerName',
			'status', 'billingStatus', 'invoiceNo', 'referenceNo');

		if (!is_array($arFilters))
		{
			throw new BluefolderAPI_Exception(__METHOD__ . ": arFilters must be an array.");
			// if you want show error properly then comment above line and uncomment following line (Nov 18 2011)
			//show_error(__METHOD__ . ": arFilters must be an array.");
			exit(0);
		}
		$arRequest = array();
		foreach ($arFilters as $k => $v)
		{
			// duplicate entries are ambiguous no effect here
			if (is_scalar($v) && in_array($k, $arSupportedFilters))
			{
				$arRequest[$k] = $v;
			}
		}

		// Ensure type is either 'full' or 'basic'
		$arRequest['listType'] = ($strType != 'full' ? 'basic' : 'full');

		// Set customerName exactMatch attribute
		if (isset($arRequest['customerName']))
		{
			$strExactMatch = $bCustomerNameExactMatch ? 'true' : 'false';
			$arRequest['customerName'] = array(
				'@attributes' => array('exactMatch' => $strExactMatch),
				'@value' => $arRequest['customerName']
			);
		}

		$arResult = $this->postRequest($strURI, $arRequest); // cache for 30 min - reverted to default
		if (isset($arResult['serviceRequestList']))
		{
			return $this->_getXMLChildren($arResult['serviceRequestList'], 'serviceRequest');
		} else {
			/*
			print('the bad request: ');
			print_r($arRequest);
			print('the bad response: ');
			print_r($arResult);
			*/
		}
		return NULL;
	}

	public function getServiceRequestListByCustomerID($customerID, $strType = 'basic')
	{
		$arRequest = array();
		if ($customerID != 0)
		{
			$arRequest['customerID'] = $customerID;
		}

		return $this->getServiceRequestList($arRequest, $strType);
	}

	public function getServiceRequestListByCustomerIDAndStatus($arRequest, $strType = 'basic')
	{
		try
		{
			return $this->getServiceRequestList($arRequest, $strType);
		}
		catch (BluefolderAPI_DataNotFoundException $e)
		{
			// Not all customers have serviceRequests.
		}

	}

	public function getServiceRequestListByCustomerName($customerName, $strType = 'basic', $bExactMatch = true)
	{
		$arRequest = array('customerName' => $customerName);
		return $this->getServiceRequestList($arRequest, $strType, $bExactMatch);
	}

	/**
	 *
	 * @param int $iRoldID, string RoleType
	 * @return array of SXMLE appointment objects
	 */
	public function getServiceRequestListByRoleID($iRoleID, $strRoleType = 'customerID', $strType = 'basic')
	{
		$arServiceRequests = array();
		if (strcasecmp($strRoleType, 'customerID') == 0)
		{
			$arRequest = array('customerID' => $iRoleID);
			$arResult = $this->getServiceRequestList($arRequest, $strType);
			$arServiceRequests = array_merge($arServiceRequests, $arResult);
		}
		else
		{
			$arAllCustomers = $this->getCustomerList('full');
			foreach ($arAllCustomers as $objCustomer)
			{
				//get all the customer ID's
				if ($this->_getCustomField($objCustomer, $strRoleType) == $iRoleID)
				{
					$arRequest = array('customerID' => (string) $objCustomer->customerID);
					try
					{
						$arResult = $this->getServiceRequestList($arRequest, $strType);
						if ($arResult !== NULL) {
							$arServiceRequests = array_merge($arServiceRequests, $arResult);
						}
					}
					catch (BluefolderAPI_DataNotFoundException $e)
					{
						// Not all customers have serviceRequests.
					}
				}
			}
		}
		return $arServiceRequests;
	}

	public function getServiceRequest($serviceRequestID)
	{
		$strURI = 'serviceRequests/get.aspx';
		$arRequest = array('serviceRequestID' => $serviceRequestID);
		return $this->postRequest($strURI, $arRequest);
	}

	/**
	 *
	 * @param string $strURI - api call
	 * @param array $arRequest - request params
	 * @param int $iCachePeriod  default: (60) 1min
	 * @return array $arResponse
	 * @throws BluefolderAPI_Exception
	 */
	protected function postRequest($strURI, $arRequest = array(), $iCachePeriod = 600) // 10mins
	{
		// convert array to xml
		$strReq = Array2XML::createXML('request', $arRequest)->saveXML();
		//$strReq = $this->xmlRequest($arRequest);
		//$logfile = fopen("error_log.txt", "a");
		//fwrite($logfile,
		//echo ("-------------------------------------------------------------------<br><br>Request:" . $strReq);
		//fwrite($logfile, "Request:" . $strReq);
		// Check cache
		$cache_token = 'bf_' . sha1(trim($_SESSION['cfp_customerName']).$strURI . '-' . $strReq);
		$bUseCache = ($iCachePeriod > 0 && $this->bClearCache == FALSE) ? TRUE : FALSE;

		//log_message('debug', 'bUseCache: '.$bUseCache);
		if(isset($arRequest["customerList_fh"]))
			{
				  $arResponse = $this->_ci->guzzler->post($strURI, $strReq);
				  //fwrite($logfile,
				  #echo ("<br><br>Response:<pre>");
				  #print_r($arResponse);
				  #exit();

				  if ($arResponse->getReasonPhrase() == 'OK')
					  {
							// bl4sted php lol
							$arResponseArr =
								(array) simplexml_load_string($arResponse->getBody()->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);
						  // only cache positive results
						  if ($bUseCache)
							  {
								  $this->_ci->cache->save($cache_token, json_encode($arResponseArr), $iCachePeriod);
							  }
						  return $arResponseArr;
					  }
				  else if ($arResponse->getReasonPhrase() == 'FAIL')
					  {
						  return NULL;
					  }
				  else // this is probably never entered now but we'll find out
					  {
						  $strError = isset($arResponse['error']) ? $arResponse['error'] : 'Unknown Error';
						  $iErrorCode = isset($arResponse['error']['code']) ? $arResponse['error']['code'] : NULL;
						  log_message('error', "Bluefolder API error: " . $strError);
						  //$this->_ci->rest->debug();
						  if ($iErrorCode)
							  {
								  throw new BluefolderAPI_DataNotFoundException($strError);
								  // if you want show error properly then comment above line and uncomment following line (Nov 18 2011)
								  //show_error($strError);
								  exit(0);
							  }
						  else
							  {
								  return $arResponse;

			  /*					throw new BluefolderAPI_Exception($strError);
								  // if you want show error properly then comment above line and uncomment following line (Nov 18 2011)
								  //show_error($strError);
								  exit(0);
			  */
							  }
					  }
			}
		else
			{
				if ($bUseCache && ($xmlStrBuffer = $this->_ci->cache->get($cache_token)))
					{
						return (array) simplexml_load_string($xmlStrBuffer, 'SimpleXMLElement', LIBXML_NOCDATA);
						//return $this->_ci->rest->_xml($string);
					}
				else
					{
						$arResponse = $this->_ci->guzzler->post($strURI, $strReq);
						//fwrite($logfile,
						#echo ("<br><br>Response:<pre>");
						#print_r($arResponse);
						#exit();

						if ($arResponse->getReasonPhrase() == 'OK')
							{
								//log_message('debug', 'guzzler REQ body='.json_encode($arRequest));
								//log_message('debug', 'guzzler RES uri='.$strURI.' popd from promise stack at '.date("Y-m-d H:i:s"));

								// WARNING: this dumb function does not persist its return
								$xmlStrBuffer = $arResponse->getBody()->getContents();

								$arResponseArr =
									(array) simplexml_load_string($xmlStrBuffer, 'SimpleXMLElement', LIBXML_NOCDATA);

								// only cache positive results
								if ($bUseCache)
									{
										$saved = $this->_ci->cache->save($cache_token, $xmlStrBuffer, $iCachePeriod);
										log_message('debug', 'save cache_token='.$cache_token.' returned '.$saved);
									}
								return $arResponseArr;
							}
						else
							{
								$strError = isset($arResponse['error']) ? $arResponse['error'] : 'Unknown Error';
								$iErrorCode = isset($arResponse['error']['code']) ? $arResponse['error']['code'] : NULL;
								log_message('error', "Bluefolder API error: " . $strError);
								//$this->_ci->rest->debug();
								if ($iErrorCode)
									{
										throw new BluefolderAPI_DataNotFoundException($strError);
										// if you want show error properly then comment above line and uncomment following line (Nov 18 2011)
										//show_error($strError);
										exit(0);
									}
								else
									{
										return $arResponse;

					/*					throw new BluefolderAPI_Exception($strError);
										// if you want show error properly then comment above line and uncomment following line (Nov 18 2011)
										//show_error($strError);
										exit(0);
					*/
									}
							}
					}
			}
	}

	public function getUpcomingAppointments(DateTime $objRangeStart, DateTime $objRangeEnd)
	{
		$strDateFormat = 'Y.m.d H:i';
		$strURI = 'appointments/list.aspx';

		$arRequest = array('appointmentList' => array(
			'dateRangeStart' => $objRangeStart->format($strDateFormat),
			'dateRangeEnd' => $objRangeEnd->format($strDateFormat)
		));
		//log_message('debug', __METHOD__ . " - Request: " . var_export($arRequest, true));
		//echo(__METHOD__ . " - Request: " . var_export($arRequest, true));
		$arResult = $this->postRequest($strURI, $arRequest);
		//echo(__METHOD__ . " - Result: " . var_export($arResult, true));

		return isset($arResult['appointment']) ? $arResult['appointment'] : NULL;
	}

	public function getUpcomingServices($start, $end)
	{

		$arUpcoming = array();
		//$counter = 1;
		$arAllCustomers = $this->getCustomerList();  //('full');
		//$totalCustCount = count($arAllCustomers);

		foreach ($arAllCustomers as $objCustomer)
		{

			$objEquip = $this->getCustomerEquipment($objCustomer->customerID);
			if ($objEquip)
			{
				foreach($objEquip AS $equip)
				{
					//print_r($equip);
					//log_message('debug', '_getXMLChildren [l' . __LINE__ . ']: ' . print_r($equip, TRUE));
					if(strtotime($equip->nextServiceDate) > $start && strtotime($equip->nextServiceDate) < $end)
					{
						//add billtoname
						$equip->customerName = $objCustomer->customerName;
						$arUpcoming[] = $equip;
					}

				}
			}
				//if($counter=='100') break; //for testing other wise ther server response time gets out.
				//$counter++;
		}

		return $arUpcoming;

	}


	public function getexpiredWorkOrders()
	{
			$arRequest = array();
			$arRequest['status'] = "closed"; //??? expired??
			$this->getServiceRequestListByCustomerIDAndStatus($arRequest); //($arRequest,'full');

	}

	/**
	 * Convert array to a well-formed XML document.
	 * Element attributes are not supported in this version.
	 *
	 * @param string $root_element_name
	 * @param array $ar Nested associative array representing XML structure.
	 * @return string XML Document
	 */
	public function xmlRequest($ar)
	{
		return Array2XML::createXML('request', $ar)->saveXML();
		//return $objDomDocument->saveXML();
	}

}

class BluefolderAPI_Exception extends Exception {

}

class BluefolderAPI_DataNotFoundException extends BluefolderAPI_Exception {

}
