<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Entity\User;
use App\Form\ModifyFormProfileType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;



class RegistrationController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $session = $this->requestStack->getSession();
            $session->set('email',$user->getEmail());

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/modify/{items}/{amount}/{back?home}', name: 'app_modify_user')]
    public function modify( $items, $amount, $back, Request $request, UserRepository $userRepository,  EntityManagerInterface $entityManager): Response
    {
        $session = $this->requestStack->getSession();
        $userId = $session->get('user_id',0);
        
        $user = $userRepository->find($userId);
        
        //$form = $this->createForm(RegistrationFormType::class, $user);

        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('name_user', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('postal_code', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->getForm();
            
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager->persist($user);
                $entityManager->flush();
                
                $session->set('msg','Profil utilisateur modifié');

                return $this->redirectToRoute('app_' . $back);
            }

        $msg = $session->get('msg','');
        $session->remove('msg');

        return $this->renderForm('registration/modify.html.twig', [
            'modifyFormProfile' => $form,
            'items' => $items,
            'amount' => $amount,
            'form' => $form,
            'back' => $back,
            'msg' => $msg
        ]);
    }

    #[Route('/user/pass/modify/{items}/{amount}/{back}', name: 'app_pass_modify_user')]
    public function editPass($items,$amount,$back,Request $request, UserRepository $userRepository,  EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine): Response
    {
        $session = $this->requestStack->getSession();

        if ($request->isMethod('POST')) {
            $userId = $session->get('user_id',0);
            
            $user = $userRepository->find($userId);

            $password = $request->request->get('password');


            if ( $password == $request->request->get('password2')) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $password
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();

                $session->set('msg','Mot de passe modifié');

                return $this->redirectToRoute('app_modify_user',[
                    'items' => $items,
                    'amount' => $amount,
                    'back' => $back
                ]);
            }
            else 
            {
                $session->set('error','Mot de passe incorrect');
                
                return $this->redirectToRoute('app_pass_modify_user',[
                    'items' => $items,
                    'amount' => $amount,
                    'back' => $back
                ]);
            }
        }
        
        $error = $session->get('error','');
        $session->remove('error');

        return $this->render('registration/editPass.html.twig', [
            'items' => $items,
            'amount' => $amount,
            'back' => $back,
            'error' => $error
        ]);
    }

    
}
