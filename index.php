<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use Vectorface\GoogleAuthenticator;
use Google\Client;
use Google\Service\Oauth2;

/**
 * Set up goole client instances 
 */
try {
    $client_credentials_path = 'client_credentials.json';
    $client = new Client();
    $client->setAuthConfig($client_credentials_path);
    $client->addScope('profile');
    $client->addScope('email');
    $redirect_uri = $client->getRedirectUri();

} catch (\Throwable $th) {
    die('Google Client Error: '.$th->getMessage(). '&nbsp;&nbsp; <a href="'.$redirect_uri?? "#".'">Back to login</a>');
}

/**
 * Handle google callback 
 * 
 * Check for code and process
 */
if (isset($_GET['code'])) {
    try {
      
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);
    
        $google_service_oauth = new Oauth2($client);
    
        $user_info = $google_service_oauth->userinfo_v2_me->get();
    
        $google_authenticator = new GoogleAuthenticator();
        $OTP = $google_authenticator->createSecret();
        $qr_code_url = $google_authenticator->getQRCodeUrl('Blog', $OTP);

    } catch (\Throwable $th) {
        die('Google Client Authentication Error: '.$th->getMessage(). '&nbsp; &nbsp; <a href="'.$redirect_uri.'">Back to login</a>');
    }
   
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-4xl mt-12">

            <div class="hidden bg-cover lg:block lg:w-1/2" style="background-image: url('https://images.unsplash.com/photo-1718471472310-77a63c5fad95?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHx0b3BpYy1mZWVkfDZ8Ym84alFLVGFFMFl8fGVufDB8fHx8fA%3D%3D');"></div>

            <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">
                <div class="flex justify-center mx-auto">
                    <a href="https://www.linkedin.com/in/philip-james-ajagabos/" target="_blank">
                        <img 
                            class="w-auto h-7 sm:h-8 rounded-full" 
                            src="https://media.licdn.com/dms/image/C4D03AQGEY1uVw4BoLA/profile-displayphoto-shrink_200_200/0/1594328613448?e=1724889600&v=beta&t=WoUwCIBjMh33OJToMhX5UULAx82XuEdxW-pczv7wwWY" 
                            alt=""
                        >
                    </a>
                </div>

                <p class="mt-3 text-3xl text-center text-gray-600 dark:text-gray-200">
                    <strong>Ultainfinity : PHP Test 1</strong>
                    <p class="text-xs text-blue-500 hover:text-blue-700 hover:underline"> 
                        <a href="https://www.linkedin.com/in/philip-james-ajagabos/" target="_blank" rel="noopener noreferrer">Philip James Ajagabos</a>
                    </p>
                </p>

                <a id="sign-in-with-google-btn" href="<?php echo $client->createAuthUrl() ?>" class="flex items-center justify-center mt-4 text-gray-600 transition-colors duration-300 transform border rounded-lg dark:border-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <div class="">
                        <svg class="w-6 h-6" viewBox="0 0 40 40">
                            <path d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.045 27.2142 24.3525 30 20 30C14.4775 30 10 25.5225 10 20C10 14.4775 14.4775 9.99999 20 9.99999C22.5492 9.99999 24.8683 10.9617 26.6342 12.5325L31.3483 7.81833C28.3717 5.04416 24.39 3.33333 20 3.33333C10.7958 3.33333 3.33335 10.7958 3.33335 20C3.33335 29.2042 10.7958 36.6667 20 36.6667C29.2042 36.6667 36.6667 29.2042 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z" fill="#FFC107" />
                            <path d="M5.25497 12.2425L10.7308 16.2583C12.2125 12.59 15.8008 9.99999 20 9.99999C22.5491 9.99999 24.8683 10.9617 26.6341 12.5325L31.3483 7.81833C28.3716 5.04416 24.39 3.33333 20 3.33333C13.5983 3.33333 8.04663 6.94749 5.25497 12.2425Z" fill="#FF3D00" />
                            <path d="M20 36.6667C24.305 36.6667 28.2167 35.0192 31.1742 32.34L26.0159 27.975C24.3425 29.2425 22.2625 30 20 30C15.665 30 11.9842 27.2359 10.5975 23.3784L5.16254 27.5659C7.92087 32.9634 13.5225 36.6667 20 36.6667Z" fill="#4CAF50" />
                            <path d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.7592 25.1975 27.56 26.805 26.0133 27.9758C26.0142 27.975 26.015 27.975 26.0158 27.9742L31.1742 32.3392C30.8092 32.6708 36.6667 28.3333 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z" fill="#1976D2" />
                        </svg>
                    </div>

                    <div class="w-6/6 px-4 py-3 font-bold text-center flex gap-3">
                        Sign in with Google
                        
                        <div role="status" class="pt-1" id="sign-in-with-google-spinner" hidden>
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
 
                      
                    </div>
                </a>

                <div class="flex items-center justify-between mt-4">
                    <span class="w-1/5 border-b dark:border-gray-600 lg:w-1/4"></span>

                    <span class="text-xs text-center text-gray-500 uppercase dark:text-gray-400 ">or login with email</span>

                    <span class="w-1/5 border-b dark:border-gray-400 lg:w-1/4"></span>
                </div>

                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="LoggingEmailAddress">Email Address</label>
                    <input id="LoggingEmailAddress" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" type="email" />
                </div>

                <div class="mt-4">
                    <div class="flex justify-between">
                        <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="loggingPassword">Password</label>
                        <a href="#" class="text-xs text-gray-500 dark:text-gray-300 hover:underline">Forget Password?</a>
                    </div>

                    <input id="loggingPassword" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" type="password" />
                </div>

                <div class="mt-6">
                    <button class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        Sign In
                    </button>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>

                    <a href="#" class="text-xs text-gray-500 uppercase dark:text-gray-400 hover:underline">or sign up</a>

                    <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
                </div>
            </div>
        </div>

        <!-- Modal to display google auth success and OTP generated -->
        <?php if(isset($user_info) && isset($OTP) && isset($qr_code_url)) { ?>
            <div id="google-auth-success-modal" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                    
                                    <svg class="h-6 w-6 text-regreend-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>

                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 text-green-800" id="modal-title">Ultainfinity Login with google test successful</h3>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <p class="text-sm text-gray-500 text-justify">Welcome back, <strong><?php echo $user_info->name ?></strong>. 
                                        Below is your OTP password, expiring in 30 seconds. You can use Google Authenticator to scan the QR code.
                                        </p>
                                        <p class="mt-2 text-center text-2xl"><strong><strong><?php echo $OTP ?></strong><p>
                                        <p class="text-justify">
                                            <img class="text-center" src="<?php echo $qr_code_url?>"/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" id="close-google-auth-success-modal-btn" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <script>
            window.addEventListener("load", (event) => {
                
                let google_auth_success_modal = document.getElementById('google-auth-success-modal');
                let close_btn = document.getElementById('close-google-auth-success-modal-btn');
                let sign_in_with_google_btn =  document.getElementById('sign-in-with-google-btn');
                let sign_in_with_google_spinner =  document.getElementById('sign-in-with-google-spinner');

                sign_in_with_google_btn.addEventListener('click', (event)=>{
                    sign_in_with_google_btn.setAttribute('disabled', '')
                    sign_in_with_google_spinner.removeAttribute('hidden')
                })


                if(typeof close_btn !== 'undefined' && close_btn !== null)
                {
                    close_btn.addEventListener("click", (event) => {
                        if(typeof  google_auth_success_modal !== "undefined" && google_auth_success_modal !== null)
                        {
                            google_auth_success_modal.setAttribute("hidden", '');
                            let url = new URL(window.location.href);
                            url.searchParams.delete('code');
                            url.searchParams.delete('scope');
                            url.searchParams.delete('authuser');
                            url.searchParams.delete('prompt');
                            window.history.pushState({}, '', url);
                        }
                    });
                }
                
            });
        </script>

    </body>

   
</html>

