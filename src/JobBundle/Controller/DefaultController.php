<?php

namespace JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

class DefaultController extends Controller {
    
    public function homePageRedirectAction(){
        return $this->render('JobBundle:Default:index.html.twig');
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.context')->getToken()->getUser();
            if ($user->hasRole('ROLE_ORDINARY_JOBSEEKER')) {
                $jobSeakerDetails = $em->getRepository("JobBundle:JobSeeker")->findOneByUserId($user->getId());
                if ($jobSeakerDetails) {
                    if ($jobSeakerDetails->getRegistrationComplete()) {
                        return $this->render('JobBundle:Default:index.html.twig');
                    } else {
                        return $this->redirect($this->generateUrl('job_seeker_resume_form'));
                    }
                } else {
                    return $this->redirect($this->generateUrl('job_seeker_details_form'));
                }
            } else if ($user->hasRole('ROLE_MAIN_ADMIN')) {
                return $this->redirect($this->generateUrl('main_admin_home_page'));
            } else {
                return $this->render('JobBundle:Default:index.html.twig');
            }
        } else {
            return $this->render('JobBundle:Default:index.html.twig');
        }
    }

    public function redirectToLoginPageAction(Request $request) {
        return $this->redirect($this->generateUrl('login'));
    }

    public function newUserRegistrationAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $userEntity = new \AkjnBundle\Entity\User();
        $userForm = new \JobBundle\Form\UserType();
        $form = $this->createForm($userForm, $userEntity, array("action" => $this->generateUrl("new_user_creation")));
        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $userType = $form['userType']->getData();
                if ($userType == 'jobSeeker') {
                    $role = 'ROLE_ORDINARY_JOBSEEKER';
                } else {
                    $role = 'ROLE_JOB_EMPLOYEER';
                }
                $fosUserManager = $this->get('fos_user.user_manager');
                $newUser = $fosUserManager->createUser();
                $newUser->setUsername($form['username']->getData());
                $newUser->setPlainPassword($form['password']->getData());
                $newUser->setMobileNumber($form['mobile']->getData());
                $newUser->setEnabled(true);
                $newUser->setRoles(array($role));
                $newUser->setEmail($form['email']->getData());
                $newUser->setName($form['name']->getData());
                $fosUserManager->updateUser($newUser);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'New user created successfully with username "' . $form['username']->getData() . '" with given password.');
                return $this->redirect($this->generateUrl('redirect_login_page'));
            } catch (UniqueConstraintViolationException $e) {
                $this->get('session')->getFlashBag()->add('danger', 'You have already created an account with username ' . $form['username']->getData());
                return $this->redirect($this->generateUrl('redirect_login_page'));
            }
        }
        return new JsonResponse($this->renderView('JobBundle:Default:usersAddForm.html.twig', array("form" => $form->createView())));
    }

    public function newUserUsernameCheckAction($name) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AkjnBundle:User")->findOneByUsername($name);
        if ($user) {
            return new JsonResponse("false");
        } else {
            return new JsonResponse("true");
        }
    }

    public function homePageJobSearchAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('home_page_job_search'))
                ->add('jobTitle', 'text', array('attr' => array('class' => 'form-control', 'placeholder' => 'Looking for job')))
                ->add('category', 'entity', array(
                    'class' => 'JobBundle:JobCategory',
                    'property' => 'category',
                    'empty_value' => 'Category',
                    'attr' => array('class' => 'form-control'),
                ))
                ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                    $data = $event->getData();
                    $form = $event->getForm();
                    $category = null;
                    $form->add('subCategory', 'entity', array(
                        'class' => 'JobBundle:JobSubCategory',
                        'property' => 'subCategory',
                        'attr' => array('class' => 'form-control'),
                        'empty_value' => 'Sub Category',
                        'query_builder' => function (EntityRepository $er) use($category) {
                            $qb = $er->createQueryBuilder('s')
                                    ->where('s.category=0')
                                    ->orderBy('s.subCategory', 'ASC');
                            return $qb;
                        }));
                })
                ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                    $data = $event->getData();
                    $form = $event->getForm();
                    $category = array_key_exists('category', $data) ? $data['category'] : 0;
                    $form->add('subCategory', 'entity', array(
                        'class' => 'JobBundle:JobSubCategory',
                        'property' => 'subCategory',
                        'attr' => array('class' => 'form-control'),
                        'empty_value' => 'Sub Category',
                        'query_builder' => function (EntityRepository $er) use($category) {
                            $qb = $er->createQueryBuilder('s')
                                    ->where('s.category=' . $category)
                                    ->orderBy('s.subCategory', 'ASC');
                            return $qb;
                        }));
                })
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $jobTitle = $form['jobTitle']->getData();
            $category = $form['category']->getData();
            $subCategory = $form['subCategory']->getData();
            $qb = $em->createQueryBuilder();
            $jobs = $qb->select('j')
                    ->from("JobBundle:Jobs", "j")
                    ->where("j.category = :cat")
                    ->andWhere("j.subCategory = :subcat")
                    ->andWhere('j.jobTitle LIKE :title OR j.jobDescription LIKE :desc OR j.jobDesignation LIKE :desig OR j.skillsRequired LIKE :skills OR j.company LIKE :cmpny')
                    ->orderBy("j.addedDate", "DESC")
                    ->setParameter('title', '%' . $jobTitle . '%')
                    ->setParameter('desc', '%' . $jobTitle . '%')
                    ->setParameter('desig', '%' . $jobTitle . '%')
                    ->setParameter('skills', '%' . $jobTitle . '%')
                    ->setParameter('cmpny', '%' . $jobTitle . '%')
                    ->setParameter('cat', $category->getId())
                    ->setParameter('subcat', $subCategory->getId())
                    ->getQuery()
                    ->getResult();
            $formData = array(
                'Job Title' => $form['jobTitle']->getData(),
                'Category' => $form['category']->getData()->getCategory(),
                'Sub-Category' => $form['subCategory']->getData()->getSubCategory()
            );
            return $this->render('JobBundle:JobSearch:showResults.html.twig', array('jobs' => $jobs, 'formData' => $formData));
        }
        return $this->render('JobBundle:Default:homePageJobSearch.html.twig', array('form' => $form->createView()));
    }

    public function searchForJobsAction() {
        $em = $this->getDoctrine()->getManager();
        $jobs = $em->getRepository("JobBundle:Jobs")->findBy(array(),array('priority'=>'DESC'));
        return $this->render('JobBundle:JobSearch:index.html.twig',array('jobs'=>$jobs));
    }

    public function homeShowHotJobsAction() {
        $em = $this->getDoctrine()->getManager();
        $jobs = $em->getRepository("JobBundle:Jobs")->findBy(array('frontPageVisible' => true));
        return $this->render('JobBundle:Default:hotJobs.html.twig', array('jobs' => $jobs));
    }

    public function homeShowGoldenResumeAction() {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $goldanApplicants = $qb->select('jr')
                ->from('JobBundle:JobSeekerResume', 'jr')
                ->innerJoin('JobBundle:JobSeeker', 'ap', 'WITH', 'jr.jobSeekerId = ap.id')
                ->where('jr.showInFrontPage = 1')
                ->andWhere('ap.priorityFlag = 1')
                ->getQuery()
                ->getResult();
        return $this->render('JobBundle:Default:goldenResume.html.twig', array('applicants' => $goldanApplicants));
    }

    public function searchForGoldenResumeAction() {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $goldanApplicants = $qb->select('jr')
                ->from('JobBundle:JobSeekerResume', 'jr')
                ->innerJoin('JobBundle:JobSeeker', 'ap', 'WITH', 'jr.jobSeekerId = ap.id')
                ->andWhere('ap.priorityFlag = 1')
                 ->orderBy('ap.createdDate', 'ASC')
                ->getQuery()
                ->getResult();
        return $this->render('JobBundle:ResumeSearch:index.html.twig', array('applicants'=>$goldanApplicants));
    }

}
