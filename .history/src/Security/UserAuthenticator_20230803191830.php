<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    public const LOG_ROUTE = 'app_log';
    #public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request,  TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
        

        $userRoles = $token->getRoleNames();

        // Rediriger en fonction du rôle de l'utilisateur
        if (in_array('ROLE_ADMIN', $userRoles, true)) {
            return new RedirectResponse($this->urlGenerator->generate('admin_dashboard'));
        } elseif (in_array('ROLE_DIRECTEUR', $userRoles, true)) {
            return new RedirectResponse($this->urlGenerator->generate('directeur_dashboard'));
        } elseif (in_array('ROLE_SECRETAIRE', $userRoles, true)) {
            return new RedirectResponse($this->urlGenerator->generate('secretaire_dashboard'));
        }else {
            return new RedirectResponse($this->urlGenerator->generate('eleve_dashboard'));
        }
    }

    protected function getLoginUrl(Request $request): string
    {
        if ($request->attributes->get('_route') === 'app_login') {
            return $this->urlGenerator->generate(self::LOGIN_ROUTE);
        } else {
            return $this->urlGenerator->generate(self::LOG_ROUTE);
        }
       
    }

   
}
