## A Laravel 5 friendly wrapper around the Aylien PHP SDK

<img src="http://i.imgur.com/zwCSbUS.png">

[Aylien](http://aylien.com) is a package consisting of eight different Natural Language Processing, Information Retrieval and Machine Learning APIs that can be adapted to your processes and applications with relative ease. Admittidly this wrapper doesn't add a significant value to their extensive, well documented [PHP SDK](https://github.com/AYLIEN/aylien_textapi_php), as the primary purpose is to provide the facade `Aylien::` to your Laravel 5 app.

---

[![Latest Stable Version](https://poser.pugx.org/hopkins/laravel-aylien-wrapper/version.svg)](https://packagist.org/packages/hopkins/laravel-aylien-wrapper) 
[![Total Downloads](https://poser.pugx.org/hopkins/laravel-aylien-wrapper/downloads.svg)](https://packagist.org/packages/hopkins/laravel-aylien-wrapper)
[![Latest Unstable Version](https://poser.pugx.org/hopkins/laravel-aylien-wrapper/v/unstable.svg)](//packagist.org/packages/hopkins/laravel-aylien-wrapper) 
[![License](https://poser.pugx.org/hopkins/laravel-aylien-wrapper/license.svg)](https://packagist.org/packages/hopkins/laravel-aylien-wrapper)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/476da0a5-d091-4fcb-8115-d07765b2214e/mini.png)](https://insight.sensiolabs.com/projects/476da0a5-d091-4fcb-8115-d07765b2214e)

---

#Installation

Require this package in your `composer.json` and update composer. Run/add either of the below two commands
```php
"hopkins/laravel-aylien-wrapper": "dev-master"
```
or
```php
composer require hopkins/laravel-aylien-wrapper=dev-master
```

After updating composer, add the ServiceProvider to the providers array in `app/config/app.php`

```php
'Hopkins\LaravelAylienWrapper\Providers\AylienServiceProvider',
```

and the facade into your array of facades

```php
'Aylien'    => 'Hopkins\LaravelAylienWrapper\Facades\Aylien',
```

Run the artisan command to bring the config into your project

```php
php artisan vendor:publish
```

I put my api keys in the .env file. To use this style of config you can copy the below into your `config/aylien.php`

```php
return [
    'app_id' => env('API_AYLIEN_APP_ID'),
    'app_key' => env('API_AYLIEN_APP_KEY')
];
```

---

#How to use

Aylien provides a number of great examples on their site, as well as [terrific documentation](https://developer.aylien.com/getting-started/php). However I'd feel bad if I didn't at least provide one example. The example at the bottom of the readme uses the Sentiment analysis, however all of the following are available for use
 
```php
Aylien::Sentiment();
Aylien::Extract();
Aylien::Classify();
Aylien::Concepts();
Aylien::Hashtags();
Aylien::Entities();
Aylien::Language();
Aylien::Related();
Aylien::Summarize();
Aylien::Microformats();
Aylien::UnsupervisedClassify();
```
 
Let's say you want to log all messages you receive from a chat/email client/contact form. You'd have a `Message.php` model in this case that saved to your database. By adding a `public static function boot()` method we can utilize Laravel's [model events](http://laravel.com/docs/master/eloquent#model-events) to make sure first we get the message into the db, and then take the time to call Aylien's API. The below example is using the Sentiment anaylisis

```php
class Message extends BaseModel
{
    protected $guarded = ['id'];
    public static function boot()
    {
        parent::boot();
        Message::created(function(Message $message)
        {
            $aylienResponse = \Aylien::Sentiment(['text'=>$message->message]);
            $message->update([
                'polarity' => $aylienResponse->polarity,
                'polarity_confidence' => $aylienResponse->polarity_confidence,
                'subjectivity' => $aylienResponse->subjectivity,
                'subjectivity_confidence' => $aylienResponse->subjectivity_confidence
            ]);
        });
    }
}
```
