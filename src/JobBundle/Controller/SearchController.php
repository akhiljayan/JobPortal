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

class SearchController extends Controller {

    public function mainJobSearchFormAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $jobEntity = new \JobBundle\Entity\Jobs();
        $jobType = new \JobBundle\Form\JobsSearchType();
        $form = $this->createForm($jobType, $jobEntity, array("action" => $this->generateUrl("main_job_search_form")));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $key = $form['jobTitle']->getData();
            $company = $form['company']->getData();
            $salaryRange = $form['salaryRange']->getData();
            if ($salaryRange) {
                $salary = explode(";", $salaryRange);
            } else {
                $salary = array(5000, 100000);
            }
            $experienceRange = $form['experienceRange']->getData();
            if ($experienceRange) {
                $experience = explode(";", $experienceRange);
            } else {
                $experience = array(0, 20);
            }
            $skillsRequired = $form['skillsRequired']->getData();
            $category = $form['category']->getData();
            if ($category) {
                $categoryId = $category->getId();
            } else {
                $categoryId = null;
            }
            $subCategory = $form['subCategory']->getData();
            if ($subCategory) {
                $subCategoryId = $subCategory->getId();
            } else {
                $subCategoryId = null;
            }

            $qb = $em->createQueryBuilder();
            $jobs = $qb->select('j')
                    ->from("JobBundle:Jobs", "j")
                    ->where("j.category = :cat")
                    ->orWhere("j.subCategory = :subcat")
                    ->orWhere('j.jobTitle LIKE :title OR j.jobDescription LIKE :desc OR j.jobDesignation LIKE :desig')
                    ->orWhere('j.skillsRequired LIKE :skills')
                    ->orWhere('j.company LIKE :cmpny')
                    ->orWhere('j.experYearFrom < :expFrm')
                    ->orWhere('j.exprYearTo > :expTo')
                    ->orWhere('j.slaryStart < :salFrm OR (j.slaryStart = 0 AND j.salaryTo=0)')
                    ->orWhere('j.salaryTo > :salTo OR  (j.slaryStart = 0 AND j.salaryTo=0)')
                    ->orderBy("j.addedDate", "DESC")
                    ->setParameter('title', '%' . $key . '%')
                    ->setParameter('desc', '%' . $key . '%')
                    ->setParameter('desig', '%' . $key . '%')
                    ->setParameter('skills', '%' . $skillsRequired . '%')
                    ->setParameter('cmpny', '%' . $company . '%')
                    ->setParameter('expFrm', $experience[0])
                    ->setParameter('expTo', $experience[0])
                    ->setParameter('salFrm', $salary[0])
                    ->setParameter('salTo', $salary[1])
                    ->setParameter('cat', $categoryId)
                    ->setParameter('subcat', $subCategoryId)
                    ->getQuery()
                    ->getResult();

            $formData = array(
                'Key' => $key,
                'Company' => $company,
                'Salary Range' => $salary[0] . " to " . $salary[1],
                'Experience Range' => $experience[0] . " to " . $experience[1],
                'Skills' => $skillsRequired,
            );
            return $this->render('JobBundle:JobSearch:showResults.html.twig', array('jobs' => $jobs, 'formData' => $formData));
        }
        return $this->render('JobBundle:JobSearch:mainSearchForm.html.twig', array('form' => $form->createView()));
    }

    public function mainResumeSearchFormAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('main_resume_search_form'))
                ->add('skills', 'hidden', array('attr' => array('class' => 'form-control', 'placeholder' => 'Skills')))
                ->add('experience', 'text', array(
                    'attr' => array('class' => 'experience_range'),
                    'mapped' => false,
                    'required' => false
                ))
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $skillsRequired = $form['skills']->getData();
            $experienceRange = $form['experience']->getData();
            if ($experienceRange) {
                $experience = explode(";", $experienceRange);
            } else {
                $experience = array(0, 20);
            }
            $qb = $em->createQueryBuilder();
            $goldenResumes = $qb->select('jr')
                    ->from('JobBundle:JobSeekerResume', 'jr')
                    ->innerJoin('JobBundle:JobSeeker', 'ap', 'WITH', 'jr.jobSeekerId = ap.id')
                    ->where('jr.skills LIKE :skills')
//                    ->orWhere('ap.experYearFrom < :expFrm')
//                    ->orWhere('ap.exprYearTo > :expTo')
                    ->orderBy("ap.firstName", "DESC")
                    ->setParameter('skills', '%' . $skillsRequired . '%')
//                    ->setParameter('expFrm', $experience[0])
//                    ->setParameter('expTo', $experience[0])
                    ->getQuery()
                    ->getResult();
            $formData = array(
                'Experience Range' => $experience[0] . " to " . $experience[1],
                'Skills' => $skillsRequired,
            );
            return $this->render('JobBundle:ResumeSearch:showResults.html.twig', array('applicants' => $goldenResumes, 'formData' => $formData));
        }
        return $this->render('JobBundle:ResumeSearch:mainSearchForm.html.twig', array('form' => $form->createView()));
    }

}
