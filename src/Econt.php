<?php
namespace Rolice\Econt;

use App;
use Config;

use Rolice\Econt\Component\Receiver;
use Rolice\Econt\Component\Sender;
use Rolice\Econt\Component\Shipment;
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
     * @param string $type A type of the Econt request. Use RequestType constants if possible.
     * @param array $data A user-defined, custom request structure of the XML file.
     * @param string $root The name of the root XML element.
     * @return string Serialized result in XML format.
     * @throws EcontException
     */
    protected static function build(array $data, $type = RequestType::NONE, $root = null)
    {
        $data['client'] = [
            'username' => self::$username,
            'password' => self::$password,
        ];
        $data['system'] = [
            'validate' => 0,
            'response_type' => 'XML',
        ];

        if ($type) {
            $data['request_type'] = $type;
        }

        // Serialization

        $options = [
            "indent" => "\t",
            "linebreak" => "\n",
            "rootName" => $root ?: $type,
            "addDecl" => true,
            "addDoctype" => false,
            "doctype" => [
                'uri' => 'http://pear.php.net/dtd/package-1.0',
                'id' => '-//PHP//PEAR/DTD PACKAGE 0.1'
            ],
        ];

        $serializer = new XML_Serializer($options);
        $status = $serializer->serialize($data);

        if (PEAR::isError($status)) {
            throw new EcontException('Failed serialize registration request.');
        }

        return $serializer->getSerializedData();
    }

    /**
     * Parses Econt response
     * @param string $response A raw response from Econt servers.
     * @return string Unserialized XML data in PHP
     * @throws EcontException
     */
    protected static function parse($response)
    {
        $parser = new XML_Unserializer();
        $status = $parser->unserialize($response);

        if (PEAR::isError($status)) {
            throw new EcontException('Failed serialize registration request.');
        }

        $result = $parser->getUnserializedData();

        if (isset($result['error'])) {
            $message = isset($result['error']['message']) ? $result['error']['message'] : '';
            $code = isset($result['error']['code']) ? $result['error']['code'] : '';

            throw new EcontException($message, $code);
        }

        return $result;
    }

    /**
     * Makes request to Econt servers
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

    public final static function test()
    {
        $result = self::build(RequestType::PROFILE, []);
        $result = self::parse(self::request(Endpoint::SERVICE, $result, 'service_types'));

        return $result;
    }

    public final function order(Sender $sender, Receiver $receiver, Shipment $shipment)
    {

    }

    public final function request($type, $data)
    {
        $request = [
            'client' => [
                'username' => $this->username,
                'password' => $this->password,
            ],

            'request_type' => $type,

            $data
        ];

        die(var_dump($request));
    }
}