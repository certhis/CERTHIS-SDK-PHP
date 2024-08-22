# Certhis PHP SDK

The Certhis PHP SDK allows you to easily interact with the Certhis API. This SDK provides functionality to sign messages and more.

## Requirements

- PHP 7.4 or higher
- Composer for managing dependencies
- The `kornrunner/keccak` library for hashing
- The `simplito/elliptic-php` library for elliptic curve operations

## Installation

To use the Certhis SDK in your project, you'll need to install it via Composer. If you don't have Composer installed, you can download it from [getcomposer.org](https://getcomposer.org).

```bash
composer require "certhis/sdk"
```

### 1. `Web3Helper::__construct($privateKey)`
- **Purpose**: Initializes the `Web3Helper` instance with a given private key. This key is used for cryptographic operations such as signing messages.
- **Parameters**:
  - `$privateKey`: A string representing the private key used for cryptographic operations.

### 2. `Web3Helper::getPublicKey()`
- **Purpose**: Retrieves the public address associated with the private key provided during the initialization of the `Web3Helper` instance.
- **Returns**: A string representing the public address.

### 3. `Certhis::__construct($api = 'https://api.certhis.io', $apikey = null)`
- **Purpose**: Initializes the `Certhis` class, which serves as the main entry point for interacting with the Certhis API.
- **Parameters**:
  - `$api` (optional): The base URL of the Certhis API. Defaults to `'https://api.certhis.io'`.
  - `$apikey` (optional): The API key used for authentication when making requests to the Certhis API. If not provided, the API key must be set later or within the environment.

### 4. `Sign::__construct($certhis)`
- **Purpose**: Initializes the `Sign` class, responsible for handling the signing and verification processes.
- **Parameters**:
  - `$certhis`: An instance of the `Certhis` class, used to interact with the Certhis API.

### 5. `Sign::get($wallet)`
- **Purpose**: Retrieves a signature from the Certhis API for a given wallet (public address).
- **Parameters**:
  - `$wallet`: The public address for which the signature is requested.
- **Returns**: An associative array containing the signature.

### 6. `Web3Helper::signMessage($message)`
- **Purpose**: Signs a message using the private key associated with the `Web3Helper` instance.
- **Parameters**:
  - `$message`: The message string to be signed.
- **Returns**: The signed message.

### 7. `Sign::check($wallet, $signedMessage)`
- **Purpose**: Verifies that the signed message corresponds to the original signature retrieved from the Certhis API.
- **Parameters**:
  - `$wallet`: The public address used to generate the original signature.
  - `$signedMessage`: The signed message to be verified.
- **Returns**: A boolean value indicating whether the signed message is valid.


## Integration Example

Below is an example of how to integrate the Certhis SDK into your PHP project:

```php
require '../vendor/autoload.php';

use Certhis\Sdk\Web3Helper; 
use Certhis\Sdk\Certhis;
use Certhis\Sdk\Sign;

// Initialize the Web3Helper instance with a private key
$web3Helper = new Web3Helper('0xfc3f00a1acf34b12b38a91c89fc502b4851ed6f053be087b88286490966c7db0');
echo "Public address: " . $web3Helper->getPublicKey() . "\n";

// Initialize the Certhis class with an API key
$certhis = new Certhis('https://api.certhis.io', 'your_api_key');

// Initialize the Sign class with the Certhis instance
$sign = new Sign($certhis);

// Get the public address from the Web3Helper
$wallet = $web3Helper->getPublicKey();

// Retrieve a signature from Certhis API for the given wallet
$get_sign = $sign->get($wallet);
echo "Signature from Certhis: " . $get_sign["signature"] . "\n";

// Sign the retrieved message using Web3Helper
$signed = $web3Helper->signMessage($get_sign["signature"]);
echo "Signed Message: " . $signed . "\n";

// Verify the signed message using the Certhis Sign class
$check = $sign->check($wallet, $signed);
echo "Signature Verification Result: " . ($check ? "Valid" : "Invalid") . "\n";
