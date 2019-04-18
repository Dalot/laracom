<?php

namespace App\Http\Controllers\Admin\Professors;

use App\Shop\Professors\Professor;
use App\Shop\Professors\Repositories\ProfessorRepository;
use App\Shop\Professors\Repositories\Interfaces\ProfessorRepositoryInterface;
use App\Shop\Professors\Requests\CreateProfessorRequest;
use App\Shop\Professors\Requests\UpdateProfessorRequest;
use App\Shop\Professors\Transformations\ProfessorTransformable;
use App\Http\Controllers\Controller;

class ProfessorController extends Controller
{
    use ProfessorTransformable;

    /**
     * @var ProfessorRepositoryInterface
     */
    private $professorRepo;

    /**
     * ProfessorController constructor.
     * @param ProfessorRepositoryInterface $professorRepository
     */
    public function __construct(ProfessorRepositoryInterface $professorRepository)
    {
        $this->professorRepo = $professorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->professorRepo->listProfessors('created_at', 'desc');

        if (request()->has('q')) {
            $list = $this->professorRepo->searchProfessor(request()->input('q'));
        }

        $professors = $list->map(function (Professor $professor) {
            return $this->transformProfessor($professor);
        })->all();


        return view('admin.professors.list', [
            'professors' => $this->professorRepo->paginateArrayResults($professors)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.professors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProfessorRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProfessorRequest $request)
    {
        $this->professorRepo->createProfessor($request->except('_token', '_method'));

        return redirect()->route('admin.professors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $professor = $this->professorRepo->findProfessorById($id);
        
        return view('admin.professors.show', [
            'professor' => $professor,
            'addresses' => $professor->addresses
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
        return view('admin.professors.edit', ['professor' => $this->professorRepo->findProfessorById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProfessorRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfessorRequest $request, $id)
    {
        $professor = $this->professorRepo->findProfessorById($id);

        $update = new ProfessorRepository($professor);
        $data = $request->except('_method', '_token', 'password');

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        $update->updateProfessor($data);

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.professors.edit', $id);
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
        $professor = $this->professorRepo->findProfessorById($id);

        $professorRepo = new ProfessorRepository($professor);
        $professorRepo->deleteProfessor();

        return redirect()->route('admin.professors.index')->with('message', 'Delete successful');
    }
}
