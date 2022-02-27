<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 12.10.2020
 * Time: 10:05
 */

namespace App\Controller\Courses;


use App\Entity\Courses;
use App\Entity\Module;
use App\Entity\Lesson;
use App\Entity\Supportfiles;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{
    /**
     * @Route("modules/{module}/lessons", name="lessons", requirements={"module"="\d+"})
     */
    public function indexAction(Module $module){
        $lessons = $this->getDoctrine()->getRepository(Lesson::class)->findBy(['module'=>$module], ['id'=>'asc']);
        return $this->render("courses/lessons.html.twig", array(
            "lessons" => $lessons,
            "module" => $module
        ));
    }
    /**
     * @Route("modules/{module}/lessons/{lesson}", name="lesson", requirements={"module"="\d+", "lesson"="\d+"})
     */
    public function lessonAction(Module $module, Lesson $lesson){
        $lessons = $this->getDoctrine()->getRepository(Lesson::class)->findBy(['module'=>$module], ['id'=>'asc']);
        return $this->render("courses/lesson.html.twig", array(
            "lessons" => $lessons,
            "module" => $module,
            "lesson" => $lesson
        ));
    }

    /**
     * @Route("modules/{module}/lessons/new", name="new_lesson", requirements={"module"="\d+"})
     */
    public function newLessonAction(Request $request, Module $module){
        $em = $this->getDoctrine()->getManager();
        $lesson = new Lesson();
        $lesson = $this->validateLessonForm($request, $lesson);
        if(get_class($lesson)!= Lesson::class)
            return $lesson;
        $lesson->setModule($module);
        $course = $module->getCourses();
        $course->setNblesson($course->getNblesson()+1);
        $em->persist($lesson);
        $em->persist($course);
        $em->flush();
        if($request->files->get('files')){
            $lesson = $em->getRepository(Lesson::class)->find($lesson->getId());
            try{
                $paths = $this->uploadFiles($request->files->get('files'), $this->getParameter("supports_courses_directory"));
                foreach ($paths as $path){
                    $supportFile = new Supportfiles();
                    $supportFile->setPath($path);
                    $supportFile->setLesson($lesson);
                    $em->persist($supportFile);
                    $em->flush();
                }
            }catch (\Exception $e){
                return new JsonResponse(array("status"=>1, "mes"=>$e->getMessage()));
            }
        }

        return new JsonResponse(array(
            "status"=>0,
            "mes"=>"Leçon ajoutée avec succès"
        ));
    }

    /**
     * @Route("modules/{module}/lessons/{lesson}edit", name="edit_lesson", requirements={"module"="\d+", "lesson"="\d+"})
     */
    public function editLessonAction(Request $request, Module $module, Lesson $lesson){

        $em = $this->getDoctrine()->getManager();
        $lesson = $this->validateLessonForm($request, $lesson);
        if(get_class($lesson)!= Lesson::class)
            return $lesson;
        $lesson->setModule($module);
        $em->persist($lesson);
        $em->flush();
        return new JsonResponse(array(
            "status"=>0,
            "mes"=>"Leçon modifiée avec succès"
        ));
    }


    /**
     * @Route("modules/{module}/lessons/{lesson}/delete", name="delete_lesson", requirements={"module"="\d+", "lesson"="\d+"})
     */
    public function deleteLessonAction(Module $module, Lesson $lesson){

        $em = $this->getDoctrine()->getManager();
        $course = $module->getCourses();
        $course->setNblesson($course->getNblesson()-1);
        $em->remove($lesson);
        $em->persist($course);
        $files = $em->getRepository(Supportfiles::class)->findBy(['lesson'=>$lesson]);
        $this->deleteAllSupportFiles($files, $em);
        try{
            $em->flush();
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Leçon supprimée avec succès"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Impossible de supprimer cette leçon"
            ));
        }
    }

    private function deleteEntityCollection($entities, ObjectManager $em){
        if(!empty($entities)){
            foreach ($entities as $entity) {
                $em->remove($entity);
                $em->flush();
            }
        }
    }


    /**
     * @Route("lessons/{lesson}/files/{supportfiles}/delete", name="delete_support_files", requirements={"lesson"="\d+", "supportfiles"="\d+"})
     */
    public function deleteSupportFile(Lesson $lesson, Supportfiles $supportfiles){

        $em = $this->getDoctrine()->getManager();
        $em->remove($supportfiles);
        try{
            $em->flush();
            $this->removeFile($this->getParameter("supports_courses_directory").$supportfiles->getPath());
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Fichier supprimé avec succès"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Impossible de supprimer ce fichier"
            ));
        }
    }


    /**
     * @Route("lessons/{lesson}/files/new", name="add_support_files", requirements={"lesson"="\d+"})
     */
    public function addSupportFiles(Lesson $lesson, Request $request){
        $em = $this->getDoctrine()->getManager();
        try{
            $file = new Supportfiles();
            $file->setLesson($lesson);
            $paths = $this->uploadFiles($request->files->get('files'), $this->getParameter("supports_courses_directory"));
            foreach ($paths as $path){
                $supportFile = new Supportfiles();
                $supportFile->setPath($path);
                $supportFile->setLesson($lesson);
                $em->persist($supportFile);
                $em->flush();
            }
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Fichiers ajoutés avec succès"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Une erreur est survenue"
            ));
        }
    }

    private function deleteAllSupportFiles($files, ObjectManager $em){
        foreach ($files as $file){
            $em->remove($file);
            $em->flush();
            $this->removeFile($this->getParameter("supports_courses_directory").$file->getPath());
        }
    }


    private function validateLessonForm(Request $request, Lesson $lesson){
        $post = $request->request;
        $title = $post->get("title");
        $smallDescription = $post->get("smallDescription");
        $description = $post->get("description");
        $duration = $post->get("duration");
        $video = $post->get("video");

        if($title == "" || $title ==  null)
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez le titre de la leçon"));
        if($smallDescription == "" || $smallDescription ==  null)
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez l'aperçu de la leçon"));
        if($description == "" || $description ==  null)
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez le contenu de la leçon"));
        if( $duration == "" || $duration == null)
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez la durée de la leçon"));
        if( $video == "" || $video == null)
            return new JsonResponse(array("status"=>1, "mes"=>"Ajoutez la vidéo de la leçon"));
        return $this->saveLesson($lesson, $title, $smallDescription, $description, $duration, $video);
    }

    private function saveLesson(Lesson $lesson, $title, $smallDescription, $description, $duration, $video): Lesson{
        $lesson->setTitle($title);
        $lesson->setSmalldescription($smallDescription);
        $lesson->setDescription($description);
        $lesson->setDuration($duration);
        $lesson->setVideo($video);
        return $lesson;
    }

    /**
     * @param UploadedFile $file
     * @throws \Exception
     */
    private function uploadOneFile(UploadedFile $file, $directory) {
        $fileName = $this->getUniqueFileName().".".$file->guessExtension();
        $file->move($directory, $fileName);
        return $fileName;
    }

    /**
     * @param UploadedFile $file
     * @throws \Exception
     */
    private function uploadVideo(UploadedFile $file){
        $imageAccepted = array("mp4", "avi");
        if( in_array(strtolower($file->guessExtension()), $imageAccepted) ){
            $fileName = $this->getUniqueFileName().".".$file->guessExtension();
            $file->move($this->getParameter("videos_courses_directory"), $fileName);
            return $fileName;
        }else{
            throw new \Exception("Format de vidéo incorrect", 100);
        }
    }

    /**
     * @param array $files
     * @throws \Exception
     */
    private function uploadFiles($files, $dir): array {
        $paths = [];
        if(empty($files))
            return $paths;
        foreach ($files as $file){
            $path = $this->uploadOneFile($file, $dir);
            array_push($paths, $path);
        }
        return $paths;
    }

    private function removeFile($path){
        if(file_exists($path) && fileperms($path) == 0)
            unlink($path);
    }

    private function getUniqueFileName(){
        return md5(uniqid());
    }
}