<?php

require '../vendor/autoload.php';

use Certhis\Sdk\Web3Helper; 


// Initialize the Web3Helper instance
$web3Helper = new Web3Helper('0xfc3f00a1acf34b12b38a91c89fc502b4851ed6f053be087b88286490966c7db0');

echo "Public address: " . $web3Helper->getPublicKey() . "\n";

use Certhis\Sdk\Certhis;
use Certhis\Sdk\Sign;

$certhis = new Certhis();
$sign = new Sign($certhis);

$wallet = $web3Helper->getPublicKey();
$get_sign = $sign->get($wallet);

echo "Signature from certhis: " . $get_sign["signature"] . "\n";


$signed = $web3Helper->signMessage($get_sign["signature"]);

echo "Signed: " . $signed . "\n";

$check = $sign->check($wallet, $signed);
echo "Check: " . $check . "\n";
