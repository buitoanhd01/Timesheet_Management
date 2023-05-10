<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $listPositions = Position::getListPositions();
        return view('admin.position.position-list', compact('listPositions'));
    }

    public function showCreatePositionForm(Request $request)
    {
        return view('admin.position.position-create');
    }

    public function addNewPosition(Request $request)
    {
        $validate = $request->validate([
            'position_name' => ['required', 'string', 'max:255', 'unique:positions'],
            'position_description' => ['string'],
        ]);
        $position = new Position([
            'position_name' => $request->input('position_name'),
            'position_description' => $request->input('position_description'),
        ]);

        $position->save();
        return redirect()->route('admin-position-management')->with('success', 'Thêm Chức vụ thành công!');
    }

    public function showEditPositionForm(Request $request, $id)
    {
        $position = Position::find($id);
        return view('admin.position.position-edit',['position' => $position]);
    }

    public function editPosition(Request $request, $id)
    {
        $validate = $request->validate([
            'position_name' => ['required', 'string', 'max:255'],
            'position_description' => ['string'],
        ]);
        $position = Position::find($id);
        $position->position_name = $request->input('position_name');
        $position->position_description = $request->input('position_description');

        $position->save();
        return redirect()->route('admin-position-management')->with('success', 'Sửa Chức vụ thành công!');
    }
}
