<?php

use \Illuminate\Support\Str;
use App\Models\Configure;
use Illuminate\Support\Facades\Cache;
use App\Models\SystemTranslation;
use App\Models\Language;
use App\Models\NearAccountKey;
use App\Models\ManagePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\SendTokenLog;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\DB;
use App\Models\PayMoney;

// SSO function
// function token encryption
function encryptToken($token) {
    $explode = explode('.', $token);
    if(count($explode) == 3) {
        for ($i=0; $i < 2; $i++) {
            array_push($explode, generateRandomString(10));
        }
        $explode = array_replace(array_flip(array('1', '3', '2', '0', '4')), $explode);
        return implode ("-=", $explode);
    }

    return 0;
}

function deEncryptToken($token) {
    $explode = explode('-=', $token);
    if(count($explode) == 5) {
        $explode = array_replace(array_flip(array('3', '0', '2', '1', '4')), $explode);
        $explode = implode ("-=", $explode);
        $deCode = explode("-=", $explode, -2); // get only 3 element in array
        return implode (".", $deCode);
    }
    return 0;

}
function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// deposit and send token
function depositAndSendToken($reqData)
{
    try {
        $storage_deposit = config('constants.options.storage_deposit_url');
        
        $account_id = config('constants.options.master_account_id');
        $private_key = config('constants.options.private_key');
                    
        $response = Http::withHeaders([
            'Accept' =>  'application/json',
            'Content-Type' => 'application/json'
        ])->post($storage_deposit, [
            'owner_id' => $account_id,
            'contract' => $reqData['contract'],
            'account_id' => $reqData['receiver_id'],
            'private_key' => $private_key,
            // 'owner_id' => $reqData['owner_id'],
            // 'account_id' => $reqData['receiver_id'],
            // 'contract' => $reqData['contract'],
            // 'private_key' => $reqData['private_key'],
        ]);
        
        $ft_transfer = config('constants.options.ft_transfer_url');
                    
        $response = Http::withHeaders([
            'Accept' =>  'application/json',
            'Content-Type' => 'application/json'
        ])->post($ft_transfer, [
            'old_owner_id' => $reqData['owner_id'],
            'receiver_id' => $reqData['receiver_id'],
            'memo' => $reqData['memo'],
            'contract' => $reqData['contract'],
            // 'private_key' => $reqData['private_key'],
            'master_id' => $account_id,
            'private_key' => $private_key,
            'amount' => $reqData['amount'],
        ]);
        $data = $response->json();
        
        if($data['status'] == 200)
            return $data['tx'];
        else 
            return 0;
        
    } catch (\Throwable $th) {
        return 0;
        //dd($th->getMessage());
    }
   
    
}

function convertUSDToCurrency($usdAmount, $currencyCode) {
    $exchangeRates = config('constants.options.exchange_rates');

    if($currencyCode == '$')
        $currencyCode = 'USD';

    $usdAmount = intval(str_replace('.', '', $usdAmount));

    if (isset($exchangeRates[$currencyCode])) {
        $exchangeRate = $exchangeRates[$currencyCode];
        $convertedAmount = $usdAmount / $exchangeRate;
        $formattedAmount = number_format($convertedAmount, 2, ',', '.');
        if (substr($formattedAmount, -3) == ',00') {
            $formattedAmount = substr($formattedAmount, 0, -3);
        }

        return $formattedAmount;

        //return str_replace(array('.', ','), array(',', '.'), $formattedAmount);
    } else {
        return "Currency code not supported";
    }
}

function getTotalInvest($user_id) {
    $total = Paymoney::where('user_id', $user_id)
    ->sum('total');
    
    return $total ?? 0;
}

// withdrawable token return array()
function getWithdrawableTokens($userId)
{
    
    
    $withdrawnTokens = getWithdrawRequest($userId);
    
    $userTokens = SendTokenLog::with('token')
        ->where('user_id', $userId)
        ->selectRaw('*, sum(number_token) as totalToken')
        ->groupBy('token_id')
        ->orderBy('id', 'DESC')
        ->get();

    $withdrawableTokens = $userTokens->mapWithKeys(function ($log) use ($userId, $withdrawnTokens) {
        $withdrawableTokens = SendTokenLog::where('user_id', $userId)
            ->where('token_id', $log->token_id)
            ->whereRaw('DATEDIFF(NOW(), created_at) >= (SELECT set_withdraw_date FROM manage_plans WHERE id = token_id)')
            ->sum('number_token');
        
        $withdrawnToken = $withdrawnTokens[$log->token->token_symbol] ?? 0;
        $withdrawableTokens = max(0, $withdrawableTokens - $withdrawnToken);
        return [$log->token->token_symbol => $withdrawableTokens];
    })->filter(function ($value) {
        return $value > 0;
    })->all();

    return $withdrawableTokens;
}

function getTokenCount($userId, $tokenId)
{
    $result = WithdrawRequest::where('user_id', $userId)
        ->where('token_id', $tokenId)
        ->select('status', DB::raw('SUM(number_token) as count'))
        ->groupBy('status')
        ->get();

    $data = $result->mapWithKeys(function ($item) {
        return [$item->status => $item->count];
    })->all();

    return [
        'pending' => $data['pending'] ?? 0,
        'approved' => $data['approved'] ?? 0,
    ];
}

// get token withdraw request
function getWithdrawRequest($userId, $status = 'all') {
    if($status == 'all')
        $userTokens = WithdrawRequest::with('token')->groupBy('token_id')
            ->where('user_id', $userId)->selectRaw('*, sum(number_token) as totalToken')->orderBy('id','DESC')->get()
            ->mapWithKeys(function ($item) {
                if (!$item->token) return []; 
                return [$item->token->token_symbol => $item->totalToken];
            });
    else
        $userTokens = WithdrawRequest::with('token')->groupBy('token_id')->where('status', $status)
            ->where('user_id', $userId)->selectRaw('*, sum(number_token) as totalToken')->orderBy('id','DESC')->get()
            ->mapWithKeys(function ($item) {
                if (!$item->token) return []; 
                return [$item->token->token_symbol => $item->totalToken];
            });
        
    return $userTokens->toArray();
}

function createHashLink($hash, $testnet = 1) {
    $link = 'https://testnet.nearblocks.io/txns/';
    if($testnet == 0)
        $link = 'https://nearblocks.io/txns/';
    return $link . $hash . '?tab=execution';
}
function getTokenName($token_symbol) {
    $plan = ManagePlan::where('token_symbol', $token_symbol)->first();
    $name = !empty($plan->name) ? ($plan->name) : 'N/A';
    return $name ;
}

function n_format($number) { 
    $number = unformatNumber($number);
    return number_format($number, 0, ',', '.');
}

function unformatNumber($string) {
    return floatval(str_replace(['.', ','], ['', ''], $string));
}

function excerptText($htmlString, $wordCount = 20) {
    $text = preg_replace('/\s+/', ' ', strip_tags($htmlString));
    $words = explode(' ', $text);
    $excerpt = implode(' ', array_slice($words, 0, $wordCount));
    if (count($words) > $wordCount) {
        $excerpt .= '...';
    }
    return $excerpt;
}

function convertToSnakeCase($inputString) {
    $trimmedString = trim($inputString);
    $snakeCaseString = str_replace(' ', '_', $trimmedString);
    $snakeCaseString = strtolower($snakeCaseString);

    return $snakeCaseString;
}



function getUserRole() {
    $roles = auth()->user()->getRoleNames()->toArray() ?? [];
    return $roles;
}
function formatBytes($bytes)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);


    return round($bytes) . ' ' . $units[$pow];
}


if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = '//' . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return $root;
    }
}


if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return env('AWS_URL') . '/';
        } else {
            return getBaseURL() . 'public/';
        }
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return in_array('admin',  getUserRole()) ? 1 : 0;
    }
}

if (!function_exists('isInvestor')) {
    function isInvestor()
    {
        return in_array('investor',  getUserRole()) ? 1 : 0;
    }
}

if (!function_exists('my_asset')) {
  
    function my_asset($path, $secure = null)
    {
        return url('assets/admin/images/default.png');
    }
}

if (!function_exists('my_asset_file')) {
  
    function my_asset_file($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}

if (!function_exists('isFounder')) {
    function isFounder()
    {
        return in_array('founder',  getUserRole()) ? 1 : 0;
    }
}

function template($asset = false)
{
    $activeTheme = config('basic.theme');
    if ($asset) return 'assets/themes/' . $activeTheme . '/';
    return 'themes.' . $activeTheme . '.';
}


function recursive_array_replace($find, $replace, $array)
{
    if (!is_array($array)) {
        return str_replace($find, $replace, $array);
    }
    $newArray = [];
    foreach ($array as $key => $value) {
        $newArray[$key] = recursive_array_replace($find, $replace, $value);
    }
    return $newArray;
}

function menuActive($routeName, $type = null)
{
    $class = 'active';
    if ($type == 3) {
        $class = 'selected';
    } elseif ($type == 2) {
        $class = 'has-arrow active';
    } elseif ($type == 1) {
        $class = 'in';
    }
    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}


function getFile($image, $clean = '')
{
    return file_exists($image) && is_file($image) ? asset($image) . $clean : asset(config('location.default'));
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}

function loopIndex($object)
{
    return ($object->currentPage() - 1) * $object->perPage() + 1;
}

if (!function_exists('getRoute')) {
    function getRoute($route, $params = null)
    {
        return isset($params) ? route($route, $params) : route($route);
    }
}

if (!function_exists('isMenuActive')) {
    function isMenuActive($routes, $type = 0)
    {
        $class = [
            '0' => 'active',
            '1' => 'style=display:block',
            '2' => true
        ];

        if (is_array($routes)) {
            foreach ($routes as $key => $route) {
                if (request()->routeIs($route)) {
                    return $class[$type];
                }
            }
        } elseif (request()->routeIs($routes)) {
            return $class[$type];
        }

        if ($type == 1){
            return 'style=display:none';
		}
        else{
            return false;
		}
    }
}

if (!function_exists('getTitle')) {
    function getTitle($title)
    {
        return ucwords(preg_replace('/[^A-Za-z0-9]/', ' ', $title));
    }
}

function basicControl()
{
    //return Configure::firstOrCreate(['id' => 1]);
    $minutes = config('constants.options.cache_time') ?? 60;


   return $configure = Cache::remember('configure', $minutes, function () use ($minutes) {
        
        if (Cache::has('configure')) {
            return Cache::get('configure');
        } else {
            $configure = Configure::firstOrCreate(['id' => 1]);
            Cache::put('configure', $configure, now()->addMinutes($minutes));
            return $configure;
        }
    });
}

function getAmount($amount, $length = 0)
{
    if (0 < $length) {
        return number_format($amount + 0, $length);
    }
    return $amount + 0;
}


function strRandom($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    \Carbon\Carbon::setlocale($lang);
    return \Carbon\Carbon::parse($date)->diffForHumans();
}

function dateTime($date, $format = 'd M, Y h:i A')
{
    return date($format, strtotime($date));
}
if (!function_exists('putPermanentEnv')) {
    function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();
        $escaped = preg_quote('=' . env($key), '/');
        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}

function checkTo($currencies, $selectedCurrency = 'USD')
{
    foreach ($currencies as $key => $currency) {
        if (property_exists($currency, strtoupper($selectedCurrency))) {
            return $key;
        }
    }
}

function code($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}
function invoice(){

    return time().code(4);
}
function wordTruncate($string, $offset = 0, $length = null): string
{
    $words = explode(" ", $string);
    isset($length) ? array_splice($words, $offset, $length) : array_splice($words, $offset);
    return implode(" ", $words);
}

function linkToEmbed($string)
{
    if (strpos($string, 'youtube') !== false) {
        $words = explode("/", $string);
        if (strpos($string, 'embed') == false) {
            array_splice($words, -1, 0, 'embed');
        }
        $words = str_ireplace('watch?v=', '', implode("/", $words));
        return $words;
    }
    return $string;
}


function slug($title)
{
    return \Illuminate\Support\Str::slug($title);
}
function title2snake($string)
{
    return Str::title(str_replace(' ', '_', $string));
}

function snake2Title($string)
{
    return Str::title(str_replace('_', ' ', $string));
}

function kebab2Title($string)
{
    return Str::title(str_replace('-', ' ', $string));
}

function getLevelUser($id)
{
    $ussss = new \App\Models\User();
    return $ussss->referralUsers([$id]);
}

function getPercent($total, $current)
{
    if ($current > 0 && $total > 0) {
        $percent = (($current * 100) / $total) ?: 0;
    } else {
        $percent = 0;
    }
    return round($percent, 0);
}

function flagLanguage($data)
{
    return  '{'.rtrim($data, ',').'}';
}

function getIpInfo()
{
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;


    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}



function resourcePaginate($data,$callback){
    return $data->setCollection($data->getCollection()->map($callback));
}


function clean($string) {
    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function camelToWord($str) {
    $arr =  preg_split('/(?=[A-Z])/',$str);
    return trim(join(' ',$arr));
}


function in_array_any($needles, $haystack) {
    return (bool) array_intersect($needles, $haystack);
}



function adminAccessRoute($search) {
    $list = collect(config('role'))->pluck('access')->flatten()->intersect(auth()->guard('admin')->user()->admin_access);


    if (is_array($search)) {
        $list = $list->intersect($search);
        if(0 < count($list)){
            return true;
        }
        return  false;
    } else {

        return $list->search(function($item) use ($search) {
            if($search == $item){
                return true;
            }
            return false;
        });
    }
}


function hex2rgba($color, $opacity = false) {
    $default = 'rgb(0,0,0)';
    //Return default if no color provided
    if(empty($color))
        return $default;
    //Sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
        $color = substr( $color, 1 );
    }
    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }
    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);
    //Check if opacity is set(rgba or rgb)
    if($opacity){
        if(abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
        $output = 'rgb('.implode(",",$rgb).')';
    }
    //Return rgb(a) color string
    return $output;
}

//helper function
function getIP() {
    if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
    return $_SERVER['REMOTE_ADDR'];
}

/**
 ** translate
*/
function translate($key, $lang = null, $addslashes = true)
{
    if ($lang == null) {
        $language = Session::get('trans');
        if($language == 'US')
            $language = 'en';
        App::setLocale($language);
        $lang = App::getLocale();
    }

    $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));
    
    

    $translations_en = Cache::rememberForever('translations-en', function () {
        return SystemTranslation::where('lang', 'en')->pluck('lang_value', 'lang_key')->toArray();
    });
    


    if (!isset($translations_en[$lang_key])) {
        $translation_def = new SystemTranslation;
        $translation_def->lang = 'en';
        $translation_def->lang_key = $lang_key;
        $translation_def->lang_value = str_replace(array("\r", "\n", "\r\n"), "", $key);
        $translation_def->save();
        Cache::forget('translations-en');
    }

    // return user session lang
    $translation_locale = Cache::rememberForever("translations-{$lang}", function () use ($lang) {
        return SystemTranslation::where('lang', $lang)->pluck('lang_value', 'lang_key')->toArray();
    });
    
    if (isset($translation_locale[$lang_key])) {
        return $addslashes ? addslashes(trim($translation_locale[$lang_key])) : trim($translation_locale[$lang_key]);
    }


    // return default lang if session lang not found
    $translations_default = Cache::rememberForever('translations-' . env('DEFAULT_LANGUAGE', 'en'), function () {
        return SystemTranslation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->pluck('lang_value', 'lang_key')->toArray();
    });
    if (isset($translations_default[$lang_key])) {
        return $addslashes ? addslashes(trim($translations_default[$lang_key])) : trim($translations_default[$lang_key]);
    }

    // fallback to en lang
    if (!isset($translations_en[$lang_key])) {
        return trim($key);
    }
    return $addslashes ? addslashes(trim($translations_en[$lang_key])) : trim($translations_en[$lang_key]);
}

// get rtl option
function getRTL() {
    $language = Session::get('trans') ?? 'US';

    $minutes = config('constants.options.cache_time') ?? 60;

    //$option = Language::where('short_name', $language)->first();

    $option = Cache::remember('short_name' . $language, $minutes, function () use ($language, $minutes) {
        
        if (Cache::has('short_name')) {
            return Cache::get('short_name');
        } else {
            $language = Language::where('short_name', $language)->first();
            Cache::put('short_name', $language, now()->addMinutes($minutes));
            return $language;
        }
    });
    
    

    if($option)
        return $option->rtl;
    else
        return 0;
    
}
