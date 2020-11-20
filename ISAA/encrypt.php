<?php 

namespace deemru;
$encryption_key = "CE51E06875F7D964";


  $pan = $_POST['pan'];
  $adh = $_POST['adhaar'];  

  $phn = $_POST['phn'];
  $email = $_POST['email'];
  
  $name = $_POST['name'];
  $dob = $_POST['dob'];

  $stat = $_POST['status'];
  $addr = $_POST['addr'];
  $atm = $_POST['atm'];
  $dl = $_POST['dl'];


  $enc_pan = encrypt_des($pan,$encryption_key);
  $dec_pan = decrypt_des($enc_pan , $encryption_key);

  $enc_adh = encrypt_des($adh,$encryption_key);
  $dec_adh = decrypt_des($enc_adh , $encryption_key);


  
  $cryptash = new Cryptash( 'Password' );
  $enc_phn = $cryptash->encryptash( $phn );
  $dec_phn = $cryptash->decryptash( $enc_phn );

  $enc_email = $cryptash->encryptash( $email );
  $dec_email= $cryptash->decryptash( $enc_email );



  $enc = encrypt_aes($name);
  $enc_name = $enc[0];
  $dec_name = decrypt_aes($enc_name,$enc[1],$enc[2]);

  $enc1 = encrypt_aes($dob);
  $enc_dob = $enc1[0];
  $dec_dob = decrypt_aes($enc_dob,$enc1[1],$enc1[2]);

$link = mysqli_connect("localhost", "root", "", "demo");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 
$sql = "INSERT INTO persons(name, dob, status, ph_no, email, addr, atm, adhaar, pan, dl_no) VALUES ('$enc_name','$enc_dob','$stat','$enc_phn','$enc_email','$addr','$atm','$enc_adh','$enc_pan','$dl')";
if(mysqli_query($link, $sql)){
    echo "Records inserted successfully in Encrypt";
    echo "<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    echo "<br>";

} 
mysqli_close($link);


$link = mysqli_connect("localhost", "root", "", "demo");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 
$sql = "INSERT INTO decrypt(name, dob, status, ph_no, email, addr, atm, adhaar, pan, dl_no) VALUES ('$dec_name','$dec_dob','$stat','$dec_phn','$dec_email','$addr','$atm','$dec_adh','$dec_pan','$dl')";
if(mysqli_query($link, $sql)){
    echo "<br>";
    echo "Records inserted successfully in Decrypt";
    echo "<br>";
    echo "<a href='main.html'>Click to go back</a>";
    echo "<br>";
    echo "<a href='display.php'>Click to view all decrypted data...</a>";


} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    echo "<br>";

} 
mysqli_close($link);

function encrypt_aes($data)
{
    define('AES_256_CBC', 'aes-256-cbc');
    $encryption_key = openssl_random_pseudo_bytes(32);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC));
    $encrypted = openssl_encrypt($data, AES_256_CBC, $encryption_key, 0, $iv);    
    return [$encrypted,$iv,$encryption_key];
    
}
function decrypt_aes($encrypted,$iv,$encryption_key)
{
    $encrypted = $encrypted . ':' . base64_encode($iv);
    $parts = explode(':', $encrypted);
    $decrypted = openssl_decrypt($parts[0], AES_256_CBC, $encryption_key, 0, base64_decode($parts[1]));
    return $decrypted;
}

  function encrypt_des($data, $secret)
  {
    $key = md5(utf8_encode($secret), true);
    $key .= substr($key, 0, 8);
    $blockSize = mcrypt_get_block_size('tripledes', 'ecb');
    $len = strlen($data);
    $pad = $blockSize - ($len % $blockSize);
    $data .= str_repeat(chr($pad), $pad);
    $encData = mcrypt_encrypt('tripledes', $key, $data, 'ecb');
    return base64_encode($encData);
  }


    function decrypt_des($data, $secret)
  {
    $key = md5(utf8_encode($secret), true);
    $key .= substr($key, 0, 8);
    $data = base64_decode($data);
    $data = mcrypt_decrypt('tripledes', $key, $data, 'ecb');
    $block = mcrypt_get_block_size('tripledes', 'ecb');
    $len = strlen($data);
    $pad = ord($data[$len-1]);
    return substr($data, 0, strlen($data) - $pad);
  }



class Cryptash
{
    public function __construct( $psw, $ivsz = 4, $macsz = 4, $hash = 'sha256' )
    {
        $this->psw = $psw;
        $this->hash = $hash;
        $this->ivsz = max( 0, $ivsz );
        $this->cbcsz = strlen( self::hash( '' ) );
        $this->macsz = min( $macsz, $this->cbcsz );
    }
    public function encryptash( $data )
    {
        if( $this->ivsz )
        {
            $iv = self::rnd( $this->ivsz );
            $data = self::rnd( $this->ivsz ) . $data;
        }
        else
            $iv = '';

        $key = self::hash( $iv . $this->psw );

        if( $this->macsz )
            $iv .= substr( self::hash( $data . $key ), 0, $this->macsz );

        return $iv . self::cbc( $iv, $key, $data, true );
    }
    public function decryptash( $data )
    {
        if( strlen( $data ) < 2 * $this->ivsz + $this->macsz )
            return false;

        $key = self::hash( substr( $data, 0, $this->ivsz ) . $this->psw );
        if( $this->macsz )
            $mac = substr( $data, $this->ivsz, $this->macsz );
        $data = self::cbc( substr( $data, 0, $this->ivsz + $this->macsz ),
                           $key, substr( $data, $this->macsz + $this->ivsz ) );

        if( $this->macsz && $mac !== substr( self::hash( $data . $key ), 0, $this->macsz ) )
            return false;

        if( strlen( $data ) === $this->ivsz )
            return '';

        return substr( $data, $this->ivsz );
    }
    static public function rnd( $size = 8 )
    {
        static $rndfn;

        if( $size === 0 )
            return '';

        if( !isset( $rndfn ) )
        {
            if( function_exists( 'random_bytes' ) )
                $rndfn = 2;
            else if( function_exists( 'mcrypt_create_iv' ) )
                $rndfn = 1;
            else
                $rndfn = 0;
        }
        
        if( $rndfn === 2 )
            return random_bytes( $size );
        if( $rndfn === 1 )
            return mcrypt_create_iv( $size );

        $rnd = '';
        while( $size-- )
            $rnd .= chr( mt_rand() );
        return $rnd;
    }

    private function hash( $data )
    {
        return hash( $this->hash, $data, true );
    }

    private function cbc( $v, $k, $d, $e = false )
    {
        $s = $this->cbcsz;
        $n = strlen( $d );
        $k = self::hash( $v . $k );
        $o = $d;

        for( $i = 0, $j = 0; $i < $n; $i++, $j++ )
        {
            if( $j == $s )
            {
                $k = self::hash( substr( $e ? $o : $d, $i - $j, $j ) . $k );
                $j = 0;
            }

            $o[$i] = $d[$i] ^ $k[$j];
        }

        return $o;
    }
}
?>