<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use Illuminate\Support\Facades\Db;

class TagController extends Controller
{
    function addTag(Request $req){

$tag = new Tags ; 
$name = $req->name;
$tag->name = $req->name;
$tag->cat_id = $req->cat_id;
$tag->user_id = $req->user_id;
$tag->status = 1;


        $tagCheck = DB::table('tags')->select('name')->where('name','=',$name)->get();


        $result = count($tagCheck);
if($result>0){

  
    return   response([
        'msg'=>"already",
                "result" => $tag
            ]);



}else{

$tag->save();

    if(isset($tag)) {
                return   response([
            'msg'=>"update",
                    "result" => $tag
                ]);
             
            }
             else {
                return  response([
                    'msg'=>"error",
                            "result" => $tag
                        ]);
            }






}

 



 


 
 
  
    
     

    }







    function allTag(){
        return DB::table('tags')->get();
    
    }

    function deleteTag($id,$user_id){

    $result =     DB::table('tags')->join('users','users.id','=' ,'tags.user_id')
        ->where('tags.id','=',$id)->where('tags.user_id','=', $user_id)->orwhere('users.role','=','1')->where('tags.id','=',$id)
        ->delete();

 

        if(isset($result)){
            return  $result;
       }
        else{
  
            return ["result"=>"Opration Failed"];
        }



        
    }
    
    

    
    // Change Status Start
    
    function changeStatus($id,$userId){

        $tag = Tags::find($id);
        
        if($tag->status==1){
            $tag->status = 0;
        }else{
            $tag->status = 1;
        }
        
        
        
        $role = DB::table('tags')->join('users','users.id','=','tags.user_id')
        ->select('users.role')->where('users.id','=',$userId)->where('users.role','=',101)->first();
        
        if($role){
            
                     $tag->save();
}
else{
  
    
    $user = DB::select("select * from  tags where user_id = $userId AND id=$id");

if($user){
    $tag->save();




}else{
    return 0;
}

    
}


 
  
   
  }

// Change Status End  




function findTag($id,$userId){

    $role = DB::table('tags')->join('users','users.id','=','tags.user_id')
    ->select('users.role')->where('users.id','=',$userId)->where('users.role','=',101)->first();
    
    if($role){
        
     $tag =    DB::table('tags')->join('categories','categories.id','=','tags.cat_id')
        ->select('tags.*','categories.cat_name')->where('tags.id','=',$id)->get();

    return     $tag ;

             
}
else{

    $user = DB::select("select * from  tags where user_id = $userId AND id=$id");

    if($user){
        $tag =    DB::table('tags')->join('categories','categories.id','=','tags.cat_id')
        ->select('tags.*','categories.cat_name')->where('tags.id','=',$id)->get();

    return     $tag ;
    
    }else{
        return 0;
    }


    
}







}



// Update Tag Start
function updateTag($id,$user_id,Request $req){



    $role = DB::table('tags')->join('users','users.id','=','tags.user_id')
    ->select('users.role')->where('users.id','=',$user_id)->where('users.role','=',101)->first();
    $name = $req->input('name');
 

$tag = Tags::find($id);

if($req->input('cat_id')){
    
    $tag->cat_id = $req->input('cat_id');
}
if($req->input('name')){
    $tag->name = $name;

}
if($req->input('status')==0){

    $tag->status  = 0;
}
else{
    $tag->status  = 1;
}



if($role){
return $tag->save();


}
else{
    
    $user = DB::select("select * from  tags where user_id = $user_id AND id = $id");


if($user){
  return  $tag->save();
}else{
return 0;
}

     
 
    
}



 

}

// CUpdatev Tag end



























}