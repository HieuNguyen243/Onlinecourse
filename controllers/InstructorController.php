<?php
//chỗ này của NGUYÊN
class InstructorController {
    public function storeCourse() {
        $title = $_POST['title'];
        $courseModel = new CourseModel();
        $courseModel->createCourse($title, $_POST['description'], $_SESSION['user_id'], $_POST['category_id'], $_POST['price']);
        header("Location: index.php?controller=instructor&action=index");
        exit();
    }
    public function viewStudents($course_id) {
        $enrollmentModel = new EnrollmentModel();
        $students = $enrollmentModel->getStudentsByCourse($course_id);
        require_once 'views/instructor/student_list.php';
    }
    public function editCourse($id) {
        $courseModel = new CourseModel();
        $course = $courseModel->getCourseById($id);
        
        if (!$course) { die("Khóa học không tồn tại"); }
        require_once 'views/instructor/edit_course.php';
    }
    public function updateCourse() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $courseModel = new CourseModel();
            $courseModel->updateCourse(
                $_POST['id'], 
                $_POST['title'], 
                $_POST['description'], 
                $_POST['category_id'], 
                $_POST['price']
            );
            header('Location: index.php?controller=Instructor&action=courses');
            exit();
        }
    }
    public function deleteCourse($id) {
        $courseModel = new CourseModel();
        $courseModel->deleteCourse($id);
       header('Location: index.php?controller=Instructor&action=courses');
       exit();
    }
}


?>