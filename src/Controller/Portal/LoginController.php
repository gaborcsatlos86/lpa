<?php

declare(strict_types=1);

namespace App\Controller\Portal;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegistrationType;
use App\Entity\User;
use Symfony\Component\Form\FormError;
use Exception;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('portal/login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
    
    #[Route('/registration', name: 'app_registration')]
    public function registration(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            if ($user->getEmail() == null) {
                $user->setEmail($user->getUsername() . '@lpa-audit.local');
            }
            try {
                $user->setEnabled(true);
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (Exception $e) {
                $form->addError(new FormError($e->getMessage()));
                return $this->render('portal/registration/index.html.twig', [
                    'form' => $form,
                ]);
            }
            
            return $this->redirectToRoute('app_home');
        }
        return $this->render('portal/registration/index.html.twig', [
            'form' => $form,
        ]);
    }
}
