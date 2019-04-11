<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Shop\Schools\School;
use App\Shop\Schools\Repositories\SchoolRepository;
use App\Shop\Schools\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Shop\Schools\Requests\CreateSchoolRequest;
use App\Shop\Schools\Requests\UpdateSchoolRequest;
use App\Shop\Schools\Transformations\SchoolTransformable;
use App\Http\Controllers\Controller;

class SchoolController extends Controller
{
    use SchoolTransformable;

    /**
     * @var SchoolRepositoryInterface
     */
    private $schoolRepo;

    /**
     * SchoolController constructor.
     * @param SchoolRepositoryInterface $schoolRepository
     */
    public function __construct(SchoolRepositoryInterface $schoolRepository)
    {
        $this->schoolRepo = $schoolRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->schoolRepo->listSchools('created_at', 'desc');

        if (request()->has('q')) {
            $list = $this->schoolRepo->searchSchool(request()->input('q'));
        }

        $schools = $list->map(function (School $school) {
            return $this->transformSchool($school);
        })->all();


        return view('admin.schools.list', [
            'schools' => $this->schoolRepo->paginateArrayResults($schools)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSchoolRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSchoolRequest $request)
    {
        $this->schoolRepo->createSchool($request->except('_token', '_method'));

        return redirect()->route('admin.schools.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $school = $this->schoolRepo->findSchoolById($id);
        
        return view('admin.schools.show', [
            'school' => $school,
            'addresses' => $school->addresses
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
        return view('admin.schools.edit', ['school' => $this->schoolRepo->findSchoolById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSchoolRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchoolRequest $request, $id)
    {
        $school = $this->schoolRepo->findSchoolById($id);

        $update = new SchoolRepository($school);
        $data = $request->except('_method', '_token', 'password');

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        $update->updateSchool($data);

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.schools.edit', $id);
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
        $school = $this->schoolRepo->findSchoolById($id);

        $schoolRepo = new SchoolRepository($school);
        $schoolRepo->deleteSchool();

        return redirect()->route('admin.schools.index')->with('message', 'Delete successful');
    }
}
