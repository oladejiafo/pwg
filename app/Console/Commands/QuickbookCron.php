<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Quickbook as QuickModel;
use QuickBooksOnline\API\DataService\DataService;
use App\Helpers\users as UserHelper;
use App\Constant;
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
                'ClientID' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.client_id') : config('services.quickbook.client_id'),
                'ClientSecret' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.client_secret') : config('services.quickbook.client_secret'),
                'RedirectURI' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.oauth_redirect_uri') : config('services.quickbook.oauth_redirect_uri'),
                'scope' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.oauth_scope') : config('services.quickbook.oauth_scope'),
                'accessTokenKey' => $quickbook['access_token'],
                'refreshTokenKey' => $quickbook['refresh_token'],
                'QBORealmID' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? config('services.quickbook_local.QBORealmID') : config('services.quickbook.QBORealmID'),
                'baseUrl' => (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) ? "Development" : "production"
            ));
            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
            $dataService->updateOAuth2Token($refreshedAccessTokenObj);
            $quickbook->access_token = $refreshedAccessTokenObj->getAccessToken();
            $quickbook->refresh_token = $refreshedAccessTokenObj->getRefreshToken();
            $quickbook->refresh_token_expires_in = $refreshedAccessTokenObj->getRefreshTokenExpiresAt();
            $quickbook->access_token_expires_in =  $refreshedAccessTokenObj->getAccessTokenExpiresAt();
            $quickbook->realmId = $refreshedAccessTokenObj->getRealmID();
            $quickbook->save();
        } catch (Exception $e) {
            UserHelper::webLogger($e);
        }
    }
}
