<?php

namespace Certhis\Sdk;

use kornrunner\Keccak;
use Elliptic\EC;

class Web3Helper
{

    private string $storedPrivateKey;

    //constructor
    public function __construct($privateKey)
    {
       $this->storedPrivateKey = $privateKey;
    }


    //function get public key
    public function getPublicKey()
    {
        $privateKey = $this->storedPrivateKey;
        $ec = new EC('secp256k1');
        $keyPair = $ec->keyFromPrivate($privateKey);
        $publicKey = $keyPair->getPublic(false, 'hex');
        $publicKey = substr($publicKey, 2);
        $hash = Keccak::hash(hex2bin($publicKey), 256);
        $address = '0x' . substr($hash, -40);
        return strtolower($address);
    }


    public function privateKeyToPublicKey(string $privateKey): string
    {
        // Supprimer le préfixe '0x' s'il existe
        $privateKey = preg_replace('/^0x/', '', $privateKey);

        // Créer une instance de la courbe elliptique secp256k1
        $ec = new EC('secp256k1');

        // Générer la paire de clés à partir de la clé privée
        $keyPair = $ec->keyFromPrivate($privateKey);

        // Obtenir la clé publique (non compressée)
        $publicKey = $keyPair->getPublic(false, 'hex');

        // Supprimer le premier octet (04) qui indique une clé non compressée
        $publicKey = substr($publicKey, 2);

        // Calculer le hash Keccak-256 de la clé publique
        $hash = Keccak::hash(hex2bin($publicKey), 256);

        // Prendre les 40 derniers caractères du hash pour obtenir l'adresse
        $address = '0x' . substr($hash, -40);

        return strtolower($address);
    }
    public function signMessage(string $message): string
    {
        // Supprimer le préfixe '0x' de la clé privée s'il existe
        $privateKey = preg_replace('/^0x/', '', $this->storedPrivateKey);

        // Créer une instance de la courbe elliptique secp256k1
        $ec = new EC('secp256k1');

        // Générer la paire de clés à partir de la clé privée
        $keyPair = $ec->keyFromPrivate($privateKey);

        // Préfixer le message selon le standard Ethereum
        $prefixedMessage = "\x19Ethereum Signed Message:\n" . strlen($message) . $message;

        // Calculer le hash Keccak-256 du message préfixé
        $messageHash = Keccak::hash($prefixedMessage, 256);

        // Signer le hash du message
        $signature = $keyPair->sign($messageHash, ['canonical' => true]);

        // Récupérer les composants de la signature
        $r = str_pad($signature->r->toString(16), 64, '0', STR_PAD_LEFT);
        $s = str_pad($signature->s->toString(16), 64, '0', STR_PAD_LEFT);
        $v = dechex($signature->recoveryParam + 27);

        // Assembler la signature complète
        $signedMessage = '0x' . $r . $s . $v;

        return $signedMessage;
    }
}