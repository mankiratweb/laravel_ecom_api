<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcat;
use Illuminate\Support\Facades\Db;

class SubcatController extends Controller
{
    function addSubCategory(Request $req)
    {

        $subCat = new Subcat;

        $name= $req->input('name');
        $subCat->name = $req->input('name');
        $subCat->cat_id = $req->input('cat_id');
        $subCat->status = $req->input('status');
        $subCat->user_id = $req->input('user_id');
        $subCat->parent_id = $req->input('parent_id');


      $checkName = DB::table('subcats')->select('name')->where('name','=',$name)->get();

 $result = count($checkName);
 
        if ($result>0) {

            return response([
                "result" =>  $result,
"msg" => "already"
            ]);
           
        } else{

            $subCat->save();
            if ($subCat) {
                return response([
                    "result" => $subCat,
                    "msg" => 'inserted'
                ]);
            } else {
                return response([
                  
                    "msg" =>'error'
                ]);
            }
 
            
        }
    }









    function allSubCat()
    {


       $allsubCat= DB::table('subcats')->join('categories', 'categories.id', '=', 'subcats.cat_id')
            ->select('subcats.*', 'categories.cat_name')->get();

        if(isset($allsubCat[0])){
return response([
    'result'=>$allsubCat,
    'msg'=>'show_all_sub'
]);
        }else{
            return 
            response(['result'=>$allsubCat, 'msg'=>'show_not']);
        }
    }



    function findSubCategory($id)
    {
        $result= DB::table('subcats')->join('categories', 'categories.id', '=', 'subcats.cat_id')
            ->select('subcats.*', 'categories.cat_name')->where('subcats.id', '=', $id)->get();

        
 if(isset($result[0]->id)){
     return response([
         "result"=>$result,
         'msg'=>"get_single"
     ]);
 }else{
    return response([
        "result"=>$result,
        'msg'=>"no_single_found"
    ]);
 }


    }



    function updateSubCat($id, $userId, $userRole, Request $req)
    {

        $subCat = Subcat::find($id);




        if ($req->input('name')) {
            $subCat->name = $req->input('name');
        }

        if ($req->input('cat_id')) {
            $subCat->cat_id = $req->input('cat_id');
        }
        if ($req->input('status') == 1) {
            $subCat->status = 1;
        } else {
            $subCat->status = 0;
        }

        // return $req->input('status');



        $user_check = DB::table('subcats')->where('id', '=', $id)->where('user_id', '=', $userId)->get();
        if ($userRole == '101') {
        $result = $subCat->save();
       

            if($result==1){
                return response(["result"=>$subCat,"msg"=>"updated"]);
            }else if($result==0){
              return response(["msg"=>"not_updete"]);
            }
            
        }
         else if(isset($user_check[0])){
            $result= $subCat->save();
          
          if($result==1){
              return response(["result"=>$subCat,"msg"=>"updated"]);
          }else if($result==0){
            return response(["msg"=>"not_update"]);
          }
        }
        else{
            return response(["msg"=>"error" ]);
        }
    }



    //End update subcat 


    //Start Status Change Sub Cat

    function changeSubCatStatus($id, $userId, $userRole)
    {
        $subCat = Subcat::find($id);

        if ($subCat->status == 1) {
            $subCat->status = 0;
        } else {
            $subCat->status = 1;
        }


        $check_user = DB::table('subcats')->where('id', '=', $id)->where('user_id', '=', $userId)->get();
        
        if ($userRole == '101') {
            $result=   $subCat->save();
        if($result){

           
            return response(['result'=>$subCat,'msg'=>'status_changed']);
        }else{
            return response([ 'result'=>$subCat, 'msg'=>'not_changed']);
        }

        }
        
        
        
        
        else if(isset($check_user[0])) {
            $result=   $subCat->save();
            if($result){


                return response(['result'=>$subCat,'msg'=>'status_changed']);
            }else{
                return response(['result'=>$subCat,'msg'=>'not_changed']);
            }





        }
else{


    return response(['result'=>$subCat,'msg'=>'only_admin']);



}


    }

    // End Status Change 



    // Start Delete SubCat 
    function deleteSubCat($id, $userId, $userRole)
    {

        if ($userRole == '1001') {
         $result=   DB::delete("DELETE FROM `subcats` WHERE `subcats`.`id` = $id");
if($result==1){

    return  response([
        'result'=>$result,
        'msg'=>'deleted'
    ]);

}else if($result==0){

    return  response([
      
        'msg'=>'alerady_Delete'
    ]);

}else{
    return  response([
      
        'msg'=>'error'
    ]);
}
          


        } else {
            $result =  DB::delete("DELETE FROM `subcats` WHERE `subcats`.`id` = $id AND `subcats`.`user_id` = $userId");
            if($result==1){
                return  response([
                    'result'=>$result,
                    'msg'=>'deleted'
                ]);

            }else if($result==0){
                return  response([
                     'result'=>$result,
                    'msg'=>'already_delete'
                ]);
            }
            else{
                return  response([
                    'result'=>$result,
                    'msg'=>'error'
                ]);
            }

          
        }
    }






    function findSubCategoryProduct($id)
    {
        return DB::table('subcats')->where('cat_id', $id)->get();
    }
}