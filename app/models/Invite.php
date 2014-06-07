<?php
  
class Invite extends Eloquent {
    /**
     * The database table used by the model.
     * If the name of your days table is some thing other than days, 
     * then define it below. Other wise it will assume a table name
     * that is a plural of the model class name.
     *
     * @var string
     */
     

    protected $guarded = array();
     
    /*
     * An invite belongs to a user
     */
    public function referrer()
    {
        return $this->belongsTo('User', 'referrer_user_id');
    }

    /*
     * Add an invite
     */
    public static function addInvite( $input)
    {
        $validator = Validator::make(
            array(
                'email' => $input['email'],
            ),
            array(
                'email' => 'required|email'
            )
        );

        //return $input;

        if ( $validator->fails() )
        {
            return array( 'responsetype' => 'error', 'response' => 'Please enter a valid email address.' );
        }

        //check to see if this email has already been invited
        if( !empty( Invite::where('email' , $input['email'])->first() ) )
        {
            return array( 'responsetype' => 'error', 'response' => 'That email has already been invited.' );
        }

        //check to see if this email is already a user
        if( !empty( User::where('email' , $input['email'])->first() ) )
        {
            return array( 'responsetype' => 'error', 'response' => 'That email is already associated with a user on Filmkeep.' );
        }

        //add token to the array
        $input['code'] = Invite::getToken( 10 );

        return array( 'responsetype' => 'success', 'response' => Invite::create( $input )->toArray() );
    }


    public static function deleteInvite($user_id, $id)
    {
        return Invite::where( 'id' , $id)->where('referrer_user_id', $user_id)->delete();
    }

    public static function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public static function getToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[ Invite::crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }

}