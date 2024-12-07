<?php declare(strict_types=1);
namespace openvk\Web\Util;

class ActivityPubChecker
{
    function activityPubCheckRequest(string $publicKey): bool {
        // We need a key... We should check for that in db but todo yess
        // Also we need to sign GET request but that todo yet
        $signatureHeader = parse_str(str_replace([', ', '"'], ['&', ''], $_SERVER['HTTP_SIGNATURE']), $result);
        $ch = curl_init($signatureHeader['keyId']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $actor = json_decode($response);
        $actorPublicKey = $actor['publicKey']['publicKeyPem'];
        // Now we have public key! Yay :D
        $headersToSign = explode(" ", $signatureHeader['headers']);
        foreach($header as $headersToSign) {
            echo $header;
        }
        return false;
    }
}
