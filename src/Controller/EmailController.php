<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class EmailController
 * Gestion de l'envoi des emails pour mdp oublié
 * @package App\Controller
 * @Route("/mdp")
 */
class EmailController extends AbstractController
{
    /**
     * @Route("/sendPasswordEmail", name="sendPasswordEmail", methods={"POST"})
     * @param MailerInterface $mailer
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws TransportExceptionInterface
     */
    public function sendPasswordEmail(MailerInterface $mailer, Request $request)
    {
        $adresse = $request->request->get('_email');

        $userRepo = $this->getDoctrine()->getRepository(Participant::class);
        $user = $userRepo->findOneBy(['email' => $adresse]);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur introuvable, avez-vous correctement saisi votre email?');
        }

        $email = (new TemplatedEmail())
            ->from('contact.sortir.eni@gmail.com')
            ->to($adresse)
            ->subject('Votre nouveau mot de passe')
            ->htmlTemplate('password/mail.html.twig')
            ->context([
                'token' => $user->getToken()
            ]);
        $mailer->send($email);
        $this->addFlash('success', 'Un mail contenant un lien de réinitialisation de mot de passe a été envoyé sur cette adresse mail : ' . $adresse . '.');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/resetPwd/{token}/", name="resetPwd")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     * @return mixed
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->findOneBy(['token' => $token]);


        $password = $request->request->get('_pwd');
        if ($password != null) {
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setToken(substr(str_replace('/', '', $encodedPassword), 50));
            $user->setPassword($encodedPassword);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre mot de passe a bien été changé.');
            return $this->redirectToRoute('app_login');
        }


        return $this->render('email/resetPwd.html.twig', [
            'token' => $token,
        ]);
    }

    /**
     * Simple new User Email sending function
     * @param Mailer $mailer
     * @param User $user
     * @throws TransportExceptionInterface
     */
    private function sendNewUserEmail(Mailer $mailer, User $user)
    {
        $email = (new TemplatedEmail())
            ->from('contact@sortir.com')
            ->to($user->getEmail())
            ->subject('Votre compte sur Rastart.fr')
            ->htmlTemplate('email/mailNouvelUtilisateur.html.twig')
            ->context([
                'token' => $user->getToken()
            ]);
        $mailer->send($email);
    }
}
