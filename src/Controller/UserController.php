<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * encodage du mot de passe
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    public  function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this -> passwordEncoder = $passwordEncoder;
    }

    /**
     * Vue du profil utilisateur par l'utilisateur
     * @param User $user
     * @return Response
     * @Route("mon-profil/{id}/profil", name="profil_show", methods={"GET","POST"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Edition d'un user par ce même user
     * @param User $user
     * @return Response
     * @Route("user/{id}/edit", name="profil_edit", methods={"GET","POST"})
     */
    public function edit(User $user): Response
    {
        // TODO pouvoir modifier le profil
        return $this->render('user/edit.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * ajouter un user par un admin
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @Route("admin/user/new", name="new_user", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer): Response
    {
        $user = new User();
        $user -> setPassword('123456');
        $user -> setToken('azerty');
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $passwordEncoded = $this->passwordEncoder->encodePassword($user, '123456');
            $user->setPassword($passwordEncoded);
            $user->setToken(substr(str_replace('/', '',$passwordEncoded),50));
            /*
            $imageFile = $user->getImageFile();
            if($imageFile){
                $safeFileName = uniqid();
                $newFileName = $safeFileName.".".$imageFile->guessExtension();
                $imageFile->move($this->getParameter('upload_dir'),$newFileName);
                $user->setImageUrl($newFileName);
            }
            */
            $entityManager->persist($user);
            $entityManager->flush();
            $this->sendNewUserEmail($mailer,$user);

            return $this->redirectToRoute('home');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Simple new User Email sending function
     * @param Mailer $mailer
     * @param User $user
     */
    private function sendNewUserEmail(Mailer $mailer, User $user)
    {
        $email = (new TemplatedEmail())
            ->from('contact@rastart.fr')
            ->to($user->getEmail())
            ->subject('Votre compte sur Rastart.fr')
            ->htmlTemplate('email/mailNouvelUtilisateur.html.twig')
            ->context([
                'token'=>$user->getToken()
            ]);
        $mailer->send($email);
    }
}
