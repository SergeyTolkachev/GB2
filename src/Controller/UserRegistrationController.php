<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserRegistrationFormType;
use App\Security\LogiAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserRegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param GuardAuthenticatorHandler $handler
     * @param LogiAuthenticator $authenticator
     * @return RedirectResponse|Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, GuardAuthenticatorHandler $handler, LogiAuthenticator $authenticator)
    {
        $form = $this->createForm(UserRegistrationFormType::class, new User());
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $user = $form->getData();
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $handler->authenticateUserAndHandleSuccess($user, $request, $authenticator, 'main');
            return $this->redirectToRoute('wall');
        }

        return $this->render('reg/registration.html.twig', ['form'=> $form->createView()]);
    }
}