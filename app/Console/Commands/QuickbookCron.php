<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Quickbook as QuickModel;
use QuickBooksOnline\API\DataService\DataService;
use Carbon\Carbon;
use Exception;

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
    protected $description = 'Hourly update refresh and access token';

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
            $quickbook = QuickModel::first();
            $dataService = DataService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => config('services.quickbook.client_id'),
                'ClientSecret' =>  config('services.quickbook.client_secret'),
                'RedirectURI' => config('services.quickbook.oauth_redirect_uri'),
                'scope' => config('services.quickbook.oauth_scope'),
                'baseUrl' => "development",
                'refreshTokenKey' => ($quickbook != null) ? $quickbook['refresh_token'] : 'AB11674363956MtY8cdpm5TecAAnYZgVMBCsLjj7QrX1yEXaC3', // Manual Fetch on firt tyme
                'QBORealmID' => config('services.quickbook.QBORealmID'),
            ));
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
                $quickbook = new QuickModel();
                $quickbook->access_token = $refreshedAccessTokenObj->getAccessToken();
                $quickbook->refresh_token = $refreshedAccessTokenObj->getRefreshToken();
                $quickbook->refresh_token_expires_in = $refreshedAccessTokenObj->getRefreshTokenExpiresAt();
                $quickbook->access_token_expires_in =  $refreshedAccessTokenObj->getAccessTokenExpiresAt();
                $quickbook->realmId = $refreshedAccessTokenObj->getRealmID();
                $quickbook->save();
            }
            echo 'accesstoken  update at ' .Carbon::now();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }  
    
}
