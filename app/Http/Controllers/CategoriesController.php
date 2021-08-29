<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Db;


class CategoriesController extends Controller
{
   function addCategory(Request $req){

$cat = new Categories ; 

if($req->input('name')){

    $cat->cat_name = $req->input('name');

}
if($req->input('new_cat_name')){

    $cat->cat_name = $req->input('new_cat_name');

}



if($req->file('image')){
    $cat->cat_file  =  $req->file('image')->store('categories');
}

$cat->status = $req->input('status');
$cat->user_id = $req->input('user_id');
$cat->save();
 if($cat){
    return $cat;
}
else{
    return response([
        'result'=>['Failed']
    ]);
}

   }


function allCat(){
    return Categories::all();
}

function deleteCategory($id,$userId,$userRole){

     
    
if($userRole=='11'){
    return DB::table('categories')->where('id','=',$id)->delete();
}
else{
      $userCheck = DB::table('categories')->where('id','=',$id)->where('user_id','=',$userId)->delete();

      if($userCheck=='1'){
return 1;
      }
      else{
          return 0;
      }
}
     
  
 



}



function findCategory($id){
    return Categories::find($id) ;
}

function updateCategory($id,$userId,$userRole , Request $req){
    $cat =   Categories::find($id) ;
    


    if($req->input('name')){

        $cat->cat_name = $req->input('name');
    }
    if($req->file('image')){
        $cat->cat_file = $req->file('image')->store('categories');

    }
    if($req->input('status')){

        $cat->status = $req->input('status');
    }

if($userRole=='101'){
    $cat->save();
    return  1;
}
else{

 $checkUser= DB::table('categories')->where('id','=',$id)->where('user_id','=',$userId)->get();
 if(isset($checkUser[0])){
    $cat->save();
     return  1;
 }
 else{
     return 0;
 }


}
  
 
    
    
    
}


// End Update Category



// Start Status Change Cat 


function catStatusChange($id , $userId,$userRole){

$cat = Categories::find($id);
if($cat->status==1){
    $cat->status=0;
}
else{
    $cat->status=1;
}

if($userRole==10){
$cat->save();
return "t";
}else{
    $userCheck = DB::table('categories')->where('id','=',$id)->where('user_id','=',$userId)->get();

    if(isset($userCheck[0])){
        $cat->save();
    return "t";
    }else{
        return "f";
    }
 
}


 

 





}





















}
