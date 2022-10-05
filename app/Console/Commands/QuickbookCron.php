<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Quickbook;
use Exception;
use QuickBooksOnline\API\DataService\DataService;

class QuickbookCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quickbook:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Quickbook access token and refresh token hourly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $quickbook = Quickbook::first();
            $dataService = DataService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => config('app.client_id'),
                'ClientSecret' =>  config('app.client_secret'),
                'RedirectURI' => config('app.oauth_redirect_uri'),
                'scope' => config('app.oauth_scope'),
                'baseUrl' => "development",
                'refreshTokenKey' => $quickbook['refresh_token'],
                'QBORealmID' => config('app.QBORealmID'),
            ));
    
            /*
            * Update the OAuth2Token of the dataService object
            */
            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
    
            $dataService->updateOAuth2Token($refreshedAccessTokenObj);
    
            if($quickbook){
                $quickbook->access_token = $refreshedAccessTokenObj->getAccessToken();
                $quickbook->refresh_token = $refreshedAccessTokenObj->getRefreshToken();
                $quickbook->refresh_token_expires_in = $refreshedAccessTokenObj->getRefreshTokenExpiresAt();
                $quickbook->access_token_expires_in =  $refreshedAccessTokenObj->getAccessTokenExpiresAt();
                $quickbook->realmId = $refreshedAccessTokenObj->getRealmID();
                $quickbook->save();
            } else {
                $quick = new Quickbook();
                $quick->access_token = $refreshedAccessTokenObj->getAccessToken();
                $quick->refresh_token = $refreshedAccessTokenObj->getRefreshToken();
                $quick->refresh_token_expires_in = $refreshedAccessTokenObj->getRefreshTokenExpiresAt();
                $quick->access_token_expires_in =  $refreshedAccessTokenObj->getAccessTokenExpiresAt();
                $quickbook->realmId = $refreshedAccessTokenObj->getRealmID();
                $quick->save();
            }
            echo "Data updated Successfully!";
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}
