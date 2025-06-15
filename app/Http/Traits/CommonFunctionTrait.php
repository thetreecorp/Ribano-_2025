<?php
namespace App\Http\Traits;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App;
use DB;

trait CommonFunctionTrait
{
	/**
	 * Decode public key from SSO
	 *
	 * @param array $tocken

	 * @return boolean
	 */
	public function __construct()
    {
		$this->key = 'WbUVSk7i3ZLhF1fYjqPPKQZGKdACOsmXQ87Xk06pMj9ZPpZ6WVHtSRbTHeziuyMp';
    }
	protected function decodeKey($token)
	{

		$oritoken = $this->deEncryptToken($token);
		$tokenPayload = JWT::decode($oritoken, new Key($this->key, 'HS256'));

		// dd($tokenPayload);
		//		return $tokenPayload;
		//try {
           // JWT::$leeway += 1;

          //  $tokenPayload = JWT::decode($oritoken, new Key(config('jwt.secret'), 'HS256'));

		  $user = User::query()->where('email' , $tokenPayload->email)->first();

		  if($user){
			  setcookie("user_id", $hash, time() + 10 * 365 * 24 * 60 * 60);
			  auth()->login($user, true);
			  return true;
		  }
		 else{
			$getName = $this->splitName($tokenPayload->full_name);
			
		    $user = new User([
				  'firstname' => array_key_exists(0, $getName) ? $getName[0] : '',
				  'lastname' => array_key_exists(1, $getName) ? $getName[1] : '',
				  'email' => $tokenPayload->email,
				  'email_verification' => 1,
				  'status' => 1,
		    ]);

		    //$user->email_verified_at = date('Y-m-d H:m:s');

		    $user->save();

		    auth()->login($user, true);


		    return true;
		  }

		/*} catch (\Throwable $e) {
			return $this->respondInternalError($e->getMessage());
		} */
	}

	function splitName($name) {
		$name = trim($name);
		$last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
		$first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
		return array($first_name, $last_name);
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


}
