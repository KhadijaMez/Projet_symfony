<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les erreurs d'authentification, s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [ // Utilisez votre propre chemin ici
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/forgot-password', name: 'forgot_password')]
    public function forgotPassword(): Response
    {
        return $this->render('login/forgot_password.html.twig');
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('login/register.html.twig');
    }


    #[Route('/register', name: 'register', methods: ['GET','POST'])]
public function handleRegister(Request $request): Response
{
    if ($request->isMethod('POST')) {
    $userType = $request->request->get('user_type');
    $email = $request->request->get('email');
    $password = $request->request->get('password');
    $confirmPassword = $request->request->get('confirm_password');

    if ($password !== $confirmPassword) {
        $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
        return $this->redirectToRoute('register');
    }

    if ($userType === 'student') {
        // Logique spécifique aux étudiants
        $studentNumber = $request->request->get('student_number');
        $studentDepartment = $request->request->get('student_department');
        // Sauvegarder les données pour un étudiant...
    } elseif ($userType === 'technician') {
        // Logique spécifique aux techniciens
        $techSpecialty = $request->request->get('tech_specialty');
        $experienceYears = $request->request->get('experience_years');
        // Sauvegarder les données pour un technicien...
    }

    // Sauvegarder l'utilisateur en général
    $this->addFlash('success', 'Inscription réussie !');
    return $this->redirectToRoute('app_home');
}  
return $this->render('login/register.html.twig');
}
#[Route('/reset-password', name: 'reset_password')]
public function resetPassword(Request $request, MailerInterface $mailer): Response
{
    $email = $request->request->get('email');

    if ($email) {
        // Simulez l'envoi d'un email ou ajoutez votre logique ici
        $this->addFlash('success', 'Password reset instructions have been sent to your email.');
        return $this->redirectToRoute('app_login');
    }

    return $this->render('security/reset_password.html.twig');
}

}



