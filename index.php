<?php

    define('SHOPIFY_API_KEY', 'ec29dd93ee7e40a8f1d9b914ab16ba04');
    define('SHOPIFY_SECRET', '6451dac2ba28f48fecb1ec8aa3d0bcb8');
    define('SHOPIFY_SCOPE', 'write_products');

    require 'shopify.php';

    
    if (isset($_GET['code'])) { // if the code param has been sent to this page... we are in Step 2
        // Step 2: do a form POST to get the access token
        $shopifyClient = new ShopifyClient($_GET['shop'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
        session_unset();

        // Now, request the token and store it in your session.
        $_SESSION['token'] = $shopifyClient->getAccessToken($_GET['code']);
        if ($_SESSION['token'] != '')
            $_SESSION['shop'] = $_GET['shop'];






        $sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], $api_key, $secret);

         try
    {
        // Get all products
        $products = $sc->call('GET', '/admin/products.json', array('published_status'=>'published'));

        // header('Content-Type: application/json');
        $json_string = json_encode($products, JSON_PRETTY_PRINT);
        echo "<pre>".$json_string."</pre>";

        // Create a new recurring charge
        $charge = array
        (
            "recurring_application_charge"=>array
            (
                "price"=>10.0,
                "name"=>"Super Duper Plan",
                "return_url"=>"http://super-duper.shopifyapps.com",
                "test"=>true
            )
        );

        try
        {
            $recurring_application_charge = $sc->call('POST', '/admin/recurring_application_charges.json', $charge);

            // API call limit helpers
            echo $sc->callsMade(); // 2
            echo $sc->callsLeft(); // 498
            echo $sc->callLimit(); // 500

        }
        catch (ShopifyApiException $e)
        {
            // If you're here, either HTTP status code was >= 400 or response contained the key 'errors'
        }

    }
    catch (ShopifyApiException $e)
    {
        /* 
         $e->getMethod() -> http method (GET, POST, PUT, DELETE)
         $e->getPath() -> path of failing request
         $e->getResponseHeaders() -> actually response headers from failing request
         $e->getResponse() -> curl response object
         $e->getParams() -> optional data that may have been passed that caused the failure

        */
    }
    catch (ShopifyCurlException $e)
    {
        // $e->getMessage() returns value of curl_errno() and $e->getCode() returns value of curl_ error()
    }
    

        //header("Location: index.php");
        exit;       
    }
    // if they posted the form with the shop name
    else if (isset($_POST['shop']) || isset($_GET['shop'])) {

        // Step 1: get the shopname from the user and redirect the user to the
        // shopify authorization page where they can choose to authorize this app
        $shop = isset($_POST['shop']) ? $_POST['shop'] : $_GET['shop'];
        $shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);

        // get the URL to the current page
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        // redirect to authorize url
        header("Location: " . $shopifyClient->getAuthorizeUrl(SHOPIFY_SCOPE, $pageURL));
        exit;
    }

    // first time to the page, show the form below
?>
    <p>Install this app in a shop to get access to its private admin data.</p> 

    <p style="padding-bottom: 1em;">
        <span class="hint">Don&rsquo;t have a shop to install your app in handy? <a href="https://app.shopify.com/services/partners/api_clients/test_shops">Create a test shop.</a></span>
    </p> 

    <form action="" method="post">
      <label for='shop'><strong>The URL of the Shop</strong> 
        <span class="hint">(enter it exactly like this: myshop.myshopify.com)</span> 
      </label> 
      <p> 
        <input id="shop" name="shop" size="45" type="text" value="" /> 
        <input name="commit" type="submit" value="Install" /> 
      </p> 
    </form>
    <form action="" method="post">
      <label for='getProduct'><strong>Get Product</strong> 
      </label> 
      <p> 
        <input id="getProduct" name="getProduct" size="45" type="text" value="" /> 
        <input name="commit" type="submit" value="Install" /> 
      </p> 
    </form>
