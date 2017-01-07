<?php

namespace JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Date;
use DateTime;

/**
 * Description of JobSeekerController
 *
 * @author akhiljayan
 */
class JobSeekerController extends Controller {

    public function jobSeekerDetailsFormAction(Request $request) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $jobSeekerEntity = new \JobBundle\Entity\JobSeeker();
        $jobSeekerType = new \JobBundle\Form\JobSeekerType();
        $form = $this->createForm($jobSeekerType, $jobSeekerEntity, array("action" => $this->generateUrl("job_seeker_details_form")));
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
            return $this->redirect($this->generateUrl('job_seeker_resume_form'));
        }
        return $this->render('JobBundle:JobSeeker:jobSeekerDetails.html.twig', array('form' => $form->createView()));
    }

    public function jobSeekerResumeFormAction(Request $request) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $jobSeekerDetails = $em->getRepository("JobBundle:JobSeeker")->findOneByUserId($user->getId());
        $dob = $jobSeekerDetails->getDob();
        $now = new \DateTime('now');
        $age = $dob->diff($now)->y;

        $jobSeekerResumeEntity = new \JobBundle\Entity\JobSeekerResume();
        $jobSeekerResumeType = new \JobBundle\Form\JobSeekerResumeType();
        $form = $this->createForm($jobSeekerResumeType, $jobSeekerResumeEntity, array("action" => $this->generateUrl("job_seeker_resume_form")));
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

        return $this->render('JobBundle:JobSeeker:resumeDetails.html.twig', array('form' => $form->createView(), 'jobSeeker' => $jobSeekerDetails, 'age' => $age));
    }

}
