<?php
App::import('Vendor', 'OAuth/OAuthClient');

class GoogleUsersController extends AppController {
    
    public function index() {
        $client = $this->createClient();
        $REQUEST_TOKEN_URL = 'https://www.google.com/accounts/OAuthGetRequestToken';
        $CALLBACK_URL = 'http://www.dev.thinkshare.it/cakephp/google_users/callback';
        $requestToken = $client->getRequestToken($REQUEST_TOKEN_URL, $CALLBACK_URL, 'GET', array('scope' => 'https://www.google.com/m8/feeds'));

        if ($requestToken) {
            $this->Session->write('google_request_token', $requestToken);
            $this->redirect('https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=' . $requestToken->key);
        } else {
            $this->Session->setFlash('Couldn\'t log you in, sorry!');
        }
    }

    public function callback() {
        $requestToken = $this->Session->read('google_request_token');
        $client = $this->createClient();
        $accessToken = $client->getAccessToken('https://www.google.com/accounts/OAuthGetAccessToken', $requestToken);
    }

    private function createClient() {
        return new OAuthClient('245096563422.apps.googleusercontent.com', 'xHSpS5Rkf4IM6EOxOFZnLsWm');
    }
}

?>