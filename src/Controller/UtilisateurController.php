<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Form\EditProfilType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EditPasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Form\EditUserType;
use App\Form\DeleteUserType;
use App\Repository\LogConnexionRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Photo;






final class UtilisateurController extends AbstractController
{
    #[Route('/admin-liste-utilisateurs', name: 'app_utilisateur', methods: ['GET', 'POST'])]
    public function listeUtilisateurs(Request $request, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $users = $userRepository->findAll();
        $form = $this->createForm(DeleteUserType::class, null, [
            'users' => $users
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedUsers = $form->get('users')->getData();
            foreach ($selectedUsers as $user) {
                $em->remove($user);
            }
            $em->flush();
            $this->addFlash('notice', 'Utilisateurs supprimés avec succès');
            return $this->redirectToRoute('app_utilisateurs');
        }

        return $this->render('utilisateur/liste-utilisateurs.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin-edit-user/{id}', name: 'app_edit_user')]
    public function EditUser(Request $request, User $user, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EditUserType::class, $user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($user);
                $em->flush();
                $this->addFlash('notice', 'Utilisateur modifié');
                return $this->redirectToRoute('app_utilisateur');
            }
        }

        return $this->render('utilisateur/edit-user.html.twig', [
            'form' => $form->createView()


        ]);
    }
    #[Route('/admin-delete-user/{id}', name: 'app_delete_user')]
    public function DeletUser(Request $request, User $user, EntityManagerInterface $em): Response
    {
        if ($user != null) {
            $em->remove($user);
            $em->flush();
            $this->addFlash('notice', 'Utilisateur supprimé');
        }
        return $this->redirectToRoute('app_utilisateur');
    }
    #[Route('/admin-log-connexion/{id}', name: 'app_log_connexion', requirements: ['id' => '\d+'])]
    public function logConnexion(User $user, LogConnexionRepository $logConnexionRepository): Response
    {
        $logConnexions = $logConnexionRepository->findBy(
            ['user' => $user],
            ['timeConnexion' => 'DESC']
        );
        return $this->render('utilisateur/log_connexion.html.twig', [
            'logConnexions' => $logConnexions,
        ]);
    }

    #[Route('/admin-statistics', name: 'app_statistics')]
    public function statistics(UserRepository $userRepository): Response
    {
        return $this->render('utilisateur/statistics.html.twig', [
            'total' => $userRepository->countAllUsers(),
            'active' => $userRepository->countActiveUsers(),
            'disabled' => $userRepository->countDisabledUsers(),
            'admins' => $userRepository->countAdmins(),
        ]);
    }




    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        $utilisateur = $this->getUser();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('utilisateur/profil.html.twig', [
            'utilisateur' => $utilisateur
        ]);
    }
    #[Route('/edit-profil', name: 'app_edit_profil')]
    public function EditProfil(Request $request, EntityManagerInterface $em,): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('notice', 'Vous devez être connecté pour modifié votre profil.');
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(EditProfilType::class, $user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $photoFile = $form->get('photo')->getData();

                if ($photoFile) {
                    $newFilename = uniqid() . '.' . $photoFile->guessExtension();

                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );

                    $photo = $user->getPhoto() ?? new Photo();
                    $photo->setNomFichier($newFilename);
                    $photo->setDateUpload(new \DateTime());
                    $photo->setUser($user);

                    $em->persist($photo);
                    $em->flush();
                }
                $em->flush();
                $this->addFlash('notice', 'votre profil à été mis à jour avec succès !');
                return $this->redirectToRoute('app_profil');
            }
        }

        return $this->render('base/edit-profil.html.twig', [
            'form' => $form->createView()

        ]);
    }
    #[Route('/edit-password', name: 'app_edit_password')]
    public function EditPassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour modifié votre profil.');
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(EditPasswordType::class, $user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $data = $form->getData();
                $newPassword = $form->get('newPassword')->getData();

                if (password_verify($newPassword, $user->getPassword())) {
                    $this->addFlash('notice', 'Vous ne pouvez pas réutiliser votre ancien mot de passe.');
                    return $this->redirectToRoute('app_edit_password');
                }
                $hashedPassword = $hasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);



                $em->persist($user);
                $em->flush();
                $this->addFlash('notice', 'Merci ibra ! Votre mot de passe à été modifié avec succès !');
                return $this->redirectToRoute('app_profil');
            }
        }
        return $this->render('base/edit-password.html.twig', [
            'form' => $form->createView()

        ]);
    }
}
