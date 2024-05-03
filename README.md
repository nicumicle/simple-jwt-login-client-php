<p align="center">
    <img src="https://ps.w.org/simple-jwt-login/assets/banner-772x250.png?rev=2106097">
</p>
<p align="center">
    <img src="https://github.com/nicumicle/simple-jwt-login-client-php/actions/workflows/build.yml/badge.svg" />
    <img src="https://codecov.io/gh/nicumicle/simple-jwt-login-client-php/branch/master/graph/badge.svg?token=B62kTXfP60"/>
</p>

[![Latest Stable Version](http://poser.pugx.org/nicumicle/simple-jwt-login-client-php/v)](https://packagist.org/packages/nicumicle/simple-jwt-login-client-php)
[![Total Downloads](http://poser.pugx.org/nicumicle/simple-jwt-login-client-php/downloads)](https://packagist.org/packages/nicumicle/simple-jwt-login-client-php)
[![License](http://poser.pugx.org/nicumicle/simple-jwt-login-client-php/license)](https://packagist.org/packages/nicumicle/simple-jwt-login-client-php)
[![PHP Version Require](http://poser.pugx.org/nicumicle/simple-jwt-login-client-php/require/php)](https://packagist.org/packages/nicumicle/simple-jwt-login-client-php)


# The simple-jwt-login PHP client
This client will help you integrate your PHP Application with a WordPress website that is using the [simple-jwt-login](https://wordpress.org/plugins/simple-jwt-login) WordPress plugin.

## Requirements

- PHP : >=5.6
- curl extension

## Installation

```
    composer require nicumicle/simple-jwt-login-client-php
```

## Simple Example

```php
    $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com');
    
    $result = $simpleJwtLogin->registerUser('email@test.com', 'My-password');
    
    //var_dump($result); 
```
The output of result will be the actual API call result.


## How to use it

### Login User

In order to autologin, you will need to redirect to the WordPress website, with the generated URL:

```php
    $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1');
    header('Location: ' . $simpleJwtLogin->getAutologinUrl('My JWT', 'AUTH CODE', 'https://test.com'));
```
The Auth Code parameter is optional. You can set it to `null` If you don't want to use it. 

### Register User

This will register a new user.

```php
    $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1');
    $result = $simpleJwtLogin->registerUser('email@simplejwtlogin.com', 'password', 'AUTH CODE');
```
The Auth Code parameter is optional. You can set it to `null` If you don't want to use it.

The $result value is: 

```
Array
(
    [success] => true
    [id] => 1
    [message] => User was successfully created.
    [user] => Array
        (
            [ID] => 1
            [user_login] => test@simplejwtlogin.com
            [user_nicename] => test@simplejwtlogin.com
            [user_email] => test@simplejwtlogin.com
            [user_url] => 
            [user_registered] => 2021-28-01 15:30:37
            [user_activation_key] => 
            [user_status] => 0
            [display_name] => test@simplejwtlogin.com
            [user_level] => 10
        )

    [jwt] => eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
)
```

### Delete User

This will delete a user.

```php
    $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1');
    $result = $simpleJwtLogin->deleteUser('Your JWT here', 'AUTH CODE');
```
The Auth Code parameter is optional. You can set it to `null` If you don't want to use it.

The $result value is: 
```
Array
(
    [message] => User was successfully deleted.
    [id] => 1
)
```

### Reset Password

This will send the reset password email.

```php
    $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1');
    $result = $simpleJwtLogin->resetPassword('email@simplejwtlogin.com', 'AUTH CODE');
```
The Auth Code parameter is optional. You can set it to `null` If you don't want to use it.

The $result value is:
```
Array
(
    [success] => true
    [message] => Reset password email has been sent.
)
```

### Change password

This will send the reset password email.
The Auth Code parameter is optional. You can set it to `null` If you don't want to use it.

The following code part, will change the user password, using the reset password code:
```php
    $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1');
    $result = $simpleJwtLogin->changePassword('email@simplejwtlogin.com', 'new password', 'code', null, 'AUTH CODE');
```

The following code part, will change the user password, using a JWT:
```php
    $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1');
    $result = $simpleJwtLogin->changePassword('email@simplejwtlogin.com', 'new password', null, 'Your JWT here', 'AUTH CODE');
```

The $result value is:
```
Array
(
    [success] => true
    [message] => User Password has been changed.
)
```

### Authenticate User

The Auth Code parameter is optional. You can set it to `null` If you don't want to use it.

#### Authenticate
This will generate a JWT based on user credentials.

```php
    $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1');
    $result = $simpleJwtLogin->authenticate('email@simplejwtlogin.com', 'your password', 'AUTH CODE');
```

The $result value is: 
```
Array
(
    [success] => true
    [data] => Array
        (
            [jwt] => eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
        )

)
```

#### Refresh token

+The following code will refresh an expired token:

```php
    $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1');
    $result = $simpleJwtLogin->refreshToken('your JWT here', 'AUTH CODE');
```

The $result value is: 

```
Array
(
    [success] => true
    [data] => Array
        (
            [jwt] => eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
        )

)
```


#### Validate token

The following code will check if your JWT is valid or not:

```php
   $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1');
    $result = $simpleJwtLogin->validateToken('your JWT here', 'AUTH CODE');
```

The $result value is:

```
Array
(
    [success] => true
    [data] => Array
        (
            [user] => Array
                (
                    [ID] => 1
                    [user_login] => test@simplejwtlogin.com
                    [user_nicename] => test@simplejwtlogin.com
                    [user_email] => test@simplejwtlogin.com
                    [user_url] => https://simplejwtlogin.com
                    [user_registered] => 2021-28-01 15:30:37
                    [user_activation_key] => 
                    [user_status] => 0
                    [display_name] => test@simplejwtlogin.com
                )

            [jwt] => Array
                (
                    [0] => Array
                        (
                            [token] => eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
                            [header] => Array
                                (
                                    [typ] => JWT
                                    [alg] => HS256
                                )

                            [payload] => Array
                                (
                                    [iat] => 1638459037
                                    [email] => test@simplejwtlogin.com
                                    [id] => 1
                                    [site] => http://localhost
                                    [username] => test@simplejwtlogin.com
                                )

                        )

                )

        )

)
```

#### Revoke token

The following code will invalidate a JWT:

```php
   $simpleJwtLogin = new SimpleJwtLoginClient('https://mydomain.com', '/simple-jwt-login/v1'); 
   $result = $simpleJwtLogin->revokeToken('your JWT here', 'AUTH CODE');
```

The $result value is:
```
Array
(
    [success] => true
    [message] => Token was revoked.
    [data] => Array
        (
            [jwt] => Array
                (
                    [0] => eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
                )
        )
)
```
