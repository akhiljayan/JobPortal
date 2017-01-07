<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;

/**
 * Description of MainAdminController
 *
 * @author akhil
 */
class MainAdminController extends Controller {

    public function indexAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user->hasRole('ROLE_MAIN_ADMIN')) {
            return $this->render('JobBundle:MainAdmin:index.html.twig');
        } else {
            return $this->render('JobBundle:Default:index.html.twig');
        }
    }

    public function manageMastersAction() {
        return $this->render('JobBundle:MainAdmin/Masters:index.html.twig');
    }

    public function manageMastersAddCategoryAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $categoryName = $request->request->get('category');
        $categoryEntity = new \JobBundle\Entity\JobCategory();
        $categoryEntity->setCategory($categoryName);
        $em->persist($categoryEntity);
        $em->flush();
        return new JsonResponse(true);
    }

    public function manageMastersAddSubCategoryAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $subEntity = new \JobBundle\Entity\JobSubCategory();
        $sybType = new \JobBundle\Form\JobSubCategoryType();
        $form = $this->createForm($sybType, $subEntity, array("action" => $this->generateUrl("manage_masters_add_sub_category")));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $subEntity->setStatus(true);
            $em->persist($subEntity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'New Sub Category Added!!');
            return $this->redirect($this->generateUrl('main_admin_manage_masters'));
        }
        return new JsonResponse($this->renderView('JobBundle:MainAdmin/Masters:addSubCategory.html.twig', array('form' => $form->createView())));
    }

    public function addNewJobAction(Request $request) {
        $array[] = "";
        for ($i = 0; $i < 21; $i++) {
            $array[$i] = $i;
        }
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $jobEntity = new \JobBundle\Entity\Jobs();
        $jobType = new \JobBundle\Form\JobsType($array);
        $form = $this->createForm($jobType, $jobEntity, array("action" => $this->generateUrl("main_admin_add_job")));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $jobEntity->setStatus(TRUE);
            $jobEntity->setPriority(FALSE);
            $jobEntity->setGuId(md5(uniqid(php_uname('n'))));
            $jobEntity->setAddedDate(new \DateTime('now'));
            $jobEntity->setAddedByUser($user);
            $em->persist($jobEntity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'New Job was added successfully!!');
            return $this->redirect($this->generateUrl('main_admin_home_page'));
        }
        return $this->render('JobBundle:MainAdmin/Jobs:addNewJob.html.twig', array('form' => $form->createView()));
    }

    public function manageAplicantsAction() {
        $em = $this->getDoctrine()->getManager();
        $aplicantResume = $em->getRepository("JobBundle:JobSeekerResume")->findAll();
        return $this->render('JobBundle:MainAdmin/Applicants:listAll.html.twig', array('applicants' => $aplicantResume));
    }

    public function changeApplicantPriorityAction(Request $request, $guId) {
        $em = $this->getDoctrine()->getManager();
        $applicant = $em->getRepository("JobBundle:JobSeeker")->findOneByGuId($guId);
        if ($applicant->getPriorityFlag() == true) {
            $applicant->setPriorityFlag(false);
            $flag = 'madeFalse';
        } else {
            $applicant->setPriorityFlag(true);
            $flag = 'madeTrue';
        }
        $em->persist($applicant);
        $em->flush();
        return new JsonResponse(array($flag, $applicant->getFirstName() . " " . $applicant->getLastName()));
    }

    public function manageJobsAction() {
        $em = $this->getDoctrine()->getManager();
        $jobs = $em->getRepository("JobBundle:Jobs")->findAll();
        return $this->render('JobBundle:MainAdmin/Jobs:listAll.html.twig', array('jobs' => $jobs));
    }

    public function changeJobPriorityAction(Request $request, $guId) {
        $em = $this->getDoctrine()->getManager();
        $jobs = $em->getRepository("JobBundle:Jobs")->findBy(array('frontPageVisible' => true));
        $thisJob = $em->getRepository("JobBundle:Jobs")->findOneByGuId($guId);
        if ($thisJob->getFrontPageVisible()) {
            $thisJob->setFrontPageVisible(false);
            $em->persist($thisJob);
            $em->flush();
            $message = $thisJob->getJobTitle() . " removed from main page !!!";
        } else {
            if (count($jobs) <= 12) {
                $thisJob->setFrontPageVisible(true);
                $em->persist($thisJob);
                $message = $thisJob->getJobTitle() . " added to main page !!!";
            } else {
                $message = "There are already 10 jobs in the home page. Please remove one to add a new !!!";
            }
            $em->flush();
        }
        return new JsonResponse($message);
    }

    public function changeJobFeatureAction(Request $request, $guId) {
        $em = $this->getDoctrine()->getManager();
        $jobs = $em->getRepository("JobBundle:Jobs")->findBy(array('priority' => true));
        $thisJob = $em->getRepository("JobBundle:Jobs")->findOneByGuId($guId);
        if ($thisJob->getPriority()) {
            $thisJob->setPriority(false);
            $em->persist($thisJob);
            $em->flush();
            $message = $thisJob->getJobTitle() . " marked as non featured job !!!";
        } else {
            $thisJob->setPriority(true);
            $em->persist($thisJob);
            $message = $thisJob->getJobTitle() . " marked as featured job !!!";
            $em->flush();
        }
        return new JsonResponse($message);
    }

    public function showApplicantInFrontPageAction($guId) {
        $em = $this->getDoctrine()->getManager();
        $applicant = $em->getRepository("JobBundle:JobSeekerResume")->findBy(array('showInFrontPage' => true));
        $thisApplicant = $em->getRepository("JobBundle:JobSeekerResume")->findOneByGuId($guId);
        if ($thisApplicant->getShowInFrontPage()) {
            $thisApplicant->setShowInFrontPage(false);
            $em->persist($thisApplicant);
            $message = $thisApplicant->getJobSeekerId()->getFirstName() . " has been removed from main page.. Please refresh the page to effect the changes.";
        } else {
            if (count($applicant) <= 5) {
                $thisApplicant->setShowInFrontPage(true);
                $em->persist($thisApplicant);
                $message = $thisApplicant->getJobSeekerId()->getFirstName() . " have been added to the main page.. Please refresh the page to effect the changes.";
            } else {
                $message = "Already 5 aplicants added to front page.. please remove one to add.. (Please refresh the page to effect the changes.)";
            }
        }
        $em->flush();
        return new JsonResponse($message);
    }

    public function mainAdminAddAplicantsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $userEntity = new \AkjnBundle\Entity\User();
        $userForm = new \JobBundle\Form\UserType();
        $form = $this->createForm($userForm, $userEntity, array("action" => $this->generateUrl("main_admin_add_aplicants")));
//        dump($form);
//        die;
        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $role = 'ROLE_ORDINARY_JOBSEEKER';
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
                $this->get('session')->getFlashBag()->add('success', 'Login account for applicant with username "' . $form['username']->getData() . '" with password "' . $form['password']->getData());
                return $this->redirect($this->generateUrl('main_admin_add_aplicants_second_phase',array('guId'=>$newUser->getGuId())));
            } catch (UniqueConstraintViolationException $e) {
                $this->get('session')->getFlashBag()->add('danger', 'You have already created an account with username ' . $form['username']->getData());
                return $this->redirect($this->generateUrl('redirect_login_page'));
            }
        }
        return $this->render('JobBundle:MainAdmin/Applicants:applicantAddMainForm.html.twig', array("form" => $form->createView()));
    }

    public function mainAdminAddAplicantsSecondPhaseAction($guId) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AkjnBundle:User")->findOneByGuId($guId);
        $jobSeakerDetails = $em->getRepository("JobBundle:JobSeeker")->findOneByUserId($user->getId());
        if ($jobSeakerDetails) {
            if ($jobSeakerDetails->getRegistrationComplete()) {
                return $this->render('JobBundle:Default:index.html.twig');
            } else {
                return $this->redirect($this->generateUrl('job_seeker_resume_form_main_admin',array('guId'=>$guId)));
            }
        } else {
            return $this->redirect($this->generateUrl('job_seeker_details_form_main_admin',array('guId'=>$guId)));
        }
    }
    
    public function mainAdminAplicantsDetailsAction(Request $request, $guId){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AkjnBundle:User")->findOneByGuId($guId);
        $jobSeekerEntity = new \JobBundle\Entity\JobSeeker();
        $jobSeekerType = new \JobBundle\Form\JobSeekerType();
        $form = $this->createForm($jobSeekerType, $jobSeekerEntity, array("action" => $this->generateUrl('job_seeker_details_form_main_admin',array('guId'=>$guId))));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dob = new \DateTime($form['dob']->getData());
            $jobSeekerEntity->setDob($dob);
            $jobSeekerEntity->setUserImage(" ");
            $jobSeekerEntity->setPriorityFlag(false);
            $jobSeekerEntity->setRegistrationComplete(false);
            $jobSeekerEntity->setUserId($user);
            $jobSeekerEntity->setCreatedBy($user);
            $jobSeekerEntity->setCreatedDate(new \DateTime('now'));
            $em->persist($jobSeekerEntity);
            $em->flush();
            return $this->redirect($this->generateUrl('job_seeker_resume_form_main_admin',array('guId'=>$guId)));
        }
        return $this->render('JobBundle:MainAdmin/Applicants:jobSeekerDetailsMainAdmin.html.twig', array('form' => $form->createView()));
    }
    
    public function mainAdminAplicantsResumeAction(Request $request, $guId){
         $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AkjnBundle:User")->findOneByGuId($guId);
        $jobSeekerDetails = $em->getRepository("JobBundle:JobSeeker")->findOneByUserId($user->getId());
        $dob = $jobSeekerDetails->getDob();
        $now = new \DateTime('now');
        $age = $dob->diff($now)->y;
        $jobSeekerResumeEntity = new \JobBundle\Entity\JobSeekerResume();
        $jobSeekerResumeType = new \JobBundle\Form\JobSeekerResumeType();
        $form = $this->createForm($jobSeekerResumeType, $jobSeekerResumeEntity, array("action" => $this->generateUrl('job_seeker_resume_form_main_admin',array('guId'=>$guId))));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $jobSeekerResumeEntity->getResume();
            $fileName = $file->getClientOriginalName();
            $fileNameFinal = preg_replace('/\s+/', '_', $fileName);
            $file->move($this->getParameter('upload_dir'), $jobSeekerDetails->getId() . '_' . $fileNameFinal);
            $wrkExps = $jobSeekerResumeEntity->getWorkExpResume();
            $educations = $jobSeekerResumeEntity->getResumeEducation();
            foreach ($wrkExps as $keyWrk=>$wrkExp) {
                $fromDate = $form['workExpResume'][$keyWrk]['fromDate']->getData();
                $Todate = $form['workExpResume'][$keyWrk]['toDate']->getData();
                $wrkExp->setFromDate(new DateTime($fromDate));
                $wrkExp->setToDate(new DateTime($Todate));
                $wrkExp->setResumeId($jobSeekerResumeEntity);
            }
            foreach ($educations as $keyEdu=>$education) {
                $fromDate = $form['resumeEducation'][$keyEdu]['fromDate']->getData();
                $Todate = $form['resumeEducation'][$keyEdu]['toDate']->getData();
                $education->setFromDate(new DateTime($fromDate));
                $education->setToDate(new DateTime($Todate));
                $education->setResumeId($jobSeekerResumeEntity);
            }
            $jobSeekerDetails->setRegistrationComplete(true);
            $jobSeekerResumeEntity->setJobSeekerId($jobSeekerDetails);
            $jobSeekerResumeEntity->setResume($jobSeekerDetails->getId() . '_' . $fileNameFinal);
            $em->persist($jobSeekerDetails);
            $em->persist($jobSeekerResumeEntity);
            $em->flush();
            return $this->redirect($this->generateUrl('home_page'));
        }
        return $this->render('JobBundle:MainAdmin/Applicants:resumeDetailsMainAdmin.html.twig', array('form' => $form->createView(), 'jobSeeker' => $jobSeekerDetails, 'age' => $age));
    }

}
