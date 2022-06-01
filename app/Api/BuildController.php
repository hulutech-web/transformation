<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBuildRequest;
use App\Http\Requests\UpdateBuildRequest;
use App\Models\Build;
use App\Models\BuildRecord;
use Illuminate\Http\Request;

class BuildController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //分页查询
        //仅取指定列

        $builds = Build::select('id', 'name',
            'project_name', 'property_company_name', 'owner_committee_name'
            , 'project_introducer', 'building_area', 'project_unit_name', 'build_time', 'project_builder_name')->paginate(10);
//        $builds = Build::paginate(10);
        return $builds;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreBuildRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBuildRequest $request)
    {
        $build = Build::create($request->input());
        //project_additional_information的值不为空，且与之前的值不一致，则更新project_additional_information

        if (!is_null($request->project_additional_information)) {
            BuildRecord::create(['build_id' => $build->id, 'content' => $build->project_additional_information]);
        }
        return $this->message('添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Build $build
     * @return \Illuminate\Http\Response
     */
    public function show(Build $build)
    {
        return $build;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateBuildRequest $request
     * @param \App\Models\Build $build
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBuildRequest $request, Build $build)
    {
        $build->update($request->input());
        //仅判断，当project_additional_information的值不为空，且与之前的值不一致，则新增BuildRecord一条历史记录
        if (!is_null($request->project_additional_information)
            && $this->isDifferentRecord($build, $request->project_additional_information)) {
            BuildRecord::create(['build_id' => $build->id, 'content' => $build->project_additional_information]);
        }
        return $this->message('修改成功');
    }

    protected function isDifferentRecord(Build $build, $content)
    {
        $builds = BuildRecord::where('build_id', $build->id)->get();

        return !collect($builds)->contains(function ($item) use ($content) {
            return $item->content == $content;
        });

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Build $build
     * @return \Illuminate\Http\Response
     */
    public function destroy(Build $build)
    {
        $build->delete();
        return $this->message('删除成功');
    }

    public function searchBuild(Request $request)
    {
        $builds = Build::where('name', 'like', '%'.$request->keywords.'%')
            ->orWhere('project_name', 'like', '%'.$request->keywords.'%')
            ->paginate(20);
        return $builds;
    }

    public function list()
    {
        //返回id与name字段
        $builds = Build::select(['id', 'name'])->with('units')->get(['id', 'unit_number', 'unit_name']);
        return $builds;
    }
}
