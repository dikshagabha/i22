<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

//use Your Model
use App\Model\Token;
use App\User;
use Carbon\Carbon;
/**
 * Class CommonRepository.
 */
class CommonRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public static function random_str($length=8, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
	    $pieces = [];
	    $max = mb_strlen($keyspace, '8bit') - 1;
	    for ($i = 0; $i < $length; ++$i) {
	        $pieces []= $keyspace[random_int(0, $max)];
	    }
	    return implode('', $pieces);
	}

    public static function getManageToken($token, $user_id): Token
    {
        return $token_get = Token::updateOrCreate(['user_id' => $user_id], ['token' => $token]);
    } 

}
