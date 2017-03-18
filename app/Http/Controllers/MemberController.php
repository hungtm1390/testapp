<?php

namespace App\Http\Controllers;

use App\Members;
use Illuminate\Http\Request;
use App\Http\Requests\MemberPostRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth,DateTime,File;
use Illuminate\Http\Response;


class MemberController extends Controller
{
    //get all member from members table
    public function getMemberList()
    {
        $members = Members::select('id','name','address','age','photo')->orderby('id','desc')->paginate(5);
        return response()->json($members);
    }


    //get details member
    public function detailsMember($member_id){
        return $details_member = Members::find($member_id);
    }


    //add member
    public function addMember(MemberPostRequest $request)
    {
        $member = new Members();
        $member->name = $request->name;
        $member->address = $request->address;
        $member->age = $request->age;
        //upload file
        $file = $request->file('photo');
        if (count($file) > 0) {
            $filename = time().'.'.$file->getClientOriginalName();
            $destinationPath = 'upload/img/member/';
            $file->move($destinationPath,$filename);
            $member->photo = $filename;
        }
        if($member->save()){
            return
                response()->json([
                                    'status' => true,
                                    'message' => 'Add new member success !'
                                ]);
        }else{
            response()->json([
                                    'status' => false,
                                    'message' => 'Get Message Validate Form Input'
                                ]);
        }
    }

    //Update Record
    public function updateMember(Request $request,$id ){
        $member 				= Members::find($id);
        $member->name = $request->name;
        $member->address = $request->address;
        $member->age = $request->age;
        //upload file
        $file = $request->file('photo');
        if (count($file) > 0) {
            $filename = time().'.'.$file->getClientOriginalName();
            $destinationPath = 'upload/img/member/';
            $file->move($destinationPath,$filename);
            $member->photo = $filename;
        }
        if($member->save()){
            return
                response()->json([
                    'status' => true,
                    'message' => 'Update member success !'
                ]);
        }else{
            response()->json([
                'status' => false,
                'message' => 'Get Message Validate Form Input'
            ]);
        }
    }


    //Delete Record
    public function deleteMember(Request $request ){
        $this->validate($request, [
            'id' => 'required|exists:members'
        ]);
        $member = Members::findOrFail($request->input('id'));
        if (file_exists('upload/img/member/'.$member->photo))
        {
            File::delete('upload/img/member/'.$member->photo);
        }
        $member->delete();
        return "Success deleting user #".$request->input('id');
    }


    //funcion test phpunit
    public function getName(){
        return "Tran Hung";
    }

}

