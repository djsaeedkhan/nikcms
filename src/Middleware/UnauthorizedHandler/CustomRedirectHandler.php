<?php
declare( strict_types = 1 );

namespace App\Middleware\UnauthorizedHandler;

use Authorization\Exception\Exception;
use Authorization\Middleware\UnauthorizedHandler\RedirectHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Routing\Router;

use Authorization\Exception\MissingIdentityException;
use Authorization\Exception\ForbiddenException;

class CustomRedirectHandler extends RedirectHandler
{
    public function handle( \Exception $exception, ServerRequestInterface $request, array $options = [] ): ResponseInterface {
        $response = parent::handle($exception, $request, $options);
        $identity = $request->getAttribute('identity');
        
        // اگر کاربر لاگین نکرده
        if (!$identity) {
            $queryParam = $options['queryParam'] ?'redirect': 'redirect';

            return ($response)
                ->withHeader(
                    'Location',
                    Router::url('/users/login') . '?' . $queryParam . '=' . urlencode($request->getRequestTarget())
                )
                ->withStatus(302);
        }

        // اگر کاربر لاگین هست ولی دسترسی ندارد
        if ($exception instanceof ForbiddenException) {
            $request->getFlash()->error( 'دسترسی شما به این بخش محدود شده است.' );
            $redirectUrl = $request->getHeaderLine('Referer') ?:Router::url('/');// $this->url
            return ($response)
                ->withHeader('Location', $redirectUrl)
                ->withStatus(302);
        }
        return $response;
    }
}

/* class CustomRedirectHandler extends RedirectHandler {
    public function handle( Exception $exception, ServerRequestInterface $request, array $options = [] ): ResponseInterface {

        $response = parent::handle( $exception, $request, $options );
        $request->getFlash()->error( 'You are not authorized to access that location' );
        return $response;

        
        $referer = $request->getHeaderLine('Referer');
        $redirectUrl = $referer ?:Router::url('/');// $this->url
        $request->getFlash()->error( 'You are not authorized to access that location' );
        $response = parent::handle( $exception, $request, $options );
        return ($response)
            ->withStatus(302)
            ->withHeader('Location', $redirectUrl);
    }
} */