<?php
namespace Rolice\Econt;


use App;
use Config;
use Exception;
use SimpleXMLElement;
use Rolice\Econt\Exceptions\EcontException;

/**
 * Class Econt
 * Interface exported by this package to allow Econt integration.
 * @package Rolice\Econt
 * @version 0.1
 * @access public
 */
class Econt
{
    /**
     * The username of the Econt profile (whole platform account)
     * @var string
     */
    protected $username;

    /**
     * The password of the Econt profile (whole platform account)
     * @var string
     */
    protected $password;

    /**
     * The constructor for app::singleton instance. Internally set up username and password for use from config.
     */
    public function __construct()
    {
        $this->username = $this->username ?: Config::get('econt.username');
        $this->password = $this->password ?: Config::get('econt.password');
    }

    /**
     * Set credentials for API calls of Econt web methods. Caution: Plain text transfer.
     * This method is isolated as separate one to reduce transfer of sensitive information between the calls.
     * @param string $username The username in the Econt system, to be used in Econt operations
     * @param string $password The password corresponding to the Econt profile with the username above
     */
    public static function setCredentials($username, $password)
    {
        $self = App::make('Econt');
        $self->username = $username;
        $self->password = $password;
    }

    /**
     * Builds an Econt-compatible XML request
     * @param SimpleXMLElement $xml Currently scoped XML representation object.
     * @param array $data A user-defined, custom request structure for the XML file.
     * @return string Serialized result in XML format.
     */
    protected function build(SimpleXMLElement $xml, array $data)
    {
        foreach ($data as $key => $value) {
            if (!is_scalar($value)) {
                $nested = $xml->addChild($key);
                $this->build($nested, $value);
                continue;
            }

            $xml->addChild($key, $value);
        }
    }

    /**
     * Parses Econt response
     * @param string $response A raw response from Econt servers.
     * @return string Unserialized XML data in PHP
     * @throws EcontException
     */
    protected function parse($response)
    {
        if (!$response) {
            throw new EcontException('Empty response cannot be parsed.');
        }

        try {
            $xml = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
            $result = json_decode(json_encode((array)$xml), 1);
        } catch (Exception $e) {
            throw new EcontException('Failed To Parse XML response.');
        }

        return $result;
    }

    /**
     * Makes request to Econt servers (calls an end-point)
     * @param string $endpoint The end-point URL of the Econt server. Use Endpoint constants if applicable.
     * @param string $request The serialized XML content of the request.
     * @return string Raw response of the Econt servers to the given request.
     */
    protected function call($endpoint, $request)
    {
        $ch = curl_init($endpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['xml' => $request]);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public final function order(Sender $sender, Receiver $receiver, Shipment $shipment)
    {

    }

    public final function request($type, array $data = [])
    {
        ini_set('memory_limit', '2G');
        ini_set('max_execution_time', '0');

        $request = array_merge($data, [
            'client' => [
                'username' => $this->username,
                'password' => $this->password,
            ],
            'request_type' => $type,
        ]);

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><request/>');
        $this->build($xml, $request);
        $response = $this->parse($this->call(Endpoint::SERVICE, $xml->asXML()));

        if (isset($response['error'])) {
            $message = isset($response['error']['message']) ? $response['error']['message'] : null;
            $code = isset($response['error']['code']) ? $response['error']['code'] : null;

            throw new EcontException($message, $code);
        }

        return $response;
    }

    public final function zones()
    {
        $result = $this->request(RequestType::ZONES);

        if (!isset($result['zones']['e'])) {
            throw new EcontException('Could not receive correct zones.');
        }

        return $result['zones']['e'];
    }

    public final function settlements()
    {
        $result = $this->request(
            RequestType::CITIES,
            [RequestType::CITIES => ['id_zone' => 'all', 'report_type' => 'all']]
        );

        if (!isset($result['cities']['e'])) {
            throw new EcontException('Could not receive correct settlements.');
        }

        return $result['cities']['e'];
    }

    public final function regions()
    {
        $result = $this->request(RequestType::REGIONS);

        if (!isset($result['cities_regions']['e'])) {
            throw new EcontException('Could not receive correct regions.');
        }

        return $result['cities_regions']['e'];
    }

    public final function neighbourhoods()
    {
        $result = $this->request(RequestType::NEIGHBOURHOODS);

        if (!isset($result['cities_quarters']['e'])) {
            throw new EcontException('Could not receive correct neighbourhoods.');
        }

        return $result['cities_quarters']['e'];
    }

    public final function streets()
    {
        $result = $this->request(RequestType::STREETS);

        if (!isset($result['cities_street']['e'])) {
            throw new EcontException('Could not receive correct streets.');
        }

        return $result['cities_street']['e'];
    }

    public final function offices()
    {
        $result = $this->request(RequestType::OFFICES);

        if (!isset($result['offices']['e'])) {
            throw new EcontException('Could not receive correct streets.');
        }

        return $result['offices']['e'];
    }

}