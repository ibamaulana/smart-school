<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Get authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function current(Request $request)
    {   
        $user = User::where('id',$request->user()->id)->with('school','role')->first();
        return response()->json($user);
    }

    public function data(Request $request)
    {   
        $user = User::with('school','role');
        if($request->role_id){
            $user = $user->where('role_id',$request->role_id);
        }
        return response()->json($user->paginate());
    }

    public function detail($id)
    {   
        $user = User::with('school','role')->where('id',$id);
        return response()->json($user->first());
    }

    public function submit(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email:filter|max:255|unique:users',
            'role' => 'required'
        ])->validate();
        $password = $request->username.rand(0,100);
        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->school_id = $request->user()->school_id;
        $user->role_id = $request->role;
        $user->password = bcrypt($request->username.$password);

        if($user->save()){
            return response()->json([
                'status' => 'Success !',
                'messsage' => 'Data Created'
            ]);
        }else{
            return response()->json([
                'status' => 'Error !',
                'messsage' => 'Something goes wrong'
            ]);
        }
    }

    public function update(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,'.$request->id,
            'email' => 'required|email:filter|max:255|unique:users,email,'.$request->id,
            'role' => 'required'
        ])->validate();

        $user = User::where('id',$request->id)->first();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->role_id = $request->role;

        if($user->update()){
            return response()->json([
                'status' => 'Success !',
                'messsage' => 'Data Updated'
            ]);
        }else{
            return response()->json([
                'status' => 'Error !',
                'messsage' => 'Something goes wrong'
            ]);
        }
    }

    public function delete(Request $request)
    {   
        $user = User::where('id',$request->id)->first();

        if($user->delete()){
            return response()->json([
                'status' => 'Success !',
                'messsage' => 'Data Deleted'
            ]);
        }else{
            return response()->json([
                'status' => 'Error !',
                'messsage' => 'Something goes wrong'
            ]);
        }
    }
}
