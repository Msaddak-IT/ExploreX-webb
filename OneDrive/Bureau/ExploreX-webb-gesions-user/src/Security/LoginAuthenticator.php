<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface; // Added this line
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    private AuthorizationCheckerInterface $authorizationChecker; // Added this line
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator, AuthorizationCheckerInterface $authorizationChecker) // Modified this line
    {
        $this->urlGenerator = $urlGenerator;
        $this->authorizationChecker = $authorizationChecker; // Added this line
    }

    public const LOGIN_ROUTE = 'app_login';

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Check if the user has either ROLE_USER or ROLE_ADMIN
        if ($this->authorizationChecker->isGranted('ROLE_USER', $token) || $this->authorizationChecker->isGranted('ROLE_ADMIN', $token)) {
            if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
                return new RedirectResponse($targetPath);
            }

            // Redirect based on the user's role
            if ($this->authorizationChecker->isGranted('ROLE_ADMIN', $token)) {
                return new RedirectResponse($this->urlGenerator->generate('app_code_promo_index'));
            }

            return new RedirectResponse($this->urlGenerator->generate('app_home'));


        }

        // If no matching roles are found, throw an exception
        throw new \LogicException('Invalid user roles');
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
