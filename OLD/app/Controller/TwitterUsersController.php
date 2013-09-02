<?php
App::import('Vendor', 'OAuth/OAuthClient');
class TwitterUsersController extends AppController {
        
    
    public function index() {
        $client = $this->createClient();
        $requestToken = $client->getRequestToken('https://api.twitter.com/oauth/request_token', 'http://www.dev.thinkshare.it/cakephp/twitter_users/callback');

        if ($requestToken) {
            $this->Session->write('twitter_request_token', $requestToken);
            $this->redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
        } else {
            $this->Session->setFlash('Couldn\'t sign you in with Twitter, sorry!');
        }
    }

    public function callback() {
        $requestToken = $this->Session->read('twitter_request_token');
        $client = $this->createClient();
        $accessToken = $client->getAccessToken('https://api.twitter.com/oauth/access_token', $requestToken);
        $httpResponse = $client->get($accessToken->key, $accessToken->secret, 'https://api.twitter.com/1/account/verify_credentials.json');
        $details = json_decode($httpResponse->body, true);
        
        if(isset($details['name']) && isset($details['screen_name'])){
            $user = array(
                    'display_name' => $details['screen_name'],
                    'twitter_user' => 1
            );
            
            $this->TwitterUser->User->create();
            if($this->TwitterUser->User->save($user)){
                $this->TwitterUser->create();
                $twitterUser = array(
                    'user_id' => $this->TwitterUser->User->id,
                    'token_key' => $accessToken->key,
                    'token_secret' => $accessToken->secret
                    );
                $this->TwitterUser->save($twitterUser);
            }

            if($this->Auth->login($user)){
                $this->Auth->redirect();
            }
        }
    }

    private function createClient() {
        return new OAuthClient('mfBLWFTPcwYb4WX5pfgMlg', 'TnHU7Dg4fKkXdVDpa7qGFpqRhx157mlGTnT5dHs');
    }
    
    
}

?>