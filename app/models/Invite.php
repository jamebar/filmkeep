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
    public static function addInvite( $input, $logged_in_user_email = 'invite@filmkeep.com')
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
        $invite_exists = Invite::where('email' , $input['email'])->first();
        if( !empty( $invite_exists ) )
        {
            return array( 'responsetype' => 'error', 'response' => 'That email has already been invited.' );
        }

        //check to see if this email is already a user
        $user_exists = User::where('email' , $input['email'])->first();
        if( !empty( $user_exists ) )
        {
            return array( 'responsetype' => 'error', 'response' => 'That email is already associated with a user on Filmkeep.' );
        }

        //add token to the array
        $input['code'] = Invite::getToken( 10 );


        $link_message = "<br><br>To use your invite code and join Filmkeep, click on this link: <a href='http://dev.filmkeep.com:888/user/join/" . $input['code'] . "'>http://dev.filmkeep.com:8888/user/join/" . $input['code'] . "?email=" . urlencode( $input['email'] ) . "</a>";

        //send email to invitee
        $email_message = array(
            'template_name'     => 'invite',
            'template_content'  => array(array(
                'name'              => 'description',
                'content'           => nl2br($input['message']) . $link_message,
                
            )),
            'message'           => array(
                'to'                => array(array('email'=> $input['email']))
            )
        );


        $email_response = Mandrill::request('messages/send-template', $email_message);


        //remove message from input array
        unset($input['message']);

        return array( 'responsetype' => 'success', 'response' => Invite::create( $input )->toArray() , 'email_response' => $email_response);
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