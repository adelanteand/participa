<?php
function subirFlickr($ruta,$descripcion="Subida automáticamente", $etiquetas="Bot") {


    $token = new \OAuth\OAuth1\Token\StdOAuth1Token();
    $token->setAccessToken(FLICKR_OAUTH_TOKEN);
    $token->setAccessTokenSecret(FLICKR_OAUTH_VERIFIER);
    $storage = new \OAuth\Common\Storage\Memory();
    $storage->storeAccessToken('Flickr', $token);

    // Create PhpFlickr.
    $phpFlickr = new \Samwilson\PhpFlickr\PhpFlickr(FLICKR_KEY, FLICKR_SECRET);

    // Give PhpFlickr the storage containing the access token.
    $phpFlickr->setOauthStorage($storage);

    // Make a request.
    $result = $phpFlickr->uploader()->upload($ruta, 'Fotografía', $descripcion, $etiquetas, true, true, true);
    $info = $phpFlickr->photos()->getInfo($result['photoid']);

    return $info['urls']['url'][0]['_content'];
}
