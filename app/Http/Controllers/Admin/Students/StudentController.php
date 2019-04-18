<?php

namespace App\Http\Controllers\Admin\Students;

use App\Shop\Students\Student;
use App\Shop\Students\Repositories\StudentRepository;
use App\Shop\Students\Repositories\Interfaces\StudentRepositoryInterface;
use App\Shop\Students\Requests\CreateStudentRequest;
use App\Shop\Students\Requests\UpdateStudentRequest;
use App\Shop\Students\Transformations\StudentTransformable;
use App\Shop\Students\Transformations\StudentProfessorTransformable;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    use StudentTransformable;
    use StudentProfessorTransformable;

    /**
     * @var StudentRepositoryInterface
     */
    private $studentRepo;

    /**
     * StudentController constructor.
     * @param StudentRepositoryInterface $studentRepository
     */
    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepo = $studentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->guard('employee')->user();
        $is_professor = $user->hasRole('professor');
        
        if( $is_professor ) {
            $id = $user->professor->id;
            
            $list = $this->studentRepo->listStudentsByProfessor('created_at',  $id);
            
            $students = $list->map(function (Student $student) {
            return $this->transformStudent($student);
        })->all();
        
       
        return view('admin.students.list', [
            'students' => $this->studentRepo->paginateArrayResults($students),
            'professor' => $is_professor,
        ]);
        }
        else {
            $list = $this->studentRepo->listStudents('created_at', 'desc');
        
       
        if (request()->has('q')) {
            $list = $this->studentRepo->searchStudent(request()->input('q'));
        }

        
        $students = $list->map(function (Student $student) {
                return $this->transformStudentProfessor($student);
            })->all();
           
            return view('admin.students.list', [
                'students' => $this->studentRepo->paginateArrayResults($students),
                'professor' => $is_professor,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        return view('admin.students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateStudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStudentRequest $request)
    {
        $user = auth()->guard('employee')->user();
        $professor = $user->professor;
        $school_id = $professor->school->id;
        $professor_id = $professor->id;
        
        $student = $this->studentRepo->createStudentByProfessor($request->except('_token', '_method'), $school_id, $professor_id);
        
        return redirect()->route('admin.students.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $student = $this->studentRepo->findStudentById($id);
        
        return view('admin.students.show', [
            'student' => $student,
            'addresses' => $student->addresses
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.students.edit', ['student' => $this->studentRepo->findStudentById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStudentRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        $student = $this->studentRepo->findStudentById($id);

        $update = new StudentRepository($student);
        $data = $request->except('_method', '_token', 'password');

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        $update->updateStudent($data);

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.students.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $student = $this->studentRepo->findStudentById($id);

        $studentRepo = new StudentRepository($student);
        $studentRepo->deleteStudent();

        return redirect()->route('admin.students.index')->with('message', 'Delete successful');
    }
}
