Please follow the below steps to configure the package at your laravel project

1. Run the below command to install the package - 
    composer require xoxoday/storefront

2. Now to copy the storefront assets, seeders and config files, please run the below command - 
    php artisan vendor:publish --tag=xostorefront_assets

3. To create tables in the database, please run the below command - 
    php artisan migrate

This package also use xoxoday/sms package for sending sms. Please configure the queue at you laravel project to use the SMS functionaltiy.

Once the above steps are complete you use the access the storefront use below url -

{{your_store_url}}/redemption
